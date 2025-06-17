<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch courses
$sql = "SELECT id, name, description FROM courses";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Courses</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url('./img/loginp.png') no-repeat center center/cover;
      color: #333;
      margin: 0;
      padding: 40px;
    }

    .container {
      background: rgba(255,255,255,0.95);
      max-width: 900px;
      margin: auto;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .add-btn {
      background: #6a5acd;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
    }

    .add-btn:hover {
      background: #5a4db0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #ccc;
    }

    th {
      background: #f4f4f9;
    }

    .actions a {
      margin-right: 10px;
      text-decoration: none;
      color: #4a47a3;
      font-weight: bold;
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
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Manage Courses</h2>
    <a href="add_course.php" class="add-btn">+ Add Course</a>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Course Name</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']); ?></td>
              <td><?php echo htmlspecialchars($row['name']); ?></td>
              <td><?php echo htmlspecialchars($row['description']); ?></td>
              <td class="actions">
                <a href="edit_course.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_course.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="4">No courses found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <a href="dashboard.php" class="back-link">&#8592; Back to Dashboard</a>
  </div>
</body>
</html>
