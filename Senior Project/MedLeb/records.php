<?php
require 'config.php';

// Fetch user ID from cookie
$Uid = htmlspecialchars($_COOKIE['id'], ENT_QUOTES, 'UTF-8');

// Function to fetch records from the database
function fetchRecords($con, $Uid)
{
    // Prepare the SQL statement to prevent SQL injection
    $query = "SELECT r.prescription, r.file, d.name AS doctor_name FROM records r JOIN doctor d ON r.d_id = d.id WHERE r.p_id = ?";

    // Prepare and execute the statement
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $Uid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}

// Fetch records
$records = fetchRecords($con, $Uid);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2>Medical Records</h2>

    <?php
    if ($records) {
        echo '<table>';
        echo '<tr><th>Prescription</th><th>File</th><th>Doctor</th></tr>';

        // Display each record
        while ($row = $records->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['prescription']) . '</td>';
            echo '<td><a href="records/' . htmlspecialchars($row['file']) . '" target="_blank">View File</a></td>';
            echo '<td>' . htmlspecialchars($row['doctor_name']) . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<p>No records found.</p>';
    }
    ?>

</body>

</html>