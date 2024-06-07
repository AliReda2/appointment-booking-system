<?php
require("config.php");

$username = $_POST['username'];
$dob = $_POST['dob'];
$phone = $_POST['phone'];
$password = $_POST["password"];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$email = $_POST['email'];

// Use prepared statement to prevent SQL injection
$stmt = $con->prepare("SELECT id FROM patient WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    // Check if the email is already registered
    if (mysqli_num_rows($result) > 0) {
        echo '<script type="text/javascript"> alert("Email already registered") </script>';
        echo '<script type="text/javascript">setTimeout(function() { window.location.href = "signUp_logIn_Form.php"; }, 1000);</script>';
    } else {
        if (strlen($password) > 6) {
            if ($_POST["password"] == $_POST["confirmPassword"]) {
                // Use prepared statement for insertion
                $stmt = $con->prepare("INSERT INTO patient (name, email, password, dob, phone) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $username, $email, $hashedPassword, $dob, $phone);
                $stmt->execute();

                $sql2 = "SELECT * FROM patient WHERE email='" . $email . "'";
                $result2 = mysqli_query($con, $sql2);

                if ($result2) {
                    $rows = mysqli_num_rows($result2); // Count the rows

                    if ($rows == 1) {
                        $row = mysqli_fetch_array($result2);
                        $id = $row['id'];
                    }
                }
                echo '<script type="text/javascript"> alert("Registered successfully") </script>';
                echo '<script type="text/javascript">setTimeout(function() { window.location.href = "index.php"; }, 1000);</script>';
                setcookie("uname", $username, time() + 3600);
                setcookie("id", $id, time() + 3600);
            } else {
                echo '<script type="text/javascript"> alert("No matching password") </script>';
                echo '<script type="text/javascript">setTimeout(function() { window.location.href = "signUp_logIn_Form.php"; }, 1000);</script>';
            }
        } else {
            echo '<script type="text/javascript"> alert("Password must be at least 7 characters") </script>';
            echo '<script type="text/javascript">setTimeout(function() { window.location.href = "signUp_logIn_Form.php"; }, 1000);</script>';
        }
    }
} else {
    // Handle query execution error
    echo '<script type="text/javascript"> alert("Error in query execution") </script>';
    echo '<script type="text/javascript">setTimeout(function() { window.location.href = "signUp_logIn_Form.php"; }, 1000);</script>';
}

$stmt->close();
$con->close();
