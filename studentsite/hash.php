<?php
// db.php (include connection)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User credentials
$username = "admin";
$password = "123456";
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Prepare SQL
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

// Check if prepare worked
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind
$stmt->bind_param("ss", $username, $hashed);

// Execute
if ($stmt->execute()) {
    echo "User inserted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
