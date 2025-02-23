<?php
include 'db_connection.php';
header('Content-Type: application/json');

$sql = "SELECT id, title, description FROM tasks";
$result = $conn->query($sql);

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

echo json_encode($tasks);
?>
