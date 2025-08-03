<?php
// filepath: c:\xampp\htdocs\web app\read_users.php
include 'dbconnect.php';

$result = $conn->query("SELECT username, email, gender FROM users");

echo "<h2>Registered Users</h2>";
echo "<table border='1'><tr><th>Username</th><th>Email</th><th>Gender</th><th>Actions</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['username']}</td>
        <td>{$row['email']}</td>
        <td>{$row['gender']}</td>
        <td>
            <a href='edit_user.php?username=" . urlencode($row['username']) . "'>Edit</a> |
            <a href='delete_user.php?username=" . urlencode($row['username']) . "' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
        </td>
    </tr>";
}
echo "</table>";

$conn->close();
?>