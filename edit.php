<?php
include 'db.php';

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM users WHERE id=$id");
$row = $result->fetch_assoc();

if(isset($_POST['update'])){

$name = $_POST['name'];
$email = $_POST['email'];
$course = $_POST['course'];

$sql = "UPDATE users 
SET name='$name', email='$email', course='$course'
WHERE id=$id";

$conn->query($sql);

header("Location: index.php");

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit User</title>
</head>

<body>

<h2>Edit User</h2>

<form method="POST">

Name:<br>
<input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>

Email:<br>
<input type="email" name="email" value="<?php echo $row['email']; ?>"><br><br>

Course:<br>
<input type="text" name="course" value="<?php echo $row['course']; ?>"><br><br>

<button type="submit" name="update">Update</button>

</form>

</body>
</html>