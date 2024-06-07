<?php
require("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assistant_id = $_POST['assistant_id'];
    $name = $_POST['Aname'];
    $email = $_POST['Aemail'];
    $phone = $_POST['Aphone'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $doctor_id = $_POST['Adoctor'];

    $sql = "UPDATE assistant SET name=?, email=?, phone=?, d_id=?";
    // Only update the password if it is provided
    if (!empty($password)) {
        $sql .= ", password=?";
    }
    $sql .= " WHERE id=?";

    if ($stmt = $con->prepare($sql)) {
        if (!empty($password)) {
            $stmt->bind_param("ssssss", $name, $email, $phone, $doctor_id, $hashedPassword, $assistant_id);
        } else {
            $stmt->bind_param("sssss", $name, $email, $phone,$doctor_id, $assistant_id);
        }
        $stmt->execute();
    }

    // Redirect or display a success message
    header("Location: admin.php");
    exit();
}
