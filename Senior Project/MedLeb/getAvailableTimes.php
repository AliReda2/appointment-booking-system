<?php
require("config.php");

if (isset($_GET['doctor']) && isset($_GET['day'])) {
    $doctorId = mysqli_real_escape_string($con, $_GET['doctor']);
    $selectedDay = mysqli_real_escape_string($con, $_GET['day']);

    $doctorQuery = "SELECT start_time, end_time, interval_minutes FROM doctor WHERE id = '$doctorId'";
    $doctorResult = mysqli_query($con, $doctorQuery);

    if ($doctorResult && mysqli_num_rows($doctorResult) > 0) {
        $doctorRow = mysqli_fetch_assoc($doctorResult);
        $startTime = strtotime($doctorRow['start_time']);
        $endTime = strtotime($doctorRow['end_time']);
        $interval = $doctorRow['interval_minutes'] * 60;

        $bookedTimesQuery = "SELECT TIME_FORMAT(time, '%H:%i') AS formatted_time FROM appointment WHERE d_id = '$doctorId' AND day = '$selectedDay'";
        $bookedTimesResult = mysqli_query($con, $bookedTimesQuery);

        if ($bookedTimesResult) {
            $bookedTimes = array();
            while ($row = mysqli_fetch_assoc($bookedTimesResult)) {
                $bookedTimes[] = $row['formatted_time'];
            }

            $availableTimes = array();
            for ($time = $startTime; $time < $endTime; $time += $interval) {
                $timeString = date('H:i', $time);
                if (!in_array($timeString, $bookedTimes)) {
                    $availableTimes[] = $timeString;
                }
            }

            echo json_encode($availableTimes);
        } else {
            echo json_encode(array("error" => "Error fetching booked times: " . mysqli_error($con)));
        }
    } else {
        echo json_encode(array("error" => "Doctor not found."));
    }
} else {
    echo json_encode(array("error" => "Invalid input parameters."));
}

mysqli_close($con);
