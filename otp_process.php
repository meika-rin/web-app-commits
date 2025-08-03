<?php
session_start();
include 'dbconnect.php';

// Step 1: Send OTP
if (isset($_POST['email'])) {
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $_POST['email'];
    $email = $_POST['email'];
    $subject = "Your OTP Code";
    $message = "Your OTP is: $otp";
    $headers = "From: no-reply@yourdomain.com";

    // This will likely fail on XAMPP unless you use PHPMailer
    if (mail($email, $subject, $message, $headers)) {
        echo "OTP sent! Please check your email and enter the OTP below.";
    } else {
        echo "Failed to send OTP. (mail() not configured)";
    }
    // For testing: show the OTP on the screen
    echo "Your OTP (for testing): $otp<br>";

    // Show OTP form
    echo '<form method="POST" action="">
            <label for="otp">Enter OTP:</label>
            <input type="text" name="otp" required>
            <input type="submit" value="Verify OTP">
          </form>';
    exit;
}

// Step 2: Verify OTP
if (isset($_POST['otp'])) {
    $user_otp = $_POST['otp'];
    if (isset($_SESSION['otp']) && $user_otp == $_SESSION['otp']) {
        echo "Login successful!";
        unset($_SESSION['otp']);
        unset($_SESSION['email']);
    } else {
        echo "Invalid OTP.";
    }
    exit;
}

// Initial email form
?>
<form method="POST" action="">
    <label for="email">Enter your email:</label>
    <input type="email" name="email" required>
    <input type="submit" value="Send OTP">
</form>