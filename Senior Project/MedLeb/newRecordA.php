<?php
require 'config.php';

// Sanitize inputs
$prescription = htmlspecialchars($_POST['prescription'], ENT_QUOTES, 'UTF-8');
$Aid = htmlspecialchars($_COOKIE['id'], ENT_QUOTES, 'UTF-8');
$Pid = htmlspecialchars($_POST['patient_id'], ENT_QUOTES, 'UTF-8'); // Corrected variable name
$file = ""; // Initialize $file variable
$sql = "SELECT d_id FROM assistant where id=$Aid";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$Did = $row['d_id'];
// Check if file is uploaded without errors
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $file = rand(1000, 100000) . "-" . basename($_FILES['file']['name']);
    $file_loc = $_FILES['file']['tmp_name'];

    // Sanitize file name and replace spaces with hyphens
    $new_file_name = strtolower(preg_replace("/[^a-zA-Z0-9.-]/", "", $file));
    $final_file = str_replace(' ', '-', $new_file_name);

    $folder = "records/";

    if (move_uploaded_file($file_loc, $folder . $final_file)) {
        $stmt = $con->prepare("INSERT INTO records(prescription, file, d_id, p_id) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssii", $prescription, $final_file, $Did, $Pid);
            if ($stmt->execute()) {
                echo '<script type="text/javascript"> alert("New record inserted successfully"); </script>';
                echo '<script type="text/javascript">setTimeout(function() { window.location.href = "assistant.php"; }, 1000);</script>';
            } else {
                echo '<script type="text/javascript"> alert("Error inserting record: ' . $stmt->error . '"); </script>';
            }
        } else {
            error_log("Insert statement prepare failed: " . $con->error);
            echo '<script type="text/javascript"> alert("Error preparing insert statement."); </script>';
        }
    } else {
        error_log("File upload failed: " . $_FILES['file']['error']);
        echo '<script type="text/javascript"> alert("Error while uploading file."); </script>';
        echo '<script type="text/javascript">setTimeout(function() { window.location.href = "assistant.php"; }, 1000);</script>';
    }
} else {
    echo '<script type="text/javascript"> alert("No file uploaded or there was an upload error."); </script>';
    echo '<script type="text/javascript">setTimeout(function() { window.location.href = "assistant.php"; }, 1000);</script>';
}
