<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo_app";


$conn = new mysqli($servername, $username, $password, $dbname);

// Just Checkings
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>