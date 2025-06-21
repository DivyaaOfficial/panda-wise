<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $assignment_name = $_POST['assignment_name'];
    $score = $_POST['score'];
    $max_score = $_POST['max_score'];
    $grade = $_POST['grade'];
    $remarks = $_POST['remarks'];

    $sql = "INSERT INTO grades (student_id, course_id, assignment_name, score, max_score, grade, remarks)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisddss", $student_id, $course_id, $assignment_name, $score, $max_score, $grade, $remarks);

    if ($stmt->execute()) {
        $success = "Grade added successfully.";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Get students and courses
$students = $conn->query("SELECT id, name FROM students");
$courses = $conn->query("SELECT id, name FROM courses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Grade - Panda Wise</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f6fb;
      padding: 40px;
    }
    .form-container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #4a47a3;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin: 15px 0 5px;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    button {
      background-color: #6a5acd;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 10px;
      margin-top: 20px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
    }
    .message {
      text-align: center;
      margin-top: 20px;
      color: green;
      font-weight: bold;
    }
    .error {
      color: red;
    }
    .back-link {
      display: inline-block;
      margin-top: 20px;
      text-align: center;
      text-decoration: none;
      color: #4a47a3;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>➕ Add Student Grade</h2>

    <?php if (!empty($success)) echo "<p class='message'>$success</p>"; ?>
    <?php if (!empty($error)) echo "<p class='message error'>$error</p>"; ?>

    <form method="POST">
      <label for="student_id">Student</label>
      <select name="student_id" required>
        <option value="">-- Select Student --</option>
        <?php while($s = $students->fetch_assoc()): ?>
          <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['name']); ?></option>
        <?php endwhile; ?>
      </select>

      <label for="course_id">Course</label>
      <select name="course_id" required>
        <option value="">-- Select Course --</option>
        <?php while($c = $courses->fetch_assoc()): ?>
          <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
        <?php endwhile; ?>
      </select>

      <label for="assignment_name">Assignment Name</label>
      <input type="text" name="assignment_name" required />

      <label for="score">Score</label>
      <input type="number" step="0.01" name="score" required />

      <label for="max_score">Max Score</label>
      <input type="number" step="0.01" name="max_score" required />

      <label for="grade">Grade</label>
      <input type="text" name="grade" required />

      <label for="remarks">Remarks</label>
      <textarea name="remarks"></textarea>

      <button type="submit">Submit</button>
    </form>

    <div style="text-align:center;">
      <a class="back-link" href="reports.php">&larr; Back to Reports</a>
    </div>
  </div>
</body>
</html>
