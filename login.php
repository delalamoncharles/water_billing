<!DOCTYPE html>
<html>
<head>
    <title>Login - Water Billing System</title>
</head>
<body>

<h2>Water Billing System Login</h2>

<?php
// Place it here, right after <body> and the page heading
if(isset($_GET['message']) && $_GET['message'] == 'logged_out'){
    echo "<p style='color:green;'>You have logged out successfully.</p>";
}

// Optional: show login errors
if(isset($error)){
    echo "<p style='color:red;'>$error</p>";
}
?>

<form method="POST">
    Username:<br>
    <input type="text" name="username" required><br><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

<p>Don't have an account? <a href="register.php">Register here</a></p>

</body>
</html>