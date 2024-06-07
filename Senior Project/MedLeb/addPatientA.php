<?php
require("config.php");

$name = $_POST['name'];
$dob = $_POST['dob'];
$phone = $_POST['phone'];
$password = $_POST["password"];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$email = $_POST['email'];

$query = "SELECT id FROM assistant WHERE email=? UNION SELECT id FROM doctor WHERE email=? UNION SELECT id FROM patient WHERE email=?";

$stmt = $con->prepare($query);

$stmt->bind_param("sss", $email, $email, $email);

$stmt->execute();

$result = $stmt->get_result();

$Aid = htmlspecialchars($_COOKIE['id'], ENT_QUOTES, 'UTF-8');


$sql = "SELECT d_id FROM assistant where id=$Aid";
$result2 = mysqli_query($con, $sql);
$row2 = mysqli_fetch_array($result2);
$Did = $row2['d_id'];

if ($result) {
    // Check if the email is already registered
    if (mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript"> alert("Email already registered") </script>';
        echo '<script type="text/javascript">setTimeout(function() { window.location.href = "assistant.php"; }, 1000);</script>';
    } else {
        if (strlen($password) > 6) {
            // Use prepared statement for insertion
            $stmt = $con->prepare("INSERT INTO patient (name, email, password, dob, phone,d_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $name, $email, $hashedPassword, $dob, $phone, $Did);
            $stmt->execute();
            echo '<script type="text/javascript"> alert("Registered successfully") </script>';
            echo '<script type="text/javascript">setTimeout(function() { window.location.href = "assistant.php"; }, 1000);</script>';
        } else {
            echo '<script type="text/javascript"> alert("Password must be at least 7 characters") </script>';
            echo '<script type="text/javascript">setTimeout(function() { window.location.href = "assistant.php"; }, 1000);</script>';
        }
    }
} else {
    // Handle query execution error
    echo '<script type="text/javascript"> alert("Error in query execution") </script>';
    echo '<script type="text/javascript">setTimeout(function() { window.location.href = "assistant.php"; }, 1000);</script>';
}

$stmt->close();
$con->close();
