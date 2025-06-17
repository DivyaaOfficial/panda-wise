<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Validate image
$check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
if($check === false) {
    die("File is not an image.");
}

// Only allow certain file types
if(!in_array($imageFileType, ["jpg", "jpeg", "png"])) {
    die("Only JPG, JPEG, PNG allowed.");
}

// Rename file to avoid conflict
$new_filename = $target_dir . uniqid() . "." . $imageFileType;
if (!move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $new_filename)) {
    die("Sorry, there was an error uploading your file.");
}

// Save to DB
$stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE username = ?");
$stmt->bind_param("ss", $new_filename, $username);
$stmt->execute();

echo "Profile picture updated!";
?>
