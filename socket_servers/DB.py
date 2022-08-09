import mysql.connector  # requirements
class DB:
    host = "localhost"
    user = "root"
    passwd = "root"
    db = "web_socket"
    connection = None

    def __init__(self):
        self.connection = mysql.connector.connect(
            host=self.host,
            user=self.user,
            password=self.passwd,
            database=self.db
        )
    
    def select(self,query):
        cursor = self.connection.cursor()
        cursor.execute(query)
        result = cursor.fetchall()   
        cursor.close()     
        return result
    
    def execute(self,query):
        cursor = self.connection.cursor()
        cursor.execute(query)
        self.connection.commit()