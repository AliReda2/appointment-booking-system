<?php
session_start();
require "config.php";

if (isset($_POST['logIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Function to handle the login logic
    function loginUser($con, $email, $password, $table, $redirectPage, $userType)
    {
        $stmt = $con->prepare("SELECT * FROM $table WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['loggedin'] = true;
                $name = $row['name'];
                $id = $row['id'];
                setcookie("uname", $name, time() + 3600);
                setcookie("id", $id, time() + 3600);
                echo "<script type='text/javascript'>alert('$userType found');</script>";
                echo "<script type='text/javascript'>setTimeout(function() { window.location.href = '$redirectPage'; }, 1000);</script>";
                exit();
            } else {
                echo "<script type='text/javascript'>alert('Email or password Incorrect');</script>";
                echo "<script type='text/javascript'>setTimeout(function() { window.location.href = 'signUp_logIn_Form.php'; }, 1000);</script>";
            }
        }
    }

    // Attempt to log in as patient
    loginUser($con, $email, $password, 'patient', 'index.php', 'User');

    // Attempt to log in as doctor
    loginUser($con, $email, $password, 'doctor', 'doctor.php', 'Doctor');

    // Attempt to log in as assistant
    loginUser($con, $email, $password, 'assistant', 'assistant.php', 'Assistant');

    // If email not found in any table
    echo "<script type='text/javascript'>alert('Email not found');</script>";
    echo "<script type='text/javascript'>setTimeout(function() { window.location.href = 'signUp_logIn_Form.php'; }, 1000);</script>";

    mysqli_close($con);
}
