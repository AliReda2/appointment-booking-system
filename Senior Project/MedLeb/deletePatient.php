<?php
require("config.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $con->prepare("DELETE FROM patient WHERE id=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo '<script type="text/javascript"> alert("patient deleted") </script>';
    } else {
        echo '<script type="text/javascript"> alert("No patient found with that ID") </script>';
    }

    echo '<script type="text/javascript"> setTimeout(function() { window.location.href = "admin.php"; }, 1000); </script>';
} else {
    echo '<script type="text/javascript"> alert("ID not provided") </script>';
    echo '<script type="text/javascript"> setTimeout(function() { window.location.href = "admin.php"; }, 1000); </script>';
}
