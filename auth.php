<?php
session_start();
include 'db_connection.php';

$type = $_POST['type'] ?? ($_GET['type'] ?? '');

if ($type === 'signup') {
    if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])) {
        header("Location: index.html");
        exit;
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        header("Location: index.html");
        exit;
    }

    $stmt->bind_param("sss", $username, $email, $password);
    if ($stmt->execute()) {
        header("Location: index.html"); 
        exit;
    } else {
        header("Location: index.html");
        exit;
    }
}

if ($type === 'login') {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        header("Location: index.html");
        exit;
    }

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.html"); 
            exit;
        }
    }

    header("Location: index.html");
    exit;
}
?>
