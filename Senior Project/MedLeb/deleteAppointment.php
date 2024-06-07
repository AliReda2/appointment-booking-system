<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include your database configuration file
require_once 'config.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if appointment_id is set in POST data
    if (isset($_POST['appointment_id'])) {
        $appointment_id = intval($_POST['appointment_id']);

        try {
            // Create a new PDO instance using the configuration variables
            $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the SQL statement
            $stmt = $pdo->prepare("DELETE FROM appointment WHERE id = ?");
            $stmt->bindParam(1, $appointment_id, PDO::PARAM_INT);

            // Execute the statement
            if ($stmt->execute()) {
                http_response_code(200);
                echo "Appointment deleted successfully.";
            } else {
                http_response_code(500);
                echo "Failed to delete the appointment.";
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo "Error: " . $e->getMessage();
        }
    } else {
        http_response_code(400);
        echo "Invalid request: appointment_id is missing.";
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
