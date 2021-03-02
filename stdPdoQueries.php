<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "fklmarketplacebdd.cc1bxeyzmpqb.eu-west-1.rds.amazonaws.com";
$username = "admin";
$password = "FraktalPassword";

try {
  $pdo = new PDO("mysql:host=$servername;dbname=fraktalDB", $username, $password);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully"."<br />";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
};



?>

