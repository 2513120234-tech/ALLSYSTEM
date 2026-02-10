<?php
ini_set('display_errors', 0);

$servername = "localhost";
$username = "root";
$password = ""; 
 
try {
  $condb = new PDO("mysql:host=$servername;dbname=ALL_System;charset=utf8", $username, $password);
  // set the PDO error mode to exception
  $condb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>