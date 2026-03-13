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
/* Keep original full-screen background */
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Poppins', sans-serif;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #0b0f1a, #001f3f);
    color: #fff;
}

#network {
    position: absolute;
    top:0; left:0;
    width:100%; height:100%;
    z-index:-1;
}

/* Central register card – Electric Blue style */
.register-container {
    position: relative;
    background: rgba(0,0,40,0.85);
    backdrop-filter: blur(20px);
    padding: 45px 60px;
    border-radius: 20px;
    width: 400px;
    text-align: center;
    border: 2px solid #00f0ff;
    box-shadow: 0 20px 40px rgba(0,0,80,0.8);
    transition: transform 0.4s ease;
}
.register-container:hover {
    transform: scale(1.03);
}

/* Heading */
h2 {
    font-size: 28px;
    margin-bottom: 25px;
    color: #00f0ff;
    text-shadow: 0 0 15px #00f0ff, 0 0 25px #00aaff, 0 0 35px #00ffff;
    font-weight: 700;
}

/* Input fields */
input[type="email"], input[type="text"], input[type="password"] {
    width: 92%;
    padding: 14px;
    margin: 12px 0;
    border-radius: 12px;
    border: none;
    outline: none;
    font-size: 16px;
    background: rgba(0,0,60,0.5);
    color: #00f0ff;
    box-shadow: inset 0 3px 6px rgba(0,255,255,0.4);
    transition: 0.3s;
}

input::placeholder {
    color: rgba(0,240,255,0.6);
}

input:focus {
    background: rgba(0,0,60,0.7);
    box-shadow: 0 0 15px #00f0ff, 0 0 25px #00aaff;
}

/* Button */
button {
    width: 95%;
    padding: 16px;
    margin-top: 20px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(90deg,#00f0ff,#004cff);
    color: #fff;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.4s;
    box-shadow: 0 8px 20px rgba(0,255,255,0.5);
}

button:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 12px 30px rgba(0,255,255,0.8);
}

/* Error messages */
.error-message { 
    margin-bottom: 15px; 
    font-weight:bold; 
    color:#ff4d4d; 
    text-shadow: 0 0 5px #ff4d4d;
}

/* Links */
a { color: #00f0ff; text-decoration:none; font-weight:500; }
a:hover { color: #66ffff; text-decoration:underline; }
</style>
</head>
<body>

<canvas id="network"></canvas>

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

<script>
// Keep original animated network background
const canvas = document.getElementById('network');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let nodes = [];
const nodeCount = 100;

class Node {
    constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.vx = (Math.random() - 0.5) * 0.4;
        this.vy = (Math.random() - 0.5) * 0.4;
        this.radius = 1 + Math.random() * 2;
    }
    update() {
        this.x += this.vx;
        this.y += this.vy;
        if(this.x < 0 || this.x > canvas.width) this.vx *= -1;
        if(this.y < 0 || this.y > canvas.height) this.vy *= -1;
    }
    draw() {
        ctx.beginPath();
        ctx.arc(this.x,this.y,this.radius,0,Math.PI*2);
        ctx.fillStyle = '#00bfff';
        ctx.fill();
    }
}

for(let i=0;i<nodeCount;i++) nodes.push(new Node());

function connectNodes() {
    for(let i=0;i<nodes.length;i++){
        for(let j=i+1;j<nodes.length;j++){
            const dx = nodes[i].x - nodes[j].x;
            const dy = nodes[i].y - nodes[j].y;
            const distance = Math.sqrt(dx*dx + dy*dy);
            if(distance < 120){
                ctx.beginPath();
                ctx.strokeStyle = `rgba(0,191,255,${1 - distance/120})`;
                ctx.lineWidth = 1;
                ctx.moveTo(nodes[i].x,nodes[i].y);
                ctx.lineTo(nodes[j].x,nodes[j].y);
                ctx.stroke();
            }
        }
    }
}

function animate() {
    ctx.clearRect(0,0,canvas.width,canvas.height);
    nodes.forEach(node => { node.update(); node.draw(); });
    connectNodes();
    requestAnimationFrame(animate);
}

animate();
window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});
</script>

</body>
</html>