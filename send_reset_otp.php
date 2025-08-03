<?php
session_start();
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT username FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $otp = rand(100000, 999999);
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_otp'] = $otp;
        // Send OTP via email
        mail($email, "Your Password Reset OTP", "Your OTP is: $otp");
        header("Location: reset_verify.html");
        exit();
    } else {
        echo "Email not found.";
    }
    $stmt->close();
}
$conn->close();
?>