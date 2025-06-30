<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

$assignments = $conn->query("SELECT * FROM assignments ORDER BY due_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Grade Submissions</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f8;
      padding: 30px;
    }
    .container {
      max-width: 1000px;
      margin: auto;
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    h2 {
      margin-bottom: 20px;
      color: #333;
    }
    .success {
      color: green;
      margin-bottom: 15px;
    }
    .assignment {
      margin-bottom: 40px;
    }
    .assignment h3 {
      color: #444;
      margin-bottom: 10px;
    }
    .submission {
      border-top: 1px solid #ddd;
      padding: 15px 0;
    }
    .submission strong {
      display: block;
      margin-bottom: 5px;
    }
    textarea, input[type="text"] {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-top: 10px;
    }
    .grade-btn {
      background: #6a5acd;
      color: white;
      padding: 8px 18px;
      border: none;
      border-radius: 8px;
      margin-top: 10px;
      cursor: pointer;
    }
    .grade-btn:hover {
      background: #5949b1;
    }
  </style>
</head>
<body>
<div class="container">
  <h2>Grade Student Submissions</h2>

  <?php if (isset($_GET['success'])): ?>
    <p class="success">✅ Grade submitted successfully!</p>
  <?php endif; ?>

  <?php while ($assignment = $assignments->fetch_assoc()): ?>
    <div class="assignment">
      <h3><?= htmlspecialchars($assignment['title']) ?> (Due: <?= $assignment['due_date'] ?>)</h3>

      <?php
        $stmt = $conn->prepare("SELECT s.*, u.username, g.grade 
                                FROM submissions s 
                                JOIN users u ON s.student_id = u.id
                                LEFT JOIN grades g ON s.id = g.submission_id
                                WHERE s.assignment_id = ?");
        $stmt->bind_param("i", $assignment['id']);
        $stmt->execute();
        $results = $stmt->get_result();
      ?>

      <?php if ($results->num_rows > 0): ?>
        <?php while ($sub = $results->fetch_assoc()): ?>
          <div class="submission">
            <strong>👤 <?= htmlspecialchars($sub['username']) ?></strong>
            <p>📄 <?= nl2br(htmlspecialchars($sub['content'])) ?></p>
            <form method="POST" action="grade_submission.php">
              <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
              <label for="grade">Grade:</label>
              <input type="text" name="grade" placeholder="e.g. A+, 85/100" value="<?= $sub['grade'] ?? '' ?>" required>
              <button class="grade-btn" type="submit">Submit Grade</button>
            </form>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No submissions yet.</p>
      <?php endif; ?>
    </div>
  <?php endwhile; ?>

</div>
</body>
</html>

