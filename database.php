<?php
$host = "localhost";
$user = "root";
$pass = "root";
$dbname = "web_socket";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e)
{
  echo $e->getMessage();                         
}

?>