<?php
// Connection parameters
$host = "localhost";
$username = "root";
$password = "Babcock135790";
$database = "gme_university_database";

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optionally, you can set character set
mysqli_set_charset($conn, "utf8mb4");

