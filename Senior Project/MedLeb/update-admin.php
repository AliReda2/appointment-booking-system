<?php
session_start();
require("config.php");
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

if ($con->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$newUsername = $_POST['newUsername'];
$newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

$sql = "UPDATE admin SET username = ?, password = ? WHERE id = 1"; // Assumes only one admin user with id=1
$stmt = $con->prepare($sql);
$stmt->bind_param("ss", $newUsername, $newPassword);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Username and password updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update username and password']);
}

$stmt->close();
$con->close();
