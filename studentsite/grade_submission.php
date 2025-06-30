<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['assignment_id'])) {
    echo "❌ No assignment ID provided.";
    exit();
}

$assignment_id = intval($_GET['assignment_id']);

// Get assignment title
$assignment_stmt = $conn->prepare("SELECT title FROM assignments WHERE id = ?");
$assignment_stmt->bind_param("i", $assignment_id);
$assignment_stmt->execute();
$assignment_result = $assignment_stmt->get_result();
$assignment = $assignment_result->fetch_assoc();

if (!$assignment) {
    echo "❌ Assignment not found.";
    exit();
}

// Get student submissions
$stmt = $conn->prepare("
    SELECT s.*, u.username, g.grade 
    FROM submissions s
    JOIN users u ON s.student_id = u.id
    LEFT JOIN grades g ON s.id = g.submission_id
    WHERE s.assignment_id = ?
");
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$submissions = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Grade Submissions</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f6f8;
      padding: 40px;
    }
    .container {
      max-width: 900px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    h2 {
      color: #4a47a3;
      margin-bottom: 30px;
    }
    .submission {
      border-bottom: 1px solid #eee;
      padding: 15px 0;
    }
    .submission:last-child {
      border-bottom: none;
    }
    textarea, input[type="text"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-top: 10px;
    }
    .grade-btn {
      background: #6a5acd;
      color: white;
      padding: 10px 16px;
      border: none;
      border-radius: 8px;
      margin-top: 10px;
      cursor: pointer;
    }
    .grade-btn:hover {
      background: #594bc8;
    }
    .back-link {
      display: inline-block;
      margin-top: 30px;
      text-decoration: none;
      color: #4a47a3;
      font-weight: bold;
    }
  </style>
</head>
<body>
<div class="container">
  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <p style="color: green; font-weight: bold; margin-bottom: 20px;">
    ✅ Grade submitted successfully!
  </p>
<?php endif; ?>

  <h2>📝 Grading: <?= htmlspecialchars($assignment['title']) ?></h2>

  <?php if ($submissions->num_rows > 0): ?>
    <?php while ($sub = $submissions->fetch_assoc()): ?>
      <div class="submission">
        <strong>👤 <?= htmlspecialchars($sub['username']) ?></strong>
        <p>📄 <?= nl2br(htmlspecialchars($sub['content'])) ?></p>

        <!-- Grade Submission Form -->
        <form method="POST" action="grade_submission_process.php">
  <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
  <input type="hidden" name="assignment_id" value="<?= $assignment_id ?>">
  <label for="grade">Grade:</label>
  <input type="text" name="grade" value="<?= htmlspecialchars($sub['grade'] ?? '') ?>" required>
  <button class="grade-btn" type="submit">Submit Grade</button>
</form>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No submissions for this assignment.</p>
  <?php endif; ?>

  <a class="back-link" href="view_assignments.php">← Back to Assignments</a>
</div>
</body>
</html>
