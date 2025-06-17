<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$current = $_POST['current_password'];
$new = $_POST['new_password'];
$confirm = $_POST['confirm_password'];

if ($new !== $confirm) {
    die("New passwords do not match.");
}

// Get current hashed password
$query = $conn->prepare("SELECT password FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$query->bind_result($hashed);
$query->fetch();
$query->close();

// Verify current password
if (!password_verify($current, $hashed)) {
    die("Incorrect current password.");
}

// Hash new password
$new_hashed = password_hash($new, PASSWORD_DEFAULT);

// Update password
$update = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
$update->bind_param("ss", $new_hashed, $username);
$update->execute();

echo "Password updated successfully!";
?>
