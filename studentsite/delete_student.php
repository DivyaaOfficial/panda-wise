<?php
include 'db.php';
$id = $_GET['id'];
$sql = "DELETE FROM students WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: students.php");
exit();
?>