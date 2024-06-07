<?php
require("config.php");

if (!isset($_COOKIE['id'])) {
    echo '<script type="text/javascript"> alert("User not logged in.") </script>';
    echo '<script type="text/javascript">setTimeout(function() { window.location.href = "signUp_logIn_Form.php"; }, 1000);</script>';
    exit();
}
$Aid=$_COOKIE['id'];
$sql="SELECT d_id FROM assistant where id=$Aid";
$result=mysqli_query($con,$sql);
$row=mysqli_fetch_array($result);
$Did=$row['d_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['patient_id']) && isset($_POST['day']) && isset($_POST['time'])) {
        $patientID = mysqli_real_escape_string($con, $_POST['patient_id']);
        $selectedDay = mysqli_real_escape_string($con, $_POST['day']);
        $selectedTime = mysqli_real_escape_string($con, $_POST['time']);

        // Check if the user already has an appointment with the same doctor on the same day
        $stmt = $con->prepare("SELECT id FROM appointment WHERE p_id=? AND d_id=? AND day=?");
        $stmt->bind_param("sss", $Did, $patientID, $selectedDay);
        $stmt->execute();
        $result2 = $stmt->get_result();
        if ($result2->num_rows == 0) {
            // Check if the user already has an appointment at the same time on the same day
            $stmt = $con->prepare("SELECT id FROM appointment WHERE p_id=? AND day=? AND time=?");
            $stmt->bind_param("sss", $Did, $selectedDay, $selectedTime);
            $stmt->execute();
            $result3 = $stmt->get_result();
            if ($result3->num_rows == 0) {
                // Insert the new appointment into the database
                $stmt = $con->prepare("INSERT INTO appointment (day, time, p_id, d_id) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $selectedDay, $selectedTime, $patientID, $Did);
                if ($stmt->execute()) {
                    echo '<script type="text/javascript"> alert("Appointment scheduled successfully!") </script>';
                    echo '<script type="text/javascript">setTimeout(function() { window.location.href = "assistant.php"; }, 1000);</script>';
                } else {
                    echo "Error: Appointment could not be scheduled. Please try again later.";
                }
            } else {
                echo '<script type="text/javascript"> alert("You cannot schedule more than one appointment at the same day and time!") </script>';
                echo '<script type="text/javascript">setTimeout(function() { window.location.href = "assistant.php"; }, 1000);</script>';
            }
        } else {
            echo '<script type="text/javascript"> alert("You cannot schedule more than one appointment with the same doctor on the same day!") </script>';
            echo '<script type="text/javascript">setTimeout(function() { window.location.href = "assistant.php"; }, 1000);</script>';
        }
    } else {
        echo '<script type="text/javascript"> alert("Please fill all required fields.") </script>';
        echo '<script type="text/javascript">setTimeout(function() { window.location.href = "assistant.php"; }, 1000);</script>';
    }
}
