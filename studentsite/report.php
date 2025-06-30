<?php
session_start();
include 'db.php';

// Only allow teachers or admins to access
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['teacher', 'admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch attendance, student data, and average grade
$query = "
    SELECT 
        u.id AS student_id,
        u.username,
        COUNT(a.id) AS total_sessions,
        SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) AS days_present,
        ROUND(
            (SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) / COUNT(a.id)) * 100,
            2
        ) AS attendance_percentage,
        ROUND(AVG(
            CASE 
                WHEN g.grade REGEXP '^[0-9]+$' THEN CAST(g.grade AS UNSIGNED)
                WHEN g.grade REGEXP '^[0-9]+\\/[0-9]+$' THEN 
                    CAST(SUBSTRING_INDEX(g.grade, '/', 1) AS UNSIGNED) / 
                    CAST(SUBSTRING_INDEX(g.grade, '/', -1) AS UNSIGNED) * 100
                ELSE NULL
            END
        ), 2) AS average_grade
    FROM users u
    LEFT JOIN attendance a ON u.id = a.student_id
    LEFT JOIN submissions s ON u.id = s.student_id
    LEFT JOIN grades g ON s.id = g.submission_id
    WHERE u.role = 'student'
    GROUP BY u.id
    ORDER BY u.username ASC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>📊 Student Attendance & Grade Report</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6fc;
      padding: 40px;
    }
    .container {
      max-width: 1200px;
      margin: auto;
      background: white;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }
    h2 {
      color: #443c74;
      margin-bottom: 30px;
      font-size: 28px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 16px;
      border-bottom: 1px solid #eaeaea;
      text-align: center;
      font-size: 15px;
    }
    th {
      background-color: #edf0f9;
      color: #333;
      font-weight: 600;
    }
    tr:hover td {
      background-color: #fafbff;
    }
    .back-btn {
      display: inline-block;
      margin-top: 30px;
      text-decoration: none;
      background: #6a5acd;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: bold;
      transition: background 0.3s;
    }
    .back-btn:hover {
      background-color: #5848c2;
    }
  </style>
</head>
<body>
<div class="container">
  <h2>📊 Student Attendance & Grade Report</h2>

  <table>
    <thead>
      <tr>
        <th>👤 Student</th>
        <th>✅ Days Present</th>
        <th>📅 Total Sessions</th>
        <th>📈 Attendance %</th>
        <th>🎓 Avg Grade</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= $row['days_present'] ?></td>
            <td><?= $row['total_sessions'] ?></td>
            <td><?= $row['attendance_percentage'] ?? 0 ?>%</td>
            <td><?= $row['average_grade'] !== null ? $row['average_grade'] . '%' : 'N/A' ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5">No attendance or grade records found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <a href="teacher_dashboard.php" class="back-btn">← Back to Dashboard</a>
</div>
</body>
</html>
