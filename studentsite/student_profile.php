<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Get student ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid student ID.";
    exit();
}

$student_id = intval($_GET['id']);

// Fetch student details
$student_sql = "SELECT * FROM students WHERE id = $student_id";
$student_result = $conn->query($student_sql);
$student = $student_result->fetch_assoc();

if (!$student) {
    echo "Student not found.";
    exit();
}

// Fetch grades
$grades_sql = "SELECT * FROM grades WHERE student_id = $student_id";
$grades_result = $conn->query($grades_sql);

// Fetch attendance
$attendance_sql = "SELECT * FROM attendance WHERE student_id = $student_id";
$attendance_result = $conn->query($attendance_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars($student['name']); ?> - Profile</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f0f2f8;
      margin: 0;
      padding: 30px;
    }

    .container {
      background: #fff;
      max-width: 1000px;
      margin: auto;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    h1, h2 {
      color: #4a47a3;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 14px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background: #f4f4fa;
    }

    .section {
      margin-top: 40px;
    }

    .back-link {
      display: inline-block;
      margin-top: 30px;
      text-decoration: none;
      background-color: #6a5acd;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
    }

    .back-link:hover {
      background-color: #5a4db0;
    }

    .student-info {
      background: #f9f9ff;
      padding: 20px;
      border-radius: 12px;
    }

    .student-info p {
      margin: 10px 0;
      font-size: 16px;
    }

    .highlight {
      font-weight: bold;
      color: #333;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Student Profile</h1>

    <div class="student-info">
      <p><span class="highlight">Name:</span> <?php echo htmlspecialchars($student['name']); ?></p>
      <p><span class="highlight">Email:</span> <?php echo htmlspecialchars($student['email']); ?></p>
      <p><span class="highlight">Course:</span> <?php echo htmlspecialchars($student['course']); ?></p>
    </div>

    <div class="section">
      <h2>Grades</h2>
      <table>
        <thead>
          <tr>
            <th>Assignment</th>
            <th>Score</th>
            <th>Max Score</th>
            <th>Grade</th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($grades_result && $grades_result->num_rows > 0): ?>
            <?php while ($grade = $grades_result->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($grade['assignment_name']); ?></td>
                <td><?php echo htmlspecialchars($grade['score']); ?></td>
                <td><?php echo htmlspecialchars($grade['max_score']); ?></td>
                <td><?php echo htmlspecialchars($grade['grade']); ?></td>
                <td><?php echo htmlspecialchars($grade['remarks']); ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5">No grades found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="section">
      <h2>Attendance</h2>
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Status</th>
            <th>Course ID</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($attendance_result && $attendance_result->num_rows > 0): ?>
            <?php while ($att = $attendance_result->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($att['date']); ?></td>
                <td><?php echo htmlspecialchars($att['status']); ?></td>
                <td><?php echo htmlspecialchars($att['course_id']); ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="3">No attendance records found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <a href="students.php" class="back-link">&larr; Back to Student List</a>
  </div>
</body>
</html>
