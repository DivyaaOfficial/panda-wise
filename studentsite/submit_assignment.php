<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$assignment_id = isset($_GET['assignment_id']) ? intval($_GET['assignment_id']) : 0;
$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content']);
    $assignment_id = intval($_POST['assignment_id']); // Hidden input

    if (empty($content)) {
        $error = "❌ Assignment content cannot be empty.";
    } else {
        $stmt = $conn->prepare("INSERT INTO submissions (assignment_id, student_id, content) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("iis", $assignment_id, $student_id, $content);
            if ($stmt->execute()) {
                header("Location: student_assignments.php?submitted=1");
                exit();
            } else {
                $error = "❌ Submission failed: " . $stmt->error;
            }
        } else {
            $error = "❌ Prepare failed: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Submit Assignment</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      padding: 40px;
      background-color: #f4f4f8;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    textarea {
      width: 100%;
      height: 200px;
      padding: 10px;
      font-size: 16px;
      border-radius: 8px;
      border: 1px solid #ccc;
      resize: vertical;
    }
    button {
      margin-top: 15px;
      background: #6a5acd;
      color: white;
      border: none;
      padding: 10px 20px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
    }
    .message {
      margin-top: 10px;
      font-size: 14px;
    }
    .success { color: green; }
    .error { color: red; }
  </style>
</head>
<body>
  <div class="container">
    <h2>📤 Submit Assignment</h2>

    <?php if ($success): ?>
      <p class="message success"><?= $success ?></p>
    <?php elseif ($error): ?>
      <p class="message error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment_id) ?>">
      <textarea name="content" placeholder="Write or paste your assignment here..." required></textarea>
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>
