<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - Panda Wise</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: url('./img/loginp.png') no-repeat center center/cover;
      min-height: 100vh;
      padding: 40px;
      position: relative;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.8);
      z-index: 1;
    }

    .container {
      position: relative;
      z-index: 2;
      max-width: 900px;
      margin: auto;
      background: white;
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      text-align: center;
    }

    h1 {
      font-size: 32px;
      margin-bottom: 10px;
      color: #333;
    }

    p {
      font-size: 18px;
      color: #666;
      margin-bottom: 30px;
    }

    .card-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }

    .card {
      background-color: #f9f9f9;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
      transition: transform 0.2s ease;
      text-decoration: none;
      color: #333;
    }

    .card:hover {
      transform: translateY(-5px);
      background-color: #e6e6fa;
    }

    .card h3 {
      font-size: 20px;
      color: #444;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 14px;
      color: #777;
    }

    .logout {
      margin-top: 30px;
    }

    .logout a {
      text-decoration: none;
      background-color: #6a5acd;
      color: white;
      padding: 12px 25px;
      border-radius: 8px;
      transition: background 0.3s;
    }

    .logout a:hover {
      background-color: #5a4db0;
    }
  </style>
</head>
<body>

  <div class="overlay"></div>

  <div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>You are now logged in to Panda Wise!.</p>

    <div class="card-grid">
      <a href="students.php" class="card">
        <h3>Students</h3>
        <p>View and manage student profiles</p>
      </a>
      <a href="courses.php" class="card">
        <h3>Courses</h3>
        <p>Assign, edit and manage courses</p>
      </a>
      <a href="reports.php" class="card">
        <h3>Reports</h3>
        <p>Generate progress and attendance reports</p>
      </a>
      <a href="settings.php" class="card">
        <h3>Settings</h3>
        <p>Manage site preferences and users</p>
      </a>
    </div>

    <div class="logout">
      <a href="logout.php">Logout</a>
    </div>
  </div>

</body>
</html>
