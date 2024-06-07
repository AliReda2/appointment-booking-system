<?php
session_start();
header('Content-Type: application/json');

require("config.php");

if ($con->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$postUsername = $_POST['username'];
$postPassword = $_POST['password'];

$sql = "SELECT * FROM admin WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $postUsername);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];
        if (password_verify($postPassword, $hashedPassword)) {
            $_SESSION['loggedin'] = true;
            // Set a cookie to identify the user
            setcookie("id", $row['id'], time() + 3600, "/"); // Cookie expires in 1 hour
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error in login']);
}

$stmt->close();
$con->close();
