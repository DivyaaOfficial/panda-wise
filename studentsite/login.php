<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Panda Student Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body, html {
      height: 100%;
      font-family: 'Poppins', sans-serif;
    }

    .bg {
      background: url('./img/loginb.png') no-repeat center center/cover;
      height: 100%;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .overlay {
      position: absolute;
      top: 0; left: 0;
      height: 100%;
      width: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .login-content {
      position: relative;
      z-index: 2;
      background-color: rgba(255, 255, 255, 0.1);
      padding: 40px;
      border-radius: 16px;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 30px rgba(0,0,0,0.3);
      text-align: center;
      color: white;
      max-width: 400px;
      width: 90%;
      animation: fadeSlideIn 1.2s ease forwards;
      opacity: 0;
      transform: translateY(30px);
    }

    @keyframes fadeSlideIn {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-content h2 {
      margin-bottom: 25px;
      font-size: 32px;
      font-weight: 600;
    }

    .login-content input {
      width: 100%;
      padding: 14px;
      margin: 10px 0;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      outline: none;
    }

    .login-content button {
      width: 100%;
      padding: 14px;
      background-color: #6a5acd;
      color: white;
      border: none;
      font-size: 16px;
      font-weight: bold;
      border-radius: 10px;
      cursor: pointer;
      transition: background 0.3s;
      margin-top: 10px;
    }

    .login-content button:hover {
      background-color: #5a4db0;
    }

    .forgot-link,
    .home-link {
      margin-top: 15px;
      display: block;
      font-size: 14px;
      color: #f0f0f0;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .forgot-link:hover,
    .home-link:hover {
      color: #dcdcdc;
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .login-content h2 {
        font-size: 26px;
      }
    }
  </style>
</head>
<body>

  <div class="bg">
    <div class="overlay"></div>
    <div class="login-content">
      <h2>Login to Panda</h2>
      <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Log In</button>
      </form>

      <a href="index.html" class="home-link">← Back to Home</a>

      <?php if ($error): ?>
        <p style="color: #ffaaaa; margin-top: 10px;"><?php echo $error; ?></p>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>
