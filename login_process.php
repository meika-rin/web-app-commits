<?php
session_start();
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user
    $stmt = $conn->prepare("SELECT id, password, email FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password, $email);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            // Generate OTP
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $email;

            // Send OTP via email (simple mail function)
            mail($email, "Your OTP Code", "Your OTP is: $otp");

            // Redirect to OTP page
            header("Location: otp.html");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
    $stmt->close();
    $conn->close();
}
?>