<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'dbconnect.php'; // Connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password
    $gender = $_POST['gender'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, gender) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $gender);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Sign up successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>