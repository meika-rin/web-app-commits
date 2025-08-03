<?php
include 'dbconnect.php';

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    $stmt = $conn->prepare("DELETE FROM users WHERE username=?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        echo "User deleted successfully! <a href='read_users.php'>Back to user list</a>";
    } else {
        echo "Delete failed: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "No username specified.";
}

$conn->close();
?>