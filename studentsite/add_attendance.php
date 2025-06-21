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

    $sql = "INSERT INTO attendance (student_id, course_id, date, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $student_id, $course_id, $date, $status);

    if ($stmt->execute()) {
        $success = "Attendance added successfully.";
    } else {
        $error = "Failed to add attendance.";
    }
}

// Fetch students and courses
$students = $conn->query("SELECT id, name FROM students");
$courses = $conn->query("SELECT id, name FROM courses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Attendance - Panda</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url('./img/loginp.png') no-repeat center center/cover;
      min-height: 100vh;
      padding: 40px;
      color: #333;
    }

    .form-container {
      max-width: 600px;
      background: rgba(255,255,255,0.9);
      padding: 30px;
      margin: auto;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #4a47a3;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: 600;
    }

    select, input[type="date"] {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-top: 8px;
    }

    .btn {
      margin-top: 25px;
      width: 100%;
      padding: 14px;
      background-color: #6a5acd;
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 10px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #594bc1;
    }

    .msg {
      margin-top: 15px;
      text-align: center;
      font-weight: bold;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      color: #4a47a3;
      font-weight: bold;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>📅 Add Attendance</h2>
    <form action="add_attendance.php" method="POST">
      <label for="student_id">Student</label>
      <select name="student_id" required>
        <option value="">Select student</option>
        <?php while ($s = $students->fetch_assoc()): ?>
          <option value="<?= $s['id']; ?>"><?= htmlspecialchars($s['name']); ?></option>
        <?php endwhile; ?>
      </select>

      <label for="course_id">Course</label>
      <select name="course_id" required>
        <option value="">Select course</option>
        <?php while ($c = $courses->fetch_assoc()): ?>
          <option value="<?= $c['id']; ?>"><?= htmlspecialchars($c['name']); ?></option>
        <?php endwhile; ?>
      </select>

      <label for="date">Date</label>
      <input type="date" name="date" required>

      <label for="status">Status</label>
      <select name="status" required>
        <option value="">Select status</option>
        <option value="Present">Present</option>
        <option value="Absent">Absent</option>
        <option value="Late">Late</option>
      </select>

      <button type="submit" class="btn">Add Attendance</button>
    </form>

    <?php if ($success): ?>
      <p class="msg" style="color:green;"><?= $success ?></p>
    <?php elseif ($error): ?>
      <p class="msg" style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <a href="reports.php" class="back-link">← Back to Reports</a>
  </div>
</body>
</html>
