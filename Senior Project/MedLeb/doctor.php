<?php
session_start();

require("config.php");

// Check if the user is authenticated
if (!isset($_COOKIE["id"])) {
    header("Location: signUp_logIn_Form.php");
    exit();
} else {
    $Did = intval($_COOKIE['id']);
}
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="doctor.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
    <?php
    function fetchRecords($con, $Did)
    {
        // Prepare the SQL statement to prevent SQL injection
        $query = "SELECT r.prescription, r.file, p.name AS patient_name, p.email FROM records r JOIN patient p ON r.p_id = p.id WHERE r.d_id = ? ORDER BY p.email";

        // Prepare and execute the statement
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $Did);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // Fetch records
    $records = fetchRecords($con, $Did);

    ?>
    <div class="app-container">
        <div class="app-header">
            <div class="app-header-left">
                <span class="app-icon"></span>
                <p class="app-name">DASHBOARD</p>
                <form action="schedule.php" method="POST">
                    <label for="start_time">Start Time:</label>
                    <input type="time" id="start_time" name="start_time">

                    <label for="end_time">End Time:</label>
                    <input type="time" id="end_time" name="end_time">

                    <label for="interval_minutes">Interval (in minutes):</label>
                    <input type="number" id="interval_minutes" name="interval_minutes" min="1" step="1">

                    <button type="submit">Submit</button>
                </form>
            </div>
            <div class="app-header-left">
                <?php

                // Query to fetch start time
                $start_time_query = "SELECT start_time FROM doctor WHERE id=$Did";
                $start_time_result = mysqli_query($con, $start_time_query);
                $start_time_row = mysqli_fetch_assoc($start_time_result);
                $start_time = $start_time_row['start_time'];

                // Query to fetch end time
                $end_time_query = "SELECT end_time FROM doctor WHERE id=$Did";
                $end_time_result = mysqli_query($con, $end_time_query);
                $end_time_row = mysqli_fetch_assoc($end_time_result);
                $end_time = $end_time_row['end_time'];

                // Query to fetch interval
                $interval_query = "SELECT interval_minutes FROM doctor WHERE id=$Did";
                $interval_result = mysqli_query($con, $interval_query);
                $interval_row = mysqli_fetch_assoc($interval_result);
                $interval = $interval_row['interval_minutes'];

                ?>
                start time: <?php echo "$start_time"; ?>
                end time: <?php echo "$end_time"; ?>
                interval: <?php echo "$interval"; ?>
            </div>

            <div class="app-header-right">
                <button class="profile-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 19 19">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                    <span>
                        <?php
                        $sql = "SELECT name FROM doctor where id=$Did";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        echo $row["name"];
                        ?> </span>
                    <form action="logOut.php" method="post" style="display:flex;">
                        <button type="submit" style="cursor:pointer;border:none;background:none;color:inherit;padding:0;width: 6em;text-decoration: underline;font-size: large;align-self: center;margin:0;">Log Out</button>
                    </form>
                </button>
            </div>
        </div>

        <div class="app-content">
            <div class="app-sidebar">
                <span class="app-sidebar-link nav-button active" onclick="toggleMainContent('home', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </span>
                <span class="app-sidebar-link nav-button" onclick="toggleMainContent('records', this)">
                    <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-pie-chart" viewBox="0 0 24 24">
                        <defs />
                        <path d="M21.21 15.89A10 10 0 118 2.83M22 12A10 10 0 0012 2v10z" />
                    </svg>
                </span>
                <span class="app-sidebar-link nav-button" onclick="toggleMainContent('appointments', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </span>
                <span class="app-sidebar-link nav-button" onclick="toggleMainContent('addRecords', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </span>
                <span class="app-sidebar-link nav-button" onclick="toggleMainContent('settings', this)">
                    <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-settings" viewBox="0 0 24 24">
                        <defs />
                        <circle cx="12" cy="12" r="3" />
                        <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z" />
                    </svg>
                </span>
            </div>

            <div class="projects-section" id="home">
                <div class="projects-section-header">
                    <p>Today's Appointments</p>
                    <p class="time"><?php echo date("d F Y"); ?></p>
                </div>
                <div class="projects-section-line">
                    <div class="projects-status">
                        <div class="item-status">
                            <span class="status-number">
                                <?php
                                $sql = "SELECT COUNT(*) as total FROM appointment WHERE d_id = ?";
                                $stmt = $con->prepare($sql);
                                $stmt->bind_param('i', $Did);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                echo $row['total'];
                                ?>
                            </span>
                            <span class="status-type">Today's Appointments</span>
                        </div>
                    </div>
                    <div class="view-actions">
                        <button class="view-btn list-view" title="List View">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
                                <line x1="8" y1="6" x2="21" y2="6" />
                                <line x1="8" y1="12" x2="21" y2="12" />
                                <line x1="8" y1="18" x2="21" y2="18" />
                                <line x1="3" y1="6" x2="3.01" y2="6" />
                                <line x1="3" y1="12" x2="3.01" y2="12" />
                                <line x1="3" y1="18" x2="3.01" y2="18" />
                            </svg>
                        </button>
                        <button class="view-btn grid-view active" title="Grid View">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="project-boxes jsGridView">
                    <?php
                    $sql = "SELECT DISTINCT patient.id AS patient_id, patient.name, patient.phone, appointment.id AS appointment_id, appointment.time, appointment.day FROM patient INNER JOIN appointment ON patient.id = appointment.p_id WHERE appointment.d_id = ? ORDER BY ABS(DATEDIFF(appointment.day, CURDATE()))";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param('i', $Did);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Convert the 'day' column to a DateTime object
                            $appointmentDate = DateTime::createFromFormat('Y-m-d', $row['day']);
                            if ($appointmentDate !== false) {
                                $currentDate = new DateTime();

                                // Normalize the time to midnight for both dates
                                $currentDate->setTime(0, 0);
                                $appointmentDate->setTime(0, 0);

                                $interval = $currentDate->diff($appointmentDate);
                                $daysLeft = $interval->format('%r%a');

                                if ($daysLeft == 0) {
                                    echo '<div class="project-box-wrapper">
                            <div class="project-box" style="background-color: #c8f7dc;">
                                <div class="project-box-header">
                                    <span>' . htmlspecialchars($row["time"]) . '</span>
                                    <button onclick="deleteAppointment(' . $row["appointment_id"] . ')">Delete</button>

                                </div>
                                <div class="project-box-content-header">
                                    <p class="box-content-header">' . htmlspecialchars($row["name"]) . ' ID: ' . htmlspecialchars($row["patient_id"]) . '</p>
                                </div>
                                <div class="project-box-footer">
                                    <div class="participants">
                                    <button class="add-participant" style="color: #ff942e;">
                                    <td style="padding: 1rem 0rem; color: #444;"><a href="tel:+961' . htmlspecialchars($row["phone"]) . '">postpone</a></td>
                                    </button>
                                    </div>
                                    <div class="days-left" style="color: #4f3ff0;">
                                        Today
                                    </div>
                                </div>
                            </div>
                          </div>';
                                } elseif ($daysLeft == 1) {
                                    echo '<div class="project-box-wrapper">
                            <div class="project-box" style="background-color: #c8f7dc;">
                                <div class="project-box-header">
                                    <span>' . htmlspecialchars($row["time"]) . '</span>
                                    <button onclick="deleteAppointment(' . $row["appointment_id"] . ')">Delete</button>

                                </div>
                                <div class="project-box-content-header">
                                <p class="box-content-header">' . htmlspecialchars($row["name"]) . ' ID: ' . htmlspecialchars($row["patient_id"]) . '</p>
                                </div>
                                <div class="project-box-footer">
                                    <div class="participants">
                                        <button class="add-participant" style="color: #ff942e;">
                                        <td style="padding: 1rem 0rem; color: #444;"><a href="tel:+961' . htmlspecialchars($row["phone"]) . '">postpone</a></td>
                                        </button>
                                    </div>
                                    <div class="days-left" style="color: #4f3ff0;">
                                        Tommorow
                                    </div>
                                </div>
                            </div>
                          </div>';
                                } elseif ($daysLeft > 1) {
                                    echo '<div class="project-box-wrapper">
                            <div class="project-box" style="background-color: #e9e7fd;">
                                <div class="project-box-header">
                                    <span>' . htmlspecialchars($row["time"]) . '</span>
                                    <button onclick="deleteAppointment(' . $row["appointment_id"] . ')">Delete</button>
                                </div>
                                <div class="project-box-content-header">
                                <p class="box-content-header">' . htmlspecialchars($row["name"]) . ' ID: ' . htmlspecialchars($row["patient_id"]) . '</p>
                                </div>
                                <div class="project-box-footer">
                                    <div class="participants">
                                        <button class="add-participant" style="color: #ff942e;">
                                        <td style="padding: 1rem 0rem; color: #444;"><a href="tel:+961' . htmlspecialchars($row["phone"]) . '">postpone</a></td>
                                        </button>
                                    </div>
                                    <div class="days-left" style="color: #4f3ff0;">
                                        ' . htmlspecialchars($daysLeft) . ' Days Left
                                    </div>
                                </div>
                            </div>
                          </div>';
                                } elseif ($daysLeft < 0) {
                                    echo '<div class="project-box-wrapper">
                            <div class="project-box" style="background-color: #fee4cb;">
                                <div class="project-box-header">
                                    <span>' . htmlspecialchars($row["time"]) . '</span>
                                    <button onclick="deleteAppointment(' . $row["appointment_id"] . ')">Delete</button>
                                </div>
                                <div class="project-box-content-header">
                                <p class="box-content-header">' . htmlspecialchars($row["name"]) . ' ID: ' . htmlspecialchars($row["patient_id"]) . '</p>
                                </div>
                                <div class="project-box-footer">
                                    <div class="participants">
                                        <button class="add-participant" style="color: #ff942e;">
                                        <td style="padding: 1rem 0rem; color: #444;"><a href="tel:+961' . htmlspecialchars($row["phone"]) . '">postpone</a></td>
                                        </button>
                                    </div>
                                    <div class="days-left" style="color: #4f3ff0;">
                                        Appointment Date Passed
                                    </div>
                                </div>
                            </div>
                          </div>';
                                }
                            } else {
                                echo '<div class="project-box-wrapper">
                        <div class="project-box" style="background-color: #fee4cb;">
                            <div class="project-box-header">
                                <span>' . htmlspecialchars($row["time"]) . '</span>
                            </div>
                            <div class="project-box-content-header">
                                <p class="box-content-header">' . htmlspecialchars($row["name"]) . '</p>
                            </div>
                            <div class="project-box-footer"
                                <div class="days-left" style="color: #4f3ff0;">
                                    Invalid date
                                </div>
                            </div>
                        </div>
                      </div>';
                            }
                        }
                    } else {
                        echo '<p>No appointments found.</p>';
                    }
                    ?>
                    <script>
                        function deleteAppointment(appointmentId) {
                            if (confirm("Are you sure you want to delete this appointment?")) {
                                const xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === XMLHttpRequest.DONE) {
                                        if (xhr.status === 200) {
                                            window.location.reload();
                                        } else {
                                            alert('Error: ' + xhr.status + ' - ' + xhr.statusText);
                                        }
                                    }
                                };
                                xhr.open("POST", "deleteAppointment.php", true);
                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                const params = new URLSearchParams({
                                    appointment_id: appointmentId
                                }).toString();
                                xhr.send(params);
                            }
                        }
                    </script>
                </div>
            </div>
            <div class="projects-section" id="records" style="display:none">
                <div class="projects-section-header">
                    <p>Records</p>
                    <p class="time"><?php echo date("d F Y"); ?></p>
                </div>
                <?php if ($records) :
                    echo "<table style='width: -webkit-fill-available;text-align: center;border-collapse: collapse;'><thead><tr style='background:#e9edf2;'><th style='padding: 1rem 0rem;color: #444;font-size: .9rem;'>Patient</th><th style='padding: 1rem 0rem;color: #444;font-size: .9rem;'>Prescription</th><th style='padding: 1rem 0rem;color: #444;font-size: .9rem;'>action</th></tr></thead><tbody>";
                    while ($row = $records->fetch_assoc()) :
                        echo "<tr style='border-bottom: 1px solid #dee2e8;'>
                        <td style='padding: 1rem 0rem;color: #444;'>" . htmlspecialchars($row["patient_name"]) . "</td>
                        <td style='padding: 1rem 0rem;color: #444;'>" . htmlspecialchars($row["prescription"]) . "</td>
                        <td style='padding: 1rem 0rem;color: #444;'>";
                        if (!empty($row['file'])) {
                            echo "<a href='records/" . htmlspecialchars($row['file']) . "' download>Download File</a>
                          <a href='records/" . htmlspecialchars($row['file']) . "' target='_blank'>View File</a>";
                        }
                        echo "</td></tr>";

                    endwhile;
                    echo "</tbody></table>"; ?>

                <?php else : ?>
                    <p>No records found.</p>
                <?php endif; ?>
            </div>

            <div class="projects-section" id="appointments" style="display:none">
                <div class="projects-section-header">
                    <p>Add Appointments</p>
                    <p class="time"><?php echo date("d F Y"); ?></p>
                </div>
                <div class="project-boxes jsGridView">
                    <form action="doctor-bookAppointment.php" method="post">
                        <p>Patient Name</p>
                        <select name="patient_id" id="doctor">
                            <?php
                            // Fetch patients associated with the doctor
                            $sql = "SELECT DISTINCT p.id, p.name FROM patient p LEFT JOIN appointment a ON p.id = a.p_id LEFT JOIN records r ON p.id = r.p_id WHERE a.d_id = ? OR r.d_id = ? OR p.d_id=?";
                            $stmt = $con->prepare($sql);
                            $stmt->bind_param("iii", $Did, $Did, $Did); // Assuming $Did is an integer
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['name']) . ' ID: ' . htmlspecialchars($row['id']); ?></option>
                            <?php }
                            } else {
                                echo "0 results";
                            } ?>
                        </select>

                        <p>Date and Time</p>
                        <input type="date" id="daySelect" required name="day">

                        <select name="time" id="timeSelect" required>
                            <!-- Options will be dynamically populated based on the selected date -->
                        </select>
                        <input type="number" id="nameSelect" name="doctor-id" value="<?php echo $Did; ?>" hidden>
                        <input type="submit" value="submit">
                    </form>

                    <script>
                        document.getElementById('daySelect').addEventListener('change', function() {
                            var selectedDoctor = document.getElementById('nameSelect').value;
                            var selectedDay = this.value;

                            if (selectedDoctor && selectedDay) {
                                fetch('getAvailableTimes.php?doctor=' + selectedDoctor + '&day=' + selectedDay)
                                    .then(response => response.json())
                                    .then(data => {
                                        var timeSelect = document.getElementById('timeSelect');
                                        timeSelect.innerHTML = '';

                                        data.forEach(function(time) {
                                            var option = document.createElement('option');
                                            option.value = time;
                                            option.textContent = time;
                                            timeSelect.appendChild(option);
                                        });
                                    });
                            }
                        });

                        document.addEventListener("DOMContentLoaded", function() {
                            var input = document.getElementById("daySelect");
                            var today = new Date();
                            var minDate = today.toISOString().split('T')[0];
                            input.min = minDate;
                        });
                    </script>
                </div>
            </div>

            <div class="projects-section" id="addRecords" style="display:none">
                <div class="projects-section-header">
                    <p>Add Records</p>
                    <p class="time"><?php echo date("d F Y"); ?></p>
                </div>
                <div class="project-boxes jsGridView">
                    <form action="newRecord.php" method="post" enctype="multipart/form-data">
                        <p>Patient Name</p>
                        <select name="patient_id">
                            <?php
                            $sql = "SELECT DISTINCT p.id, p.name FROM patient p LEFT JOIN appointment a ON p.id = a.p_id LEFT JOIN records r ON p.id = r.p_id WHERE a.d_id = ? OR r.d_id = ? OR p.d_id=?";
                            $stmt = $con->prepare($sql);
                            $stmt->bind_param("iii", $Did, $Did, $Did);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) { ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['name']) . ' ID: ' . htmlspecialchars($row['id']); ?></option>
                            <?php } ?>
                        </select>

                        <p>Prescription</p>
                        <textarea name="prescription" rows="4" cols="50"></textarea>

                        <p>File</p>
                        <input type="file" name="file">

                        <button type="submit">Add Record</button>
                    </form>
                </div>
            </div>


            <div class="projects-section" id="settings" style="display:none;overflow:auto">
                <div class="projects-section-header">
                    <p>Settings</p>
                    <p class="time"><?php echo date("d F Y"); ?></p>
                </div>
                <div class="doctor-profile">
                    <h2>Profile</h2>
                    <div class="form-container">
                        <?php
                        $sql = "SELECT * FROM doctor where id=$Did";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        $dName = $row["name"];
                        $dSpec = $row["spec"];
                        $dPhone = $row["phone"];
                        $dEmail = $row["email"];
                        ?>

                        <form id="changeFormElement" action="update-doctor.php" method="POST">
                            <div class="form-group">
                                <label for="newUsername">New Username:</label>
                                <input type="text" id="newUsername" name="newUsername" value="<?php echo $dName ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="newPassword">New Password:</label>
                                <input type="password" id="newPassword" name="newPassword" required>
                            </div>
                            <div class="form-group">
                                <label for="newSpec">New Spec:</label>
                                <input type="text" id="newSpec" name="newSpec" value="<?php echo $dSpec ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="newPhone">New Phone:</label>
                                <input type="tel" id="newPhone" name="newPhone" value="<?php echo $dPhone ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="newEmail">New Email:</label>
                                <input type="email" id="newEmail" name="newEmail" value="<?php echo $dEmail ?>" required>
                            </div>
                            <button type="submit">Change</button>
                        </form>
                        <p id="changeErrorMessage" class="error-message"></p>
                        <p id="changeSuccessMessage" class="success-message"></p>
                    </div>
                </div>
                <br>


                <div class="project-boxes jsGridView">
                    <h2>Asistant</h2>
                    <div style="padding: 1.3rem 1rem;width: -webkit-fill-available;background: #f1f4f9;">
                        <div style="width: 100%;overflow: auto;">
                            <div style="padding: 1rem;display: flex;justify-content: space-between;align-items: center;">
                                <div style="display: flex;align-items: center;">
                                    <button style="cursor: pointer;background: #03A9F4;color: #fff;height: 37px;border-radius: 4px;padding: 0rem 1rem;border: none;font-weight: 600;" onclick="newAssistant()">Add Assistant</button>
                                </div>
                                <div style="display: flex;align-items: center;">
                                    <input type="search" placeholder="Search" style="height: 35px;border: 1px solid #b0b0b0;border-radius: 3px;display: inline-block;padding: 0rem .5rem;margin-right: .8rem;color: #666;" class="record-searchA" onkeyup="filterTableA()">
                                </div>
                            </div>
                            <div>
                                <?php
                                $sql = "SELECT * FROM assistant WHERE d_id=?";
                                $stmt = $con->prepare($sql);
                                $stmt->bind_param("i", $Did); // Assuming $Did is an integer
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                ?>
                                    <table id="assistantTable" width="100%" style="border-collapse: collapse;">
                                        <thead>
                                            <tr style="background: #e9edf2;">
                                                <th style="padding: 1rem 0rem;text-align: left;color: #444;font-size: .9rem;">#</th>
                                                <th style="padding: 1rem 0rem;text-align: left;color: #444;font-size: .9rem;">Name</th>
                                                <th style="padding: 1rem 0rem;text-align: left;color: #444;font-size: .9rem;">Email</th>
                                                <th style="padding: 1rem 0rem;text-align: left;color: #444;font-size: .9rem;">Phone Number</th>
                                                <th style="padding: 1rem 0rem;text-align: left;color: #444;font-size: .9rem;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr style='border-bottom: 1px solid #dee2e8;'><td style='padding-left: 1rem;color: var(--main-color);font-weight: 600;font-size: .9rem;'>" . $row["id"] . "</td><td style='padding: 1rem 0rem;color: #444;'>" . $row["name"] . "</td><td style='padding: 1rem 0rem;color: #444;'>" . $row["email"] . "</td><td style='padding: 1rem 0rem;color: #444;'>" . $row["phone"] . "</td>";
                                            ?>
                                                <td>
                                                    <a href="deleteAssistant.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>Delete
                                                    </a>
                                                </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "No Results";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="project-boxes jsGridView">
                    <h2>Patients</h2>
                    <div style="padding: 1.3rem 1rem;width: -webkit-fill-available;background: #f1f4f9;">
                        <div style="width: 100%;overflow: auto;">
                            <div style="padding: 1rem;display: flex;justify-content: space-between;align-items: center;">
                                <div style="display: flex;align-items: center;">
                                    <button style="cursor: pointer;background: #03A9F4;color: #fff;height: 37px;border-radius: 4px;padding: 0rem 1rem;border: none;font-weight: 600;" onclick="newPatient()">Add Patient</button>
                                </div>
                                <div style="display: flex;align-items: center;">
                                    <input type="search" placeholder="Search" style="height: 35px;border: 1px solid #b0b0b0;border-radius: 3px;display: inline-block;padding: 0rem .5rem;margin-right: .8rem;color: #666;" class="record-searchP" onkeyup="filterTableP()">
                                </div>
                            </div>
                            <div>
                                <?php
                                $sql = "SELECT DISTINCT p.id, p.name, p.email, p.phone, p.dob FROM patient p LEFT JOIN appointment a ON p.id = a.p_id LEFT JOIN records r ON p.id = r.p_id WHERE a.d_id = ? OR r.d_id = ? OR p.d_id=?";
                                $stmt = $con->prepare($sql);
                                $stmt->bind_param("iii", $Did, $Did, $Did);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                ?>
                                    <table id="patientTable" width="100%" style="border-collapse: collapse;">
                                        <thead>
                                            <tr style="background: #e9edf2;">
                                                <th style="padding: 1rem 0rem;text-align: left;color: #444;font-size: .9rem;">#</th>
                                                <th style="padding: 1rem 0rem;text-align: left;color: #444;font-size: .9rem;">Name</th>
                                                <th style="padding: 1rem 0rem;text-align: left;color: #444;font-size: .9rem;">Email</th>
                                                <th style="padding: 1rem 0rem;text-align: left;color: #444;font-size: .9rem;">Phone Number</th>
                                                <th style="padding: 1rem 0rem;text-align: left;color: #444;font-size: .9rem;">DoB</th>
                                                <th style="padding: 1rem 0rem;text-align: left;color: #444;font-size: .9rem;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr style='border-bottom: 1px solid #dee2e8;'><td style='padding-left: 1rem;color: var(--main-color);font-weight: 600;font-size: .9rem;'>" . $row["id"] . "</td><td style='padding: 1rem 0rem;color: #444;'>" . $row["name"] . "</td><td style='padding: 1rem 0rem;color: #444;'>" . $row["email"] . "</td><td style='padding: 1rem 0rem;color: #444;'>" . $row["phone"] . "</td><td style='padding: 1rem 0rem;color: #444;'>" . $row["dob"] . "</td>";
                                            ?>
                                                <td>
                                                    <a href="deletePatientD.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>Delete
                                                    </a>
                                                </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="newAssistant" style="display: none;top: 0;position: absolute;width: -webkit-fill-available;">
                    <div class="login-page">
                        <div class="form">
                            <form action="addAssistant.php" method="post">
                                <h2><i class="fas fa-lock"></i>New Assistant</h2>
                                <input type="text" name="name" required placeholder="Name">
                                <input type="email" name="email" required placeholder="email">
                                <input type="tel" placeholder="12-345-678" pattern="[0-9]{2}[0-9]{3}[0-9]{3}" name="phone" required>
                                <input type="password" name="password" required placeholder="password">
                                <input type="submit" value="submit">
                                <div style="width: 1em;height: 1em;position: absolute;margin: 1.5em;right: 0;top: 0;" class="exit" onclick="exit()"><i class="fa-solid fa-xmark fa-2xl"></i></div>
                            </form>
                        </div>
                    </div>
                    <style>
                        .login-page {
                            width: 400px;
                            padding: 8% 0 0;
                            margin: auto;
                        }

                        .form {
                            position: relative;
                            z-index: 1;
                            background: #FFFFFF;
                            max-width: 400px;
                            margin: 0 auto 100px;
                            padding: 45px;
                            text-align: center;
                            border-radius: 15px;
                            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
                        }

                        .form input {
                            font-family: "Poppins", sans-serif;
                            outline: 0;
                            background: #f2f2f2;
                            width: 100%;
                            border: 0;
                            border-radius: 7px;
                            margin: 0 0 15px;
                            padding: 15px;
                            box-sizing: border-box;
                            font-size: 14px;

                        }

                        .form input[type="submit"] {
                            font-family: "Poppins", sans-serif;
                            text-transform: uppercase;
                            outline: 0;
                            background: #234666;
                            width: 100%;
                            border: 0;
                            padding: 15px;
                            color: #FFFFFF;
                            border-radius: 7px;
                            font-size: 14px;
                            -webkit-transition: all 0.3 ease;
                            transition: all 0.3 ease;
                            cursor: pointer;
                        }

                        .form button:hover,
                        .form button:active,
                        .form button:focus {
                            background: #0e2941;
                        }

                        .form .message {
                            margin: 15px 0 0;
                            color: #b3b3b3;
                            font-size: 12px;
                        }

                        .form .message a {
                            color: #234666;
                            text-decoration: none;
                        }

                        .form .register-form {
                            display: none;
                        }
                    </style>
                </div>

                <div class="newPatientD" style="display: none;top: 0;position: absolute;width: -webkit-fill-available;">
                    <div class="login-page">
                        <div class="form">
                            <form action="addPatientD.php" method="post">
                                <h2><i class="fas fa-lock"></i>New Patient</h2>
                                <input type="text" name="name" required placeholder="Name">
                                <input type="email" name="email" required placeholder="email">
                                <input type="tel" placeholder="12-345-678" pattern="[0-9]{2}[0-9]{3}[0-9]{3}" name="phone" required>
                                <input type="date" spellcheck=false autocomplete="off" required name="dob">
                                <input type="password" name="password" required placeholder="password">
                                <input type="submit" value="submit">
                                <div style="width: 1em;height: 1em;position: absolute;margin: 1.5em;right: 0;top: 0;" class="exit" onclick="exit()"><i class="fa-solid fa-xmark fa-2xl"></i></div>
                            </form>
                        </div>
                    </div>
                    <style>
                        .login-page {
                            width: 400px;
                            padding: 8% 0 0;
                            margin: auto;
                        }

                        .form {
                            position: relative;
                            z-index: 1;
                            background: #FFFFFF;
                            max-width: 400px;
                            margin: 0 auto 100px;
                            padding: 45px;
                            text-align: center;
                            border-radius: 15px;
                            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
                        }

                        .form input {
                            font-family: "Poppins", sans-serif;
                            outline: 0;
                            background: #f2f2f2;
                            width: 100%;
                            border: 0;
                            border-radius: 7px;
                            margin: 0 0 15px;
                            padding: 15px;
                            box-sizing: border-box;
                            font-size: 14px;

                        }

                        .form input[type="submit"] {
                            font-family: "Poppins", sans-serif;
                            text-transform: uppercase;
                            outline: 0;
                            background: #234666;
                            width: 100%;
                            border: 0;
                            padding: 15px;
                            color: #FFFFFF;
                            border-radius: 7px;
                            font-size: 14px;
                            -webkit-transition: all 0.3 ease;
                            transition: all 0.3 ease;
                            cursor: pointer;
                        }

                        .form button:hover,
                        .form button:active,
                        .form button:focus {
                            background: #0e2941;
                        }

                        .form .message {
                            margin: 15px 0 0;
                            color: #b3b3b3;
                            font-size: 12px;
                        }

                        .form .message a {
                            color: #234666;
                            text-decoration: none;
                        }

                        .form .register-form {
                            display: none;
                        }
                    </style>
                </div>
            </div>
        </div>

        <script>
            function toggleMainContent(contentId, buttonElement) {
                // Hide all content sections
                var sections = document.querySelectorAll('.projects-section');
                sections.forEach(function(section) {
                    section.style.display = 'none';
                });

                // Remove active class from all sidebar links
                var navButtons = document.querySelectorAll('.app-sidebar-link');
                navButtons.forEach(function(button) {
                    button.classList.remove('active');
                });

                // Show the selected content section
                var selectedSection = document.getElementById(contentId);
                if (selectedSection) {
                    selectedSection.style.display = 'block';
                }

                // Add active class to the clicked button
                buttonElement.classList.add('active');
            }

            // Initialize with the home section displayed
            toggleMainContent('home', document.querySelector('.nav-button.active'));
        </script>
        <script src="doctor.js"></script>
        <script src="https://kit.fontawesome.com/41a5db781c.js" crossorigin="anonymous"></script>
</body>

</html>