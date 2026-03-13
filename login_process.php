<?php
session_start();
include 'db.php'; // database connection

if(isset($_POST['login'])){
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check username and password
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: login.php?error=Invalid+Username+or+Password");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>