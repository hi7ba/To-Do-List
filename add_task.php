<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $page_id = $_POST['page_id'];
    $title = $_POST['title'];

    if (!empty($page_id) && !empty($title)) {
        $stmt = $conn->prepare("INSERT INTO tasks (page_id, title) VALUES (?, ?)");
        $stmt->bind_param("is", $page_id, $title);
        if ($stmt->execute()) {
            echo "Task added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Page ID and Title are required.";
    }
}
?>
