<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Check if an attendance record already exists for this student, course, and date
    $checkSql = "SELECT id FROM attendance WHERE student_id = ? AND course_id = ? AND date = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("iis", $student_id, $course_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $row = $result->fetch_assoc();
        $attendance_id = $row['id'];
        $updateSql = "UPDATE attendance SET status = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $status, $attendance_id);
        if ($updateStmt->execute()) {
            $success = "Attendance updated successfully.";
        } else {
            $error = "Failed to update attendance.";
        }
    } else {
        // Insert new record
        $insertSql = "INSERT INTO attendance (student_id, course_id, date, status) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("iiss", $student_id, $course_id, $date, $status);
        if ($insertStmt->execute()) {
            $success = "Attendance added successfully.";
        } else {
            $error = "Failed to add attendance.";
        }
    }
}

// Fetch students and courses
$students = $conn->query("SELECT id, name FROM students");
$courses = $conn->query("SELECT id, name FROM courses");
?>
