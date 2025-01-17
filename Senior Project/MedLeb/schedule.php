<?php
session_start();

require("config.php");

// Check if the user is authenticated
if (!isset($_COOKIE["id"])) {
    header("Location: signUp_logIn_Form.php");
    exit();
} else {
    $Did = intval($_COOKIE['id']);
}

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $interval_minutes = $_POST['interval_minutes'];

    // Update values in the doctor table
    $sql = "UPDATE doctor SET start_time = ?, end_time = ?, interval_minutes = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('ssii', $start_time, $end_time, $interval_minutes, $Did);
    if ($stmt->execute()) {
        echo '<script type="text/javascript"> alert("schedule updated"); </script>';
        echo '<script type="text/javascript">setTimeout(function() { window.location.href = "doctor.php"; }, 1000);</script>';
    } else {
        echo "Error updating values: " . $stmt->error;
    }
}
