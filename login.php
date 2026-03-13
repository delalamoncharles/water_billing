<?php
session_start();
include 'db.php';

// Check if form submitted
if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Water Billing System</title>
<style>
    /* Global Styles */
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #4da6ff, #00bfff);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Glassmorphism Card */
    .login-container {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        padding: 40px 50px;
        width: 400px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        text-align: center;
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(-20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    h2 {
        color: #00f0ff;
        font-size: 26px;
        margin-bottom: 25px;
        text-shadow: 1px 1px 5px rgba(0,255,255,0.5);
    }

    input[type="text"], input[type="password"] {
        width: 90%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 10px;
        border: none;
        outline: none;
        font-size: 16px;
        background: rgba(255,255,255,0.2);
        color: #fff;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.2);
        transition: 0.3s;
    }

    input::placeholder {
        color: rgba(255,255,255,0.7);
    }

    input:focus {
        background: rgba(255,255,255,0.3);
        box-shadow: 0 0 10px rgba(0,255,255,0.6);
    }

    button {
        width: 95%;
        padding: 14px;
        margin-top: 15px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(90deg, #00e5ff, #0077cc);
        color: #fff;
        font-size: 18px;
        cursor: pointer;
        transition: 0.4s;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    button:hover {
        background: linear-gradient(90deg, #0077cc, #00e5ff);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    p {
        margin-top: 20px;
        font-size: 14px;
        color: #ccefff;
    }

    a {
        color: #00f0ff;
        text-decoration: none;
        transition: 0.3s;
    }

    a:hover {
        text-decoration: underline;
        color: #fff;
    }

    .message {
        margin-bottom: 15px;
        font-weight: bold;
    }

    .message.success { color: #00ffcc; }
    .message.error { color: #ff4d4d; }

</style>
</head>
<body>

<div class="login-container">
    <h2>Water Billing System Login</h2>

    <?php
    // Show logout message
    if(isset($_GET['message']) && $_GET['message'] == 'logged_out'){
        echo "<p class='message success'>You have logged out successfully.</p>";
    }

    // Show login error
    if(isset($error)){
        echo "<p class='message error'>$error</p>";
    }
    ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

</body>
</html>