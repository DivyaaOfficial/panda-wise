<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

$teacher_id = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Panda Teacher Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f0f2f5;
    }
    .navbar {
      background: #5e4db2;
      color: white;
      padding: 16px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .navbar a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    .navbar a:hover {
      color: #ffd966;
    }
    .main {
      max-width: 960px;
      margin: 40px auto;
      padding: 0 16px;
    }
    h2 {
      text-align: center;
      color: #4a47a3;
      margin-bottom: 30px;
    }
    .cards {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      gap: 20px;
    }
    .card {
      background: white;
      flex: 1 1 280px;
      padding: 24px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      text-align: center;
      transition: transform 0.2s;
      text-decoration: none;
      color: #333;
    }
    .card:hover {
      transform: translateY(-4px);
      background: #f0f0ff;
    }
    .card h3 {
      color: #4a47a3;
      margin-bottom: 10px;
    }
    .footer {
      text-align: center;
      margin: 60px 0 20px;
      color: #666;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <div><strong>🐼 Panda Teacher Dashboard</strong></div>
    <div>
      <a href="add_assignment.php">➕ Create Assignment</a>
      <a href="view_assignment.php">📄 View Submissions</a>
      <a href="report.php">📊 Reports</a>
      <a href="logout.php">🔒 Logout</a>
    </div>
  </div>

  <div class="main">
    <h2>👋 Welcome, <?= htmlspecialchars($teacher_id) ?>!</h2>
    <div class="cards">
      <a href="add_assignment.php" class="card">
        <h3>➕ Create Assignment</h3>
        <p>Set new tasks and instructions for your students</p>
      </a>
      <a href="view_assignment.php" class="card">
        <h3>📄 Grade Submissions</h3>
        <p>Review and evaluate student submissions</p>
      </a>
      <a href="report.php" class="card">
        <h3>📊 Reports</h3>
        <p>Track grades, attendance & performance</p>
      </a>
    </div>
  </div>

  <div class="footer">
    &copy; <?= date('Y') ?> Panda Student Management. Designed for teachers & students 💙
  </div>
</body>
</html>
