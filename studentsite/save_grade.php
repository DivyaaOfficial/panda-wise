<?php
include 'db.php';
$id = $_POST['submission_id'];
$grade = $_POST['grade'];
$remarks = $_POST['remarks'];

$stmt = $conn->prepare("UPDATE submissions SET grade=?, remarks=? WHERE id=?");
$stmt->bind_param("ssi", $grade, $remarks, $id);
$stmt->execute();
header("Location: grade_submissions.php?assignment_id=$id");
exit();
?>