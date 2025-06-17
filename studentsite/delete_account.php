<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Delete the user record
$stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

// Destroy session and redirect
session_destroy();
header("Location: goodbye.php"); // create a goodbye message page if you want
exit();
?>
