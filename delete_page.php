<?php
session_start();
include 'auth_check.php';
include 'db_connection.php';
header("Content-Type: application/json");

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['page_id'])) {
    echo json_encode(["error" => "Page ID required"]);
    exit;
}

$page_id = $data['page_id'];
$user_id = $_SESSION['user_id'];

$delete_tasks = "DELETE FROM tasks WHERE page_id = ? AND user_id = ?";
$stmt1 = $conn->prepare($delete_tasks);
$stmt1->bind_param("ii", $page_id, $user_id);
$stmt1->execute();

$delete_page = "DELETE FROM pages WHERE id = ? AND user_id = ?";
$stmt2 = $conn->prepare($delete_page);
$stmt2->bind_param("ii", $page_id, $user_id);

if ($stmt2->execute()) {
    echo json_encode(["message" => "Page deleted successfully"]);
} else {
    echo json_encode(["error" => "Error deleting page"]);
}

$stmt2->close();
$conn->close();
?>
