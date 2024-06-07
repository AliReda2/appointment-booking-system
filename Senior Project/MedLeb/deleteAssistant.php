<?php
require("config.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $con->prepare("DELETE FROM assistant WHERE id=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo '<script type="text/javascript"> alert("Assistant deleted") </script>';
    } else {
        echo '<script type="text/javascript"> alert("No assistant found with that ID") </script>';
    }

    echo '<script type="text/javascript"> setTimeout(function() { window.location.href = "doctor.php"; }, 1000); </script>';
} else {
    echo '<script type="text/javascript"> alert("ID not provided") </script>';
    echo '<script type="text/javascript"> setTimeout(function() { window.location.href = "doctor.php"; }, 1000); </script>';
}
