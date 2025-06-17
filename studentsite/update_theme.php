<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$theme = $_POST['theme'];

$update = $conn->prepare("UPDATE users SET theme = ? WHERE username = ?");
$update->bind_param("ss", $theme, $username);
$update->execute();

echo "Theme updated to $theme!";
?>
