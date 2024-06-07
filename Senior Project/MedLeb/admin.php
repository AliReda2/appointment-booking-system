<?php
session_start();
require("config.php");

// Check if the user is logged in by checking the session and cookie
if (!isset($_SESSION['loggedin']) || !isset($_COOKIE["id"])) {
    header("Location: admin-login-page.php");
    exit();
} else {
    $Aid = intval($_COOKIE['id']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>MedLeb</h3>
        </div>

        <div class="side-content">
            <div class="profile">
                <h4>Admin</h4>
                <br>
                <br>
            </div>

            <div class="side-menu">
                <ul>
                    <li onclick="displayDiv('1',this)">
                        <a href="#" class="active">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li onclick="displayDiv('2',this)">
                        <a href="#">
                            <span class="las la-user-alt"></span>
                            <small>Profile</small>
                        </a>
                    </li>
                    <li onclick="displayDiv('3',this)">
                        <a href="#">
                            <span class="las la-user-alt"></span>
                            <small>Assistants</small>
                        </a>
                    </li>
                    <li onclick="displayDiv('4',this)">
                        <a href="#">
                            <span class="las la-user-alt"></span>
                            <small>Doctors</small>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="main-content">

        <header>
            <div class="header-content">

                <div class="header-menu">
                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>

                        <span class="las la-power-off"></span>
                        <div class="logOut">
                            <form action="logOut.php" method="post"><button style="cursor: pointer;" class="logOutBtn">Log Out</button></form>
                        </div>
                    </div>
                </div>
            </div>
        </header>


        <main id="1" class="content-div">

            <div class="page-header">
                <h1>Dashboard</h1>
                <small>Home / Dashboard</small>
            </div>

            <div class="page-content">
                <div class="records table-responsive">
                    <div class="record-header">
                        <div class="add">
                            <button onclick="newPatient()">Add Patient</button>
                        </div>
                        <div class="browse">
                            <input type="search" placeholder="Search" class="record-search" onkeyup="filterTableP()">
                        </div>
                    </div>
                    <div>
                        <?php
                        $sql = "SELECT * FROM patient";
                        $result = $con->query($sql);
                        if ($result->num_rows > 0) {
                        ?>
                            <table id="patientTable" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>DoB</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["phone"] . "</td><td>" . $row["dob"] . "</td>";
                                    ?>
                                        <td>
                                            <a href="deletePatient.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Are you sure?')">
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
            <div class="newPatient">
                <div class="login-page">
                    <div class="form">
                        <form action="addPatient.php" method="post">
                            <h2><i class="fas fa-lock"></i>New Patient</h2>
                            <input type="text" name="name" required placeholder="Name">
                            <input type="email" name="email" required placeholder="email">
                            <input type="tel" placeholder="12-345-678" pattern="[0-9]{2}[0-9]{3}[0-9]{3}" name="phone" required>
                            <input type="date" spellcheck=false autocomplete="off" required name="dob">
                            <input type="password" name="password" required placeholder="password">
                            <input type="submit" value="submit">
                            <div class="exit" onclick="exit()"><i class="fa-solid fa-xmark fa-2xl"></i></div>
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
        </main>

        <main id="2" class="content-div" style="display:none">

            <div class="page-header">
                <h1>Profile</h1>
                <small>Home / Profile</small>
            </div>

            <div class="form-container">
                <h2>Change Username and Password</h2>
                <form id="changeFormElement" action="update-admin.php" method="POST">
                    <div class="form-group">
                        <label for="newUsername">New Username:</label>
                        <input type="text" id="newUsername" name="newUsername" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" id="newPassword" name="newPassword" required>
                    </div>
                    <button type="submit">Change</button>
                </form>
                <p id="changeErrorMessage" class="error-message"></p>
                <p id="changeSuccessMessage" class="success-message"></p>
            </div>
        </main>

        <main id="3" class="content-div" style="display:none">

            <div class="page-header">
                <h1>Assistants</h1>
                <small>Home / Assistants</small>
            </div>

            <div class="page-content">
                <div class="records table-responsive">
                    <div class="record-header">
                        <div class="add">
                            <button onclick="newAssistant()">Add Assistant</button>
                        </div>
                        <div class="browse">
                            <input type="search" placeholder="Search" class="record-searchA" onkeyup="filterTableA()">
                        </div>
                    </div>
                    <div>
                        <?php
                        $sql = "SELECT * FROM assistant ";
                        $resultA = $con->query($sql);
                        if ($resultA->num_rows > 0) {
                        ?>
                            <table id="assistantTable" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Doctor</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = $resultA->fetch_assoc()) {
                                        $a_id = $row['id'];
                                        $sql2 = "SELECT d.name FROM doctor d JOIN assistant a ON d.id = a.d_id WHERE a.id = $a_id";
                                        $result = $con->query($sql2);
                                        $rows = $result->fetch_assoc();
                                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $rows['name'] . "</td><td>" . $row["email"] . "</td><td>" . $row["phone"] . "</td>";
                                    ?>
                                        <td>
                                            <a href="deleteAssistant-admin.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>Delete
                                            </a>
                                            <a href="#" class="edit-btn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-email="<?php echo $row['email']; ?>" data-phone="<?php echo $row['phone']; ?>" data-doctor-id="<?php echo $row['d_id']; ?>" onclick="editAssistant(this)">
                                                <i class="fas fa-pen"></i>edit
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


            <div class="editAssistant">
                <div class="login-page">
                    <div class="form">
                        <form action="editAssistant-admin.php" method="post">
                            <h2><i class="fas fa-lock"></i>Edit Assistant</h2>
                            <input type="hidden" name="assistant_id" value="">
                            <?php
                            $sql = "SELECT * FROM doctor";
                            if ($stmt = $con->prepare($sql)) {
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) { ?>
                                    <select name="Adoctor" style="outline: 0;background: #f2f2f2;width: 100%;border: 0;border-radius: 7px;margin: 0 0 15px;padding: 15px;box-sizing: border-box;font-size: 14px;">
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name'] . " ID: " . $row['id']; ?></option>
                                        <?php } ?>
                                    </select>
                            <?php
                                }
                            }
                            ?>
                            <input type="text" name="Aname" required placeholder="Name" value="">
                            <input type="email" name="Aemail" required placeholder="email">
                            <input type="tel" placeholder="12-345-678" pattern="[0-9]{2}[0-9]{3}[0-9]{3}" name="Aphone" required>
                            <input type="password" name="password" placeholder="password">
                            <input type="submit" value="submit">
                            <div class="exit" onclick="exit()"><i class="fa-solid fa-xmark fa-2xl"></i></div>
                        </form>

                    </div>
                </div>
            </div>


            <div class="newAssistant">
                <div class="login-page">
                    <div class="form">
                        <form action="addAssistant-admin.php" method="post">
                            <h2><i class="fas fa-lock"></i>New Assistant</h2>
                            <?php
                            $sql = "SELECT * FROM doctor";

                            if ($stmt = $con->prepare($sql)) {
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) { ?>
                                    <select name="doctor" style="outline: 0;background: #f2f2f2;width: 100%;border: 0;border-radius: 7px;margin: 0 0 15px;padding: 15px;box-sizing: border-box;font-size: 14px;">
                                        <?php
                                        while ($row = $result->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name'] . " ID: " . $row['id']; ?></option>
                                        <?php } ?>
                                    </select>
                            <?php
                                }
                            }
                            ?>
                            <input type="text" name="name" required placeholder="Name">
                            <input type="email" name="email" required placeholder="email">
                            <input type="tel" placeholder="12-345-678" pattern="[0-9]{2}[0-9]{3}[0-9]{3}" name="phone" required>
                            <input type="password" name="password" required placeholder="password">
                            <input type="submit" value="submit">
                            <div class="exit" onclick="exit()"><i class="fa-solid fa-xmark fa-2xl"></i></div>
                        </form>
                    </div>
                </div>
            </div>
        </main>



        <main id="4" class="content-div" style="display:none">

            <div class="page-header">
                <h1>Doctors</h1>
                <small>Home / Doctors</small>
            </div>

            <div class="page-content">
                <div class="records table-responsive">
                    <div class="record-header">
                        <div class="add">
                            <button onclick="newDoctor()">Add Doctor</button>
                        </div>
                        <div class="browse">
                            <input type="search" placeholder="Search" class="record-searchD" onkeyup="filterTableD()">
                        </div>
                    </div>
                    <div>
                        <?php
                        $sql = "SELECT * FROM doctor";
                        $result = $con->query($sql);
                        if ($result->num_rows > 0) {
                        ?>
                            <table id="doctorTable" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Spec</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["phone"] . "</td><td>" . $row["spec"] . "</td>";
                                    ?>
                                        <td>
                                            <a href="deleteDoctor.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>Delete
                                            </a>
                                            <a href="#" class="edit-btn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-email="<?php echo $row['email']; ?>" data-phone="<?php echo $row['phone']; ?>" data-spec="<?php echo $row['spec']; ?>" onclick="editDoctor(this)">
                                                <i class="fas fa-pen"></i>Edit
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

            <div class="editDoctor">
                <div class="login-page">
                    <div class="form">
                        <form action="editDoctor-admin.php" method="post">
                            <h2><i class="fas fa-lock"></i>Edit Doctor</h2>
                            <input type="hidden" name="doctor_id" value="">
                            <input type="text" name="Dname" required placeholder="Name">
                            <input type="email" name="Demail" required placeholder="Email">
                            <input type="tel" placeholder="12-345-678" pattern="[0-9]{2}[0-9]{3}[0-9]{3}" name="Dphone" required>
                            <input type="text" name="Dspec" required placeholder="Specialty">
                            <input type="password" name="password" placeholder="Password">
                            <input type="submit" value="Submit">
                            <div class="exit" onclick="exit()"><i class="fa-solid fa-xmark fa-2xl"></i></div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="newDoctor">
                <div class="login-page">
                    <div class="form">
                        <form action="addDoctor.php" method="post">
                            <h2><i class="fas fa-lock"></i>New Doctor</h2>
                            <input type="text" name="name" required placeholder="Name">
                            <input type="email" name="email" required placeholder="email">
                            <input type="tel" placeholder="12-345-678" pattern="[0-9]{2}[0-9]{3}[0-9]{3}" name="phone" required>
                            <input type="text" name="spec" required placeholder="specailty">
                            <input type="password" name="password" required placeholder="password">
                            <input type="submit" value="submit">
                            <div class="exit" onclick="exit()"><i class="fa-solid fa-xmark fa-2xl"></i></div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

    </div>

    <script src="admin.js"></script>
    <script src="https://kit.fontawesome.com/41a5db781c.js" crossorigin="anonymous"></script>
</body>

</html>