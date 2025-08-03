<?php
include 'dbconnect.php';

$username = $_GET['username'] ?? '';
if ($username == '') {
    echo "No username provided.";
    exit;
}

$stmt = $conn->prepare("SELECT email, gender FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($email, $gender);
if ($stmt->fetch()) {
?>
    <h2>Edit User: <?php echo htmlspecialchars($username); ?></h2>
    <form action="update_user.php" method="post">
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male" <?php if ($gender=="Male") echo "selected"; ?>>Male</option>
            <option value="Female" <?php if ($gender=="Female") echo "selected"; ?>>Female</option>
            <option value="Other" <?php if ($gender=="Other") echo "selected"; ?>>Other</option>
        </select>
        <button type="submit">Update</button>
    </form>
<?php
} else {
    echo "User not found.";
}
$stmt->close();
$conn->close();
?>