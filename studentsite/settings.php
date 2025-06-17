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
  <title>Settings - Panda Wise</title>
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
      padding: 40px 10px;
    }

    .overlay {
      position: absolute;
      top: 0; left: 0;
      height: 100%;
      width: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 0;
    }

    .settings-box {
      position: relative;
      z-index: 1;
      background-color: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      color: white;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.3);
      max-width: 500px;
      width: 100%;
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

    h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 32px;
      font-weight: 600;
    }

    .section {
      margin-bottom: 30px;
    }

    .section h3 {
      font-size: 20px;
      margin-bottom: 10px;
    }

    .section input,
    .section select {
      width: 100%;
      padding: 14px;
      margin: 8px 0 16px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      outline: none;
    }

    .section button {
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
    }

    .section button:hover {
      background-color: #5a4db0;
    }

    @media (max-width: 768px) {
      .settings-box {
        padding: 30px 20px;
      }
      h2 {
        font-size: 26px;
      }
    }
  </style>
</head>
<body>
  <div class="bg">
    <div class="overlay"></div>
    <div class="settings-box">
      <h2>Settings</h2>

      <div class="section">
        <h3>Change Password</h3>
        <form action="update_password.php" method="POST">
          <input type="password" name="current_password" placeholder="Current Password" required>
          <input type="password" name="new_password" placeholder="New Password" required>
          <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
          <button type="submit">Update Password</button>
        </form>
      </div>

      <div class="section">
        <h3>Update Email</h3>
        <form action="update_email.php" method="POST">
          <input type="email" name="new_email" placeholder="New Email Address" required>
          <button type="submit">Update Email</button>
        </form>
      </div>

      <div class="section">
        <h3>Theme Preferences</h3>
        <form action="update_theme.php" method="POST">
          <select name="theme">
            <option value="light">Light</option>
            <option value="dark">Dark</option>
          </select>
          <button type="submit">Save Theme</button>
        </form>
      </div>
      <div class="section">
  <h3>Update Profile Picture</h3>
  <form action="update_profile_pic.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="profile_pic" accept="image/*" required>
    <button type="submit">Upload Picture</button>
  </form>
</div>

<div class="section">
  <h3>Delete Account</h3>
  <form action="delete_account.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
    <button type="submit" style="background-color: crimson;">Delete My Account</button>
  </form>
</div>

    </div>
  </div>
</body>
</html>
