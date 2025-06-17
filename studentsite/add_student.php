<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course_id = $_POST['course_id'];

    $stmt = $conn->prepare("INSERT INTO students (name, email, course_id) VALUES (?, ?, ?)");
    $stmt = $conn->prepare("INSERT INTO students (name, email, course_id) VALUES (?, ?, ?)");
if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);  // <- This will show the actual SQL error
}

    $stmt->bind_param("ssi", $name, $email, $course_id);
    $stmt->execute();

    header("Location: students.php");
    exit();
}

// Fetch courses
$courses = $conn->query("SELECT id, name FROM courses");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Student</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: url('./img/loginb.png') no-repeat center center/cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
    }
    .overlay {
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }
    .form-container {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 40px;
      border-radius: 16px;
      backdrop-filter: blur(10px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
      width: 90%;
      max-width: 500px;
      position: relative;
      z-index: 2;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 28px;
      font-weight: 600;
      color: #ffffff;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
    }
    input, select {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #6a5acd;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover {
      background-color: #5a4db0;
    }
    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #fff;
      text-decoration: none;
      font-weight: bold;
    }
    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="overlay"></div>
  <div class="form-container">
    <h2>Add New Student</h2>
    <form method="post">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>

      <label for="course_id">Course</label>
      <select name="course_id" id="course_id" required>
        <option value="">-- Select Course --</option>
        <?php while ($row = $courses->fetch_assoc()): ?>
          <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
        <?php endwhile; ?>
      </select>

      <button type="submit">Add Student</button>
    </form>
    <a href="students.php" class="back-link">&#8592; Back to Student List</a>
  </div>
</body>
</html>
