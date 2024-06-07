<?php
session_start();
require("config.php");
header('Content-Type: application/json');

$Did = intval($_COOKIE['id']);

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    error_log("Not logged in");
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

// Check database connection
if ($con->connect_error) {
    error_log("Database connection failed: " . $con->connect_error);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Retrieve and sanitize POST data
$newUsername = isset($_POST['newUsername']) ? trim($_POST['newUsername']) : '';
$newPassword = isset($_POST['newPassword']) ? trim($_POST['newPassword']) : '';
$newSpec = isset($_POST['newSpec']) ? trim($_POST['newSpec']) : '';
$newPhone = isset($_POST['newPhone']) ? trim($_POST['newPhone']) : '';
$newEmail = isset($_POST['newEmail']) ? trim($_POST['newEmail']) : '';

if (empty($newUsername) || empty($newPassword) || empty($newSpec) || empty($newPhone) || empty($newEmail)) {
    error_log("All fields are required");
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit();
}

// Hash the new password
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Prepare and execute the SQL statement
$sql = "UPDATE doctor SET name = ?, password = ?, spec = ?, phone = ?, email = ? WHERE id = ?";
$stmt = $con->prepare($sql);

if ($stmt === false) {
    error_log("Failed to prepare SQL statement: " . $con->error);
    echo json_encode(['success' => false, 'message' => 'Failed to prepare SQL statement']);
    exit();
}

$doctorId = $Did;
$stmt->bind_param("sssssi", $newUsername, $hashedPassword, $newSpec, $newPhone, $newEmail, $doctorId);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No changes made to the profile']);
    }
} else {
    error_log("Failed to execute SQL statement: " . $stmt->error);
    echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
}

// Debugging: Output the SQL query and bound parameters
error_log("SQL Query: " . $sql);
error_log("Parameters: username={$newUsername}, password={$hashedPassword}, spec={$newSpec}, phone={$newPhone}, email={$newEmail}, id={$doctorId}");

$stmt->close();
$con->close();
