# Vulnsocket


**Vulnsocket** is a vulnerable **websocket** machine.This machine has two different vulnerabilities:

 * CSWSH (Cross Site WebSocket Hijacking)
 * Reflected XSS

And this machine shows you how to close these vulnerabilities.

Requirements:

 * Python 3
 * PHP 8
 * MYSQL


### Web Site Setup in XAMP (Windwos-Linux-MacOs)
1. [Download](https://github.com/Serhatcck/vulnsocket.git).

    You should download the project files to your xampp htdocs(C:\xampp\htdocs\ or /opt/xamp/htdocs etc.) folder.
    
    ```git
    git clone  https://github.com/Serhatcck/vulnsocket.git
    ```
    
2. You should create a database named "web_socket" in MySQL.
3. You have to edit the configuration in database.php file  
    ```php
    $host = "localhost";
	$user = "root";
	$pass = "root";
	$dbname = "web_socket";
    ```
4. You should visit http://localhost/vulnsocket/db_reset.php to create database tables and add rows.
  

### Python Setup
1. Install Requirements
   ```pip
   pip3 install -r requirements.txt
   ```
2. You have to edit the configuration in socket_servers/DB.py file
   ```python
    host = "localhost"
    user = "root"
    passwd = "root"
    db = "web_socket"
   ```

If you get an error in cswsh_exploit.py, check:
* Are the selenium drivers in the Selenium Driver folder correct?
* Do you install selenium in python3 ?

### Walkthrough


