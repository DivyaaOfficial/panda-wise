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
}<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Get user info
$user_stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$user_stmt->bind_param("i", $student_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();

// Get submissions with grades
$stmt = $conn->prepare("SELECT a.title, a.description, a.due_date, s.content AS submission_text, g.grade FROM submissions s JOIN assignments a ON s.assignment_id = a.id LEFT JOIN grades g ON s.id = g.submission_id WHERE s.student_id = ? ORDER BY a.due_date DESC");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Your Profile - Panda Student Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #eef2f3, #8e9eab);
      margin: 0;
      padding: 0;
    }
    .navbar {
      background-color: #4a47a3;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .navbar a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s ease;
    }
    .navbar a:hover {
      color: #ffdd57;
    }
    .container {
      max-width: 1000px;
      margin: 40px auto;
      background: #fff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }
    h2 {
      margin-bottom: 20px;
      color: #2c2e83;
    }
    .submission {
      border: 2px solid #e0e0ff;
      border-radius: 14px;
      padding: 20px;
      margin-bottom: 25px;
      background: #f9f9ff;
      transition: transform 0.2s;
    }
    .submission:hover {
      transform: scale(1.01);
    }
    .submission h3 {
      margin: 0 0 10px;
      color: #4a47a3;
    }
    .submission small {
      color: #777;
    }
    .submission p {
      margin-top: 10px;
      color: #333;
    }
    .grade-box {
      margin-top: 15px;
      font-weight: bold;
      color: #2e7d32;
    }
    .ungraded {
      color: #888;
      font-style: italic;
    }
    .footer {
      text-align: center;
      margin-top: 50px;
      padding: 20px;
      background: #4a47a3;
      color: white;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <div><strong>🎓 Panda Student Profile</strong></div>
    <div>
      <a href="student_dashboard.php">Dashboard</a>
      <a href="student_assignments.php">Assignments</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="container">
    <h2>👋 Welcome, <?= htmlspecialchars($user['username']) ?>!</h2>
    <p>📚 Here are your assignment submissions and grades:</p>

    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="submission">
          <h3><?= htmlspecialchars($row['title']) ?></h3>
          <small>Due: <?= htmlspecialchars($row['due_date']) ?></small>
          <p><strong>Your Submission:</strong><br><?= nl2br(htmlspecialchars($row['submission_text'])) ?></p>
          <div class="grade-box">
            <?= $row['grade'] !== null ? "✅ Grade: <strong>{" . htmlspecialchars($row['grade']) . "}</strong>" : "<span class='ungraded'>⏳ Not graded yet</span>" ?>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>You haven't submitted any assignments yet.</p>
    <?php endif; ?>
  </div>
  <div class="footer">
    &copy; <?= date('Y') ?> Panda Student Management. All rights reserved.
  </div>
</body>
</html>


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
