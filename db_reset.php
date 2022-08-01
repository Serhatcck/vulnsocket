<?php 

require('database.php');

$sqlQuery = file_get_contents('database.sql','r');

$conn->query($sqlQuery);