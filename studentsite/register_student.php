<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $class = $_POST['class'];
    $email = $_POST['email'];

    $sql = "INSERT INTO students (name, age, class, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $name, $age, $class, $email);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Student registered successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
}
?>

<h2>Register New Student</h2>
<form method="POST" action="">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Age:</label><br>
    <input type="number" name="age" required><br><br>

    <label>Class:</label><br>
    <input type="text" name="class" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <input type="submit" value="Register Student">
</form>

<a href="dashboard.php">← Back to Dashboard</a>
