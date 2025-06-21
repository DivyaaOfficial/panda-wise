<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reports - Panda Wise</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      padding: 0;
      margin: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: url('./img/loginp.png') no-repeat center center/cover;
      min-height: 100vh;
      padding: 40px 20px;
      color: #333;
    }

    h1 {
      text-align: center;
      color: #ffffff;
      margin-bottom: 40px;
      font-size: 36px;
      text-shadow: 1px 1px 8px rgba(0,0,0,0.3);
    }

    .section {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 16px;
      padding: 30px;
      margin-bottom: 50px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.2);
      animation: fadeIn 1s ease-in-out;
      color: white;
    }

    .section h2 {
      font-size: 24px;
      margin-bottom: 20px;
      border-bottom: 2px solid #6a5acd;
      padding-bottom: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 14px 16px;
      text-align: left;
    }

    th {
      background-color: rgba(255, 255, 255, 0.15);
      color: #eee;
      font-weight: 600;
    }

    td {
      background-color: rgba(255, 255, 255, 0.05);
      color: #f2f2f2;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .status {
      padding: 6px 12px;
      border-radius: 20px;
      font-weight: bold;
      display: inline-block;
    }

    .status.present { background-color: #28a745; color: white; }
    .status.absent { background-color: #dc3545; color: white; }
    .status.late { background-color: #ffc107; color: black; }

    .back-link {
      display: inline-block;
      text-decoration: none;
      background-color: #6a5acd;
      color: white;
      padding: 12px 24px;
      border-radius: 10px;
      font-weight: bold;
      transition: background 0.3s;
    }

    .back-link:hover {
      background-color: #594bc1;
    }

    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 28px;
      }

      .section {
        padding: 20px;
      }

      th, td {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

  <h1>📊 Student Reports</h1>

  <!-- Attendance Section -->
  <div class="section">
    <h2>📅 Attendance</h2>
    <table>
      <thead>
        <tr>
          <th>Student Name</th>
          <th>Course</th>
          <th>Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $attendance_sql = "SELECT a.*, s.name AS student_name, c.name AS course_name 
                           FROM attendance a 
                           JOIN students s ON a.student_id = s.id 
                           JOIN courses c ON a.course_id = c.id 
                           ORDER BY a.date DESC LIMIT 20";
        $attendance_result = $conn->query($attendance_sql);

        if ($attendance_result && $attendance_result->num_rows > 0):
          while ($row = $attendance_result->fetch_assoc()):
            $statusClass = strtolower($row['status']);
            ?>
            <tr>
              <td><?php echo htmlspecialchars($row['student_name']); ?></td>
              <td><?php echo htmlspecialchars($row['course_name']); ?></td>
              <td><?php echo htmlspecialchars($row['date']); ?></td>
              <td><span class="status <?php echo $statusClass; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
            </tr>
          <?php endwhile;
        else:
          echo "<tr><td colspan='4'>No attendance records found.</td></tr>";
        endif;
        ?>
      </tbody>
    </table>
  </div>

  <!-- Grades Section -->
  <div class="section">
    <h2>📚 Grades</h2>
    <table>
      <thead>
        <tr>
          <th>Student Name</th>
          <th>Course</th>
          <th>Assignment</th>
          <th>Score</th>
          <th>Max Score</th>
          <th>Grade</th>
          <th>Remarks</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $grades_sql = "SELECT g.*, s.name AS student_name, c.name AS course_name 
                       FROM grades g 
                       JOIN students s ON g.student_id = s.id 
                       JOIN courses c ON g.course_id = c.id 
                       ORDER BY g.student_id LIMIT 20";
        $grades_result = $conn->query($grades_sql);

        if ($grades_result && $grades_result->num_rows > 0):
          while ($row = $grades_result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['student_name']); ?></td>
              <td><?php echo htmlspecialchars($row['course_name']); ?></td>
              <td><?php echo htmlspecialchars($row['assignment_name']); ?></td>
              <td><?php echo htmlspecialchars($row['score']); ?></td>
              <td><?php echo htmlspecialchars($row['max_score']); ?></td>
              <td><?php echo htmlspecialchars($row['grade']); ?></td>
              <td><?php echo htmlspecialchars($row['remarks']); ?></td>
            </tr>
          <?php endwhile;
        else:
          echo "<tr><td colspan='7'>No grade records found.</td></tr>";
        endif;
        ?>
      </tbody>
    </table>
  </div>

  <div style="text-align:center;">
    <a href="add_grade.php" class="back-link">➕ Add New Grade</a>
    <a href="add_attendance.php" class="back-link">➕ Add Attendance</a>
    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
  </div>

</body>
</html>
