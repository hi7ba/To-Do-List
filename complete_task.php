<?php
session_start();
include 'auth_check.php';
include 'db_connection.php';
header("Content-Type: application/json");

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['task_id'])) {
    echo json_encode(["error" => "Task ID required"]);
    exit;
}

$task_id = $data['task_id'];
$user_id = $_SESSION['user_id'];

$sql = "UPDATE tasks SET completed = 1 WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $task_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Task marked as completed"]);
} else {
    echo json_encode(["error" => "Error updating task"]);
}

$stmt->close();
$conn->close();
?>
