import base64
from curses import newpad
import hashlib
from operator import contains
import socket
import threading
from time import sleep

from requests import session
import json
import re
import DB

class User:
    userId = ""
    userEmail = ""
    userName = ""
    userSurname = ""
    session = ""
    conn = None
    addr = None
    def __init__(self,userId,userEmail,sessionId,csrfToken):
        self.userId = userId
        self.userEmail = userEmail
        self.sessionId = sessionId
        self.csrfToken = csrfToken
    

    def getUserInfo(self):
        db = DB.DB()
        userInfo = db.select("Select * from users WHERE id="+str(self.userId))
        print(userInfo)
        self.userName = userInfo[0][2]
        self.userSurname = userInfo[0][3]

    def setPasswd(self,passwd):
        db = DB.DB()
        hash = hashlib.sha256(passwd.encode())

        sql = "UPDATE users SET password = '"+hash.hexdigest()+"' WHERE id = '"+str(self.userId)+"'"
        db.execute(sql)
        

class SocketEx:
    GUID = '258EAFA5-E914-47DA-95CA-C5AB0DC85B11'
    UPGRADE_RESP = "HTTP/1.1 101 Switching Protocols\r\n" + \
        "Upgrade: websocket\r\n" + \
        "Connection: Upgrade\r\n" + \
        "Sec-WebSocket-Accept: %s\r\n" + \
        "\r\n"
    UNAUTHORIZED_RESP = "HTTP/1.1 401 Unauthorized"+\
        "Content-Type: text/html"
    
    connectedUsers = []
    iterator = 1


    def handleConnection(self, conn, addr):
        print('Connected to: ' + addr[0] + ':' + str(addr[1]))
        # handshake in tamamlanması için gereken HTTP 101 yanıtı döndürülür
        user = self.endHandshake(conn)
        if user:
            print("Handshake Finished: "+str(addr[1]))

            #sleep(1)
            self.sendData(conn,'{"senderId":"0","senderEmail":"server","data":"Welcome '+user.userEmail+'"}')
            # socket sonsuza kadar dinlenir.
            while True:
                # data alınır.
                data = self.recvData(conn)
                if data:
                    print("received from: "+addr[0] +
                        " / received data: [%s]" % (data))
                    sendData = {}
                    sendData['senderId'] = user.userId
                    sendData['senderEmail'] = user.userEmail 
                    sendData['data'] = data
                    self.sendAllUsers(json.dumps(sendData))
        else:
            #401 UNAUTHORİZED
            conn.send(str.encode(self.UNAUTHORIZED_RESP))
            print("401 UNAUTHORIZED")


    def createResp(self,type,user):
        if type == "profile":
            user.getUserInfo()
            
            return ["Your Profile:","Your userId:"+str(user.userId),"Your Name:"+user.userName,"Your Surname:"+user.userSurname]

        elif "setPassword:" in type: 
            newPasswd = " ".join(re.findall("\{.*\}",type))
            newPasswd = newPasswd.replace('{','')
            newPasswd = newPasswd.replace('}','')
            user.setPasswd(newPasswd)
            return ["Your new password:"+newPasswd]

        else :
            return ["Your choise is wrong"]
 

    def sendAllUsers(self, data):
        for user in self.connectedUsers:
            # veri gönderilir
            self.sendData(user.conn, data)

    def sendData(self, conn, data):
        # veri WebSocket çerçevesine göre ayarlanır ve gönderilir.
        # 1st byte: fin bit set. text frame bits set.
        # 2nd byte: no mask. length set in 1 byte.
        resp = bytearray([0b10000001, len(data)])
        # append the data bytes
        for d in bytearray(data.encode('utf-8')):
            resp.append(d)

        conn.send(resp)

    def recvData(self, conn):
        data = bytearray(conn.recv(10240))
        if data:
            # gelen data websocket çerrçeve yapısına göre ayrıştırılır
            assert(0x1 == (0xFF & data[0]) >> 7)
            # data must be a text frame
            # 0x8 (close connection) is handled with assertion failure
            assert(0x1 == (0xF & data[0]))

            # assert that data is masked
            assert(0x1 == (0xFF & data[1]) >> 7)
            datalen = (0x7F & data[1])
            stringData = ''
            if(datalen > 0):
                # maskelenmiş veri çözümlenir.
                mask_key = data[2:6]
                masked_data = data[6:(6+datalen)]
                unmasked_data = [masked_data[i] ^ mask_key[i % 4]
                                 for i in range(len(masked_data))]
                stringData = bytearray(unmasked_data)
            return stringData.decode()
        return ""

    def endHandshake(self, conn):
        data = conn.recv(1024)
        data = data.decode('utf-8')
        # gelen istekteki HTTP header ları ayrıştırılır
        headers = self.splitHeaders(data)
        
        cookies = self.splitCookie(headers["Cookie"])
        
        user = self.checkSessionId(cookies['PHPSESSID'])
        if user:
            if user.csrfToken != headers['params']['token']:
                return False
            # "Sec-WebSocket-Accept" değeri ile birlikte yanıt edilir
            respData = self.calcSecWebSocketAccept(headers["Sec-WebSocket-Key"])
            # yanıt socket üzerinden gönderilir
            conn.send(str.encode(respData))


            user.conn = conn
            self.iterator += 1
            self.connectedUsers.append(user)
            return user
        else :
            return False

    def checkSessionId(self,sessionId):
        db = DB.DB()
        sessions = db.select("SELECT * FROM sessions WHERE session_id='"+sessionId+"'")
        if sessions:
            userinfo = json.loads(sessions[0][1])
            user = User(userinfo['userId'],userinfo['userEmail'],sessions[0][0],userinfo['token'])
            
            #delete token value
            userinfo['token'] = ''
            db.execute("UPDATE sessions SET session_val = '"+json.dumps(userinfo)+"' WHERE session_id = '"+sessionId+"'")
            return user
        else :
            return False    


    def calcSecWebSocketAccept(self, key):
        key = key + self.GUID
        # istete gelen değer GUID ile birleştiril sha1 karması alınır. Hexe dönüştürülür ve base64 kodlanır
        respKey = base64.standard_b64encode(
            hashlib.sha1(key.encode('utf-8')).digest())
        respData = self.UPGRADE_RESP % respKey.decode('utf-8')
        return respData

    def splitHeaders(self, data):
        # Başlıklar satır satır bölünür
        headers = data.split("\r\n")
        headerDict = {}
        firtsLine = headers[0].split(" ")
        headerDict['method'] = firtsLine[0]
        headerDict['httpVersion'] = firtsLine[2]
        uri = firtsLine[1].split("?")
        headerDict['uri'] = uri[0]
        if len(uri) > 1:
            #request have query string
            headerDict['params'] = self.splitQuery(uri[1])

        for h in headers:
            # each line split ":"
            parseHeader = h.split(":")
            if len(parseHeader) > 1:
                headerDict[str(parseHeader[0]).strip()] = str(parseHeader[1]).strip()
        return headerDict

    def splitQuery(self,query):
        params = query.split("&")
        paramDict = {}
        for p in params:
            parseParam = p.split("=")
            paramDict[str(parseParam[0])] = str(parseParam[1])

        return paramDict

    def splitCookie(self, data):
        cookies = data.split(" ")
        cookieDict = {}
        for cookie in cookies:
            c = cookie.split("=")

            cookieDict[str(c[0]).strip()] = str(c[1]).strip()

        return cookieDict

    def startServer(self, host, port):
        # server ayağa kaldırılır
        serverSocket = socket.socket()
        serverSocket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        try:
            serverSocket.bind((host, port))
        except socket.error as e:
            print(str(e))
        print(f'Server is listing on the port {port}...')
        # en fazla 10 bağlantı alınabileceği bildirilir
        serverSocket.listen(10)
        while True:
            # istek kabul edilir
            conn, addr = serverSocket.accept()
            # kabul edilen istek bir thread içinde handleConnection fonksiyonuna gönderilir
            threading.Thread(target=self.handleConnection,
                             args=(conn, addr)).start()





sc = SocketEx()
sc.startServer('127.0.0.1', 8587)
