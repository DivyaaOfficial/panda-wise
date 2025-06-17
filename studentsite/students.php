<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch students from the database
$sql = "SELECT id, name, email, class AS course FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: url('./img/loginp.png') no-repeat center center/cover;
      color: #333;
      height:100vh;
    }

    header {
      background: rgba(74, 71, 163, 0.95);
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 30px;
      font-weight: bold;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .container {
      padding: 40px;
      max-width: 1100px;
      margin: 40px auto;
      background: rgba(255,255,255,0.95);
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .add-btn {
      background: #6a5acd;
      color: white;
      padding: 12px 24px;
      text-decoration: none;
      border-radius: 10px;
      margin-bottom: 20px;
      display: inline-block;
      font-weight: bold;
      transition: background 0.3s, transform 0.2s;
    }

    .add-btn:hover {
      background: #594bc8;
      transform: translateY(-2px);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      border-radius: 12px;
      overflow: hidden;
    }

    th, td {
      padding: 16px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background: #f4f4f9;
      font-weight: 600;
    }

    tr:hover td {
      background-color: #f0f8ff;
    }

    .actions a {
      margin-right: 12px;
      text-decoration: none;
      color: #4a47a3;
      font-weight: 600;
    }

    .actions a:hover {
      text-decoration: underline;
    }

    .back-link {
      display: inline-block;
      margin-top: 30px;
      color: #4a47a3;
      font-weight: bold;
      text-decoration: none;
      transition: color 0.3s;
    }

    .back-link:hover {
      color: #2c2a7a;
    }

    .debug-message {
      background: #d4edda;
      color: #155724;
      padding: 12px 20px;
      border-left: 5px solid #28a745;
      margin-bottom: 20px;
      border-radius: 6px;
    }

    .error-message {
      background: #f8d7da;
      color: #721c24;
      padding: 12px 20px;
      border-left: 5px solid #dc3545;
      margin-bottom: 20px;
      border-radius: 6px;
    }
  </style>
</head>
<body>
  <header>Student Management</header>
  <div class="container">

    <a href="add_student.php" class="add-btn">+ Add Student</a>

    <?php
    if ($result === false) {
        echo "<div class='error-message'>❌ SQL Error: " . $conn->error . "</div>";
    } elseif ($result->num_rows === 0) {
        echo "<div class='debug-message'>✅ Query worked, but no students found. Please add some students first.</div>";
    } else {
        echo "<div class='debug-message'>✅ Found " . $result->num_rows . " student(s).</div>";
    }
    ?>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Course</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']); ?></td>
              <td><?php echo htmlspecialchars($row['name']); ?></td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo htmlspecialchars($row['course']); ?></td>
              <td class="actions">
                <a href="edit_student.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_student.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                <a href="student_profile.php?id=<?php echo $row['id']; ?>">View</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <a href="dashboard.php" class="back-link">&#8592; Back to Dashboard</a>
  </div>
</body>
</html>
