<?php 

require('database.php');

$sqlQuery = file_get_contents('database.sql','r');

$err = $conn->exec($sqlQuery);

print_r($err);