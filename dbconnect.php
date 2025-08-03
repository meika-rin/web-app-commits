<?php
date_default_timezone_set('Africa/Nairobi');
$servername = "localhost";
$username = "root";
$password = ""; // Leave blank for XAMPP default
$dbname = "sect"; // Change to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>