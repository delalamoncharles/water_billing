<?php
session_start();

if(!isset($_SESSION['username'])){
header("Location: login.php");
exit();
}
?>

<?php
include 'db.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Users CRUD</title>
</head>

<body>
<a href="logout.php">Logout</a>

<h2>Users List</h2>

<a href="create.php">Add New User</a>

<table border="1" cellpadding="10" cellspacing="0">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Course</th>
    <th>Actions</th>
</tr>

<?php
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['course']; ?></td>
    <td>
        <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
    </td>
</tr>

<?php
    }
} else {
    echo "<tr><td colspan='5'>No users found</td></tr>";
}
?>

</table>

</body>
</html>