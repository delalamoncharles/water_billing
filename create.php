<?php
include 'db.php';

if(isset($_POST['submit'])){

$name = $_POST['name'];
$email = $_POST['email'];
$course = $_POST['course'];

$sql = "INSERT INTO users (name,email,course)
VALUES ('$name','$email','$course')";

$conn->query($sql);

header("Location: index.php");

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add User</title>
</head>

<body>

<h2>Add New User</h2>

<form method="POST">

Name:<br>
<input type="text" name="name" required><br><br>

Email:<br>
<input type="email" name="email" required><br><br>

Course:<br>
<input type="text" name="course" required><br><br>

<button type="submit" name="submit">Save</button>

</form>

</body>
</html>