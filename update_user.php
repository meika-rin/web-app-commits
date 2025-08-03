<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];

    $stmt = $conn->prepare("UPDATE users SET email=?, gender=? WHERE username=?");
    $stmt->bind_param("sss", $email, $gender, $username);

    if ($stmt->execute()) {
        echo "User updated successfully! <a href='read_users.php'>Back to user list</a>";
    } else {
        echo "Update failed: " . $stmt->error;
    }
    $stmt->close();
}

$result = $conn->query("SELECT username, email, gender FROM users");
echo "<table border='1'><tr><th>Username</th><th>Email</th><th>Gender</th><th>Actions</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['username']}</td>
        <td>{$row['email']}</td>
        <td>{$row['gender']}</td>
        <td><a href='edit_user.php?username=" . urlencode($row['username']) . "'>Edit</a></td>
    </tr>";
}
echo "</table>";

$conn->close();
?>