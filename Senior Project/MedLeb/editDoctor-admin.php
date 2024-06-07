<?php

require("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = $_POST['doctor_id'];
    $name = $_POST['Dname'];
    $email = $_POST['Demail'];
    $phone = $_POST['Dphone'];
    $spec = $_POST['Dspec'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    // Update the doctor's details in the database
    $sql = "UPDATE doctor SET name=?, email=?, phone=?, spec=?";
    // Only update the password if it is provided
    if (!empty($password)) {
        $sql .= ", password=?";
    }
    $sql .= " WHERE id=?";

    if ($stmt = $con->prepare($sql)) {
        if (!empty($password)) {
            $stmt->bind_param("sssssi", $name, $email, $phone, $spec, $hashedPassword, $doctor_id);
        } else {
            $stmt->bind_param("ssssi", $name, $email, $phone, $spec, $doctor_id);
        }
        $stmt->execute();
    }

    // Redirect or display a success message
    header("Location: admin.php");
    exit();
}
