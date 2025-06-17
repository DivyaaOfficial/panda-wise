<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$new_email = $_POST['new_email'];

$update = $conn->prepare("UPDATE users SET email = ? WHERE username = ?");
$update->bind_param("ss", $new_email, $username);
$update->execute();

echo "Email updated successfully!";
?>
