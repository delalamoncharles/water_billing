<?php
session_start();

// Redirect to login if not logged in
if(!isset($_SESSION['username'])){
    header("Location: login.php?error=Please+login+first");
    exit();
}

$username = htmlspecialchars($_SESSION['username']); // Prevent XSS
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Water Billing System</title>
<style>
/* Full-screen dim-blue background */
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Poppins', sans-serif;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #0b0d1a;
}

/* Canvas for animated network lines */
#network {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
}

/* Centered dashboard card */
.dashboard-container {
    position: relative;
    background: rgba(0,0,40,0.85);
    backdrop-filter: blur(20px);
    padding: 50px 60px;
    border-radius: 20px;
    text-align: center;
    color: #cce0ff;
    border: 1px solid rgba(0,255,255,0.2);
    box-shadow: 0 20px 40px rgba(0,0,80,0.8);
    animation: fadeIn 0.8s ease-in-out;
}

@keyframes fadeIn {
    from {opacity:0; transform: translateY(-20px);}
    to {opacity:1; transform: translateY(0);}
}

/* Heading */
h2 {
    font-size: 28px;
    margin-bottom: 30px;
    color: #00f0ff;
    text-shadow: 0 0 15px #00f0ff, 0 0 25px #00aaff;
}

/* Buttons */
a.button {
    display: inline-block;
    margin: 10px 10px;
    padding: 12px 30px;
    border-radius: 12px;
    background: linear-gradient(90deg,#00f0ff,#004cff);
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
    box-shadow: 0 8px 20px rgba(0,255,255,0.5);
}

a.button:hover {
    background: linear-gradient(90deg,#004cff,#00f0ff);
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 12px 30px rgba(0,255,255,0.8);
}
</style>
</head>
<body>

<canvas id="network"></canvas>

<div class="dashboard-container">
    <h2>Welcome, <?php echo $username; ?>!</h2>
    
    <!-- Button to go to main index page -->
    <a href="index.php" class="button">See bills</a>

    <!-- Logout button -->
    <a href="logout.php" class="button">Logout</a>
</div>

<script>
// Animated dim-blue network background
const canvas = document.getElementById('network');  
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let nodes = [];
const nodeCount = 80;

class Node {
    constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.vx = (Math.random() - 0.5) * 0.3;
        this.vy = (Math.random() - 0.5) * 0.3;
        this.radius = 2 + Math.random() * 2;
    }
    update() {
        this.x += this.vx;
        this.y += this.vy;
        if(this.x < 0 || this.x > canvas.width) this.vx *= -1;
        if(this.y < 0 || this.y > canvas.height) this.vy *= -1;
    }
    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = '#66a3ff';
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
            if(distance < 150){
                ctx.beginPath();
                ctx.strokeStyle = `rgba(102,163,255,${1 - distance/150})`;
                ctx.lineWidth = 1;
                ctx.moveTo(nodes[i].x, nodes[i].y);
                ctx.lineTo(nodes[j].x, nodes[j].y);
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

window.addEventListener('resize', ()=>{
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});
</script>

</body>
</html>