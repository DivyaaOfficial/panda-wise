<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$student_id = $_SESSION['student_id'];
$student = null;

if ($student_id) {
    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();
    }
}

if (!$student) {
    echo "<h1 style='color:red;text-align:center;'>⚠️ Student profile not found in database. Please contact admin.</h1>";
    echo "<p style='text-align:center;'>Student ID from session: " . htmlspecialchars($student_id) . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panda Student Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background: #f0f4f8;
    }
    .navbar {
      background-color: #4a47a3;
      color: white;
      padding: 16px 32px;
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
    }
    .navbar a:hover {
      color: #ffd966;
    }
    .container {
      max-width: 960px;
      margin: 40px auto;
      background: white;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    h1 {
      color: #4a47a3;
      font-size: 28px;
      margin-bottom: 30px;
      text-align: center;
    }
    .card-grid {
      display: flex;
      justify-content: space-around;
      gap: 20px;
      flex-wrap: wrap;
    }
    .card {
      background: #f5f4ff;
      padding: 24px;
      border-radius: 12px;
      text-align: center;
      text-decoration: none;
      color: #333;
      width: 280px;
      transition: all 0.3s ease;
      box-shadow: 0 6px 16px rgba(0,0,0,0.05);
    }
    .card:hover {
      background: #e4e2ff;
      transform: translateY(-5px);
    }
    .logout {
      text-align: center;
      margin-top: 30px;
    }
    .logout a {
      background: #6a5acd;
      color: white;
      padding: 10px 24px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
    }
    .logout a:hover {
      background-color: #574bc8;
    }
    .footer {
      text-align: center;
      padding: 20px;
      color: #888;
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="navbar">
  <div><strong>🐼 Panda Student Dashboard</strong></div>
  <div><a href="logout.php">Logout</a></div>
</div>
<div class="container">
  <h1>👋 Welcome, <?= htmlspecialchars($student['name']) ?>!</h1>
  <div class="card-grid">
    <a href="student_assignments.php" class="card">
      <h3>📚 Assignments</h3>
      <p>View and submit your tasks</p>
    </a>
    <a href="student_profile.php?id=<?= $student_id ?>" class="card">
      <h3>🧾 Profile</h3>
      <p>View your grades and attendance</p>
    </a>
  </div>
  <div class="logout">
    <a href="logout.php">🚪 Logout</a>
  </div>
</div>
<div class="footer">
  &copy; <?= date('Y') ?> Panda Student Management. Designed for student success 🐼💙
</div>
</body>
</html>
