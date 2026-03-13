<?php
session_start();
include 'db.php';

if(isset($_POST['register'])){

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username already exists
    $check = $conn->query("SELECT * FROM users WHERE username='$username'");
    if($check->num_rows > 0){
        $error = "Username already exists!";
    } else {
        $sql = "INSERT INTO users (email,username,password) 
                VALUES ('$email','$username','$password')";
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
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - Water Billing System</title>
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
    .register-container {
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

    input[type="email"], input[type="text"], input[type="password"] {
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

    .error-message {
        color: #ff4d4d;
        margin-bottom: 15px;
        font-weight: bold;
    }

</style>
</head>
<body>

<div class="register-container">
    <h2>Register New Account</h2>

    <?php
    if(isset($error)){
        echo "<p class='error-message'>$error</p>";
    }
    ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="register">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

</body>
</html>