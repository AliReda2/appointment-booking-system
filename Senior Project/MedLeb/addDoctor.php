<?php
require("config.php");

$name = $_POST['name'];
$spec = $_POST['spec'];
$phone = $_POST['phone'];
$password = $_POST["password"];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$email = $_POST['email'];

// Use prepared statement to prevent SQL injection
$query = "SELECT id FROM assistant WHERE email=? UNION SELECT id FROM doctor WHERE email=? UNION SELECT id FROM patient WHERE email=?";

$stmt = $con->prepare($query);

$stmt->bind_param("sss", $email, $email, $email);

$stmt->execute();

$result = $stmt->get_result();

if ($result) {
    // Check if the email is already registered
    if (mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript"> alert("Email already registered") </script>';
        echo '<script type="text/javascript">setTimeout(function() { window.location.href = "admin.php"; }, 1000);</script>';
    } else {
        if (strlen($password) > 6) {
            // Use prepared statement for insertion
            $stmt = $con->prepare("INSERT INTO doctor (name, email, password, spec, phone) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $hashedPassword, $spec, $phone);
            $stmt->execute();
            echo '<script type="text/javascript"> alert("Registered successfully") </script>';
            echo '<script type="text/javascript">setTimeout(function() { window.location.href = "admin.php"; }, 1000);</script>';
        } else {
            echo '<script type="text/javascript"> alert("Password must be at least 7 characters") </script>';
            echo '<script type="text/javascript">setTimeout(function() { window.location.href = "admin.php"; }, 1000);</script>';
        }
    }
} else {
    // Handle query execution error
    echo '<script type="text/javascript"> alert("Error in query execution") </script>';
    echo '<script type="text/javascript">setTimeout(function() { window.location.href = "admin.php"; }, 1000);</script>';
}

$stmt->close();
$con->close();
