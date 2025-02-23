<?php
session_start();
include 'auth_check.php'; 
include 'db_connection.php';
header("Content-Type: application/json");

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['title'])) {
    echo json_encode(["error" => "Title is required"]);
    exit;
}

$title = $data['title'];
$user_id = $_SESSION['user_id']; 

$sql = "INSERT INTO pages (title, user_id, created_at) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $title, $user_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Page added successfully"]);
} else {
    echo json_encode(["error" => "Error adding page"]);
}

$stmt->close();
$conn->close();
?>
