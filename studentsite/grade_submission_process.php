<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

// ✅ Make sure submission_id, grade, and assignment_id are set
if (!isset($_POST['submission_id'], $_POST['grade'], $_POST['assignment_id'])) {
    echo "❌ No submission ID or grade or assignment ID provided.";
    exit();
}

$submission_id = intval($_POST['submission_id']);
$grade = trim($_POST['grade']);
$assignment_id = $_POST['assignment_id']; // Add this


// Check if grade already exists
$check = $conn->prepare("SELECT * FROM grades WHERE submission_id = ?");
$check->bind_param("i", $submission_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    // Update grade
    $update = $conn->prepare("UPDATE grades SET grade = ? WHERE submission_id = ?");
    $update->bind_param("si", $grade, $submission_id);
    if ($update->execute()) {
        header("Location: grade_submission.php?assignment_id=$assignment_id&success=1");
        exit();
    } else {
        echo "❌ Failed to update grade: " . $update->error;
    }
} else {
    // Insert new grade
    $insert = $conn->prepare("INSERT INTO grades (submission_id, grade) VALUES (?, ?)");
    $insert->bind_param("is", $submission_id, $grade);
    if ($insert->execute()) {
        header("Location: grade_submission.php?assignment_id=$assignment_id&success=1");
        exit();
    } else {
        echo "❌ Failed to insert grade: " . $insert->error;
    }
}
?>
