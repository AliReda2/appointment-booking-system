<?php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "medleb");

// Establish connection
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
