<?php
include 'db.php';
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $sql = "UPDATE students SET name=?, email=?, course=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $course, $id);
    $stmt->execute();
    header("Location: students.php");
    exit();
} else {
    $sql = "SELECT * FROM students WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Student</title></head>
<body>
<h2>Edit Student</h2>
<form method="post">
  Name: <input type="text" name="name" value="<?php echo $student['name']; ?>" required><br>
  Email: <input type="email" name="email" value="<?php echo $student['email']; ?>" required><br>
  Course: <input type="text" name="course" value="<?php echo $student['course']; ?>" required><br>
  <button type="submit">Update</button>
</form>
<a href="students.php">Back</a>
</body>
</html>