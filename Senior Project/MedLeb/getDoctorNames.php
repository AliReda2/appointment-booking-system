<?php
require("config.php");

if (isset($_GET['spec'])) {
    $spec = mysqli_real_escape_string($con, $_GET['spec']);

    $sql = "SELECT id, name FROM doctor WHERE spec = '$spec'";
    if ($result = mysqli_query($con, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
        } else {
            echo '<option value="">No doctors available</option>';
        }
    } else {
        echo '<option value="">Error fetching doctors</option>';
    }
} else {
    echo '<option value="">Invalid specialization</option>';
}

mysqli_close($con);
