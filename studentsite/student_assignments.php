<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch assignments
$assignment_sql = "SELECT * FROM assignments ORDER BY due_date ASC";
$assignment_result = $conn->query($assignment_sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Assignments</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      padding: 40px;
      background: #f4f4f8;
    }

    .container {
      max-width: 900px;
      margin: auto;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .top-bar h2 {
      margin: 0;
    }

    .back-link {
      text-decoration: none;
      background: #6a5acd;
      color: white;
      padding: 10px 16px;
      border-radius: 8px;
      font-size: 14px;
      transition: 0.3s;
    }

    .back-link:hover {
      background: #5949c7;
    }

    .assignment {
      background: white;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .assignment h3 {
      margin: 0 0 10px;
    }

    .assignment p {
      margin: 0 0 10px;
    }

    .assignment small {
      display: block;
      color: #666;
      margin-bottom: 10px;
    }

    .assignment .submitted {
      color: green;
      font-weight: bold;
    }

    .assignment .submit-btn {
      background: #6a5acd;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 8px;
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="top-bar">
    <h2>📚 My Assignments</h2>
    <a class="back-link" href="student_dashboard.php">← Back to Dashboard</a>
  </div>

  <?php while ($assignment = $assignment_result->fetch_assoc()): ?>
    <div class="assignment">
      <h3><?= htmlspecialchars($assignment['title']) ?></h3>
      <p><?= htmlspecialchars($assignment['description']) ?></p>
      <small>Due: <?= htmlspecialchars($assignment['due_date']) ?></small>

      <?php
        $check_stmt = $conn->prepare("SELECT id FROM submissions WHERE assignment_id = ? AND student_id = ?");
        $check_stmt->bind_param("ii", $assignment['id'], $student_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
      ?>

      <?php if ($check_result->num_rows > 0): ?>
        <p class="submitted">✅ Submitted</p>
      <?php else: ?>
        <a class="submit-btn" href="submit_assignment.php?assignment_id=<?= $assignment['id'] ?>">📤 Submit</a>
      <?php endif; ?>

    </div>
  <?php endwhile; ?>
</div>

</body>
</html>
