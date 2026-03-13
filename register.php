<?php
session_start();
include 'db.php';

if(isset($_POST['register'])){

    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course']; // optional field if you are using courses
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username already exists
    $check = $conn->query("SELECT * FROM users WHERE username='$username'");
    if($check->num_rows > 0){
        $error = "Username already exists!";
    } else {
        // Insert new user into the database
        $sql = "INSERT INTO users (name,email,course,username,password) 
                VALUES ('$name','$email','$course','$username','$password')";
        if($conn->query($sql) === TRUE){
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Water Billing System</title>
</head>
<body>

<h2>Register New Account</h2>

<?php
if(isset($error)){
    echo "<p style='color:red;'>$error</p>";
}
?>

<form method="POST">

Name:<br>
<input type="text" name="name" required><br><br>

Email:<br>
<input type="email" name="email" required><br><br>

Course:<br>
<input type="text" name="course"><br><br>

Username:<br>
<input type="text" name="username" required><br><br>

Password:<br>
<input type="password" name="password" required><br><br>

<button type="submit" name="register">Register</button>

</form>

<p>Already have an account? <a href="login.php">Login here</a></p>

</body>
</html>