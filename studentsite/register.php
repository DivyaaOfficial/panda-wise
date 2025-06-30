<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    $check = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "Username already taken.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $username, $hashed, $role);
            if ($stmt->execute()) {
                $new_user_id = $stmt->insert_id;

                // If student, also add to students table
                if ($role === 'student') {
                    $default_name = $username; // or ask for name separately
                    $stmt2 = $conn->prepare("INSERT INTO students (id, name) VALUES (?, ?)");
                    $stmt2->bind_param("is", $new_user_id, $default_name);
                    $stmt2->execute();
                }

                $success = "User registered successfully!";
            } else {
                $error = "Registration failed: " . $stmt->error;
            }
        } else {
            $error = "Prepare failed: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - Panda Student Management</title>
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

    .message {
      margin-top: 15px;
      font-size: 14px;
    }

    .message.success {
      color: #90ee90;
    }

    .message.error {
      color: #ff7f7f;
    }

    .login-content a {
      display: block;
      margin-top: 15px;
      color: #f0f0f0;
      text-decoration: none;
      font-size: 14px;
    }

    .login-content a:hover {
      text-decoration: underline;
    }
    .login-content select {
      width: 100%;
      padding: 14px;
      margin: 10px 0;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      outline: none;
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
      <h2>Create an Account</h2>

      <form method="POST" action="" autocomplete="off">
        <input type="text" name="username" placeholder="Username" required autocomplete="off" />
        <input type="password" name="password" placeholder="Password" required autocomplete="new-password" />
        
        <!-- NEW: Role dropdown -->
        <select name="role" required>
          <option value="">Select Role</option>
          <option value="student">Student</option>
          <option value="teacher">Teacher</option>
        </select>

        <button type="submit">Sign Up</button>
      </form>

      <?php if ($success): ?>
        <p class="message success"><?= $success ?></p>
      <?php elseif ($error): ?>
        <p class="message error"><?= $error ?></p>
      <?php endif; ?>

      <a href="login.php">Already have an account? Log in</a>
    </div>
  </div>

  <script>
    window.onload = function () {
      document.querySelector('input[name="username"]').value = "";
      document.querySelector('input[name="password"]').value = "";
    };
  </script>

</body>
</html>
