<?php
session_start();
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = $_POST['otp'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    if (isset($_SESSION['reset_otp']) && isset($_SESSION['reset_email']) && $otp == $_SESSION['reset_otp']) {
        $email = $_SESSION['reset_email'];
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $stmt->bind_param("ss", $new_password, $email);
        if ($stmt->execute()) {
            echo "Password reset successful!";
            unset($_SESSION['reset_otp']);
            unset($_SESSION['reset_email']);
        } else {
            echo "Password reset failed: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Invalid OTP.";
    }
}
$conn->close();
?>