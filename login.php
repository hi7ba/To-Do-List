if ($type === 'login') {
    if (!isset($_POST['identifier']) || !isset($_POST['password'])) {
        echo json_encode(["error" => "Username/Email and password are required"]);
        exit;
    }

    $identifier = $_POST['identifier'];
    $password = $_POST['password'];

    // Check if user exists using username OR email
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            echo json_encode(["message" => "Login successful"]);
        } else {
            echo json_encode(["error" => "Invalid password"]);
        }
    } else {
        echo json_encode(["error" => "User not found"]);
    }
    exit;
}
