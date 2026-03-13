<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
include 'db.php';
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Users List - Water Billing System</title>
<style>
    /* Full-screen background stays the same */
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #0b0f1a, #001f3f);
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
    }

    /* Container – Electric Blue futuristic style */
    .container {
        background: rgba(0,0,40,0.85);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 40px 40px 80px 40px;
        width: 90%;
        max-width: 900px;
        box-shadow: 0 20px 40px rgba(0,0,80,0.8);
        text-align: center;
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from {opacity:0; transform: translateY(-20px);}
        to {opacity:1; transform: translateY(0);}
    }

    h2 {
        color: #00f0ff;
        margin-bottom: 20px;
        text-shadow: 0 0 15px #00f0ff, 0 0 25px #00aaff;
    }

    /* Buttons */
    a.button, .logout-btn, td a {
        display: inline-block;
        padding: 10px 20px;
        margin: 5px;
        border-radius: 12px;
        background: linear-gradient(90deg, #00f0ff, #004cff);
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
        box-shadow: 0 8px 20px rgba(0,255,255,0.5);
    }

    a.button:hover, .logout-btn:hover, td a:hover {
        background: linear-gradient(90deg, #004cff, #00f0ff);
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 12px 30px rgba(0,255,255,0.8);
    }

    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: rgba(0,0,60,0.5);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: inset 0 0 15px rgba(0,255,255,0.2);
    }

    th, td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid rgba(0,255,255,0.2);
    }

    th {
        background: rgba(0,240,255,0.2);
        color: #00f0ff;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 0 0 5px #00f0ff;
    }

    tr:hover {
        background: rgba(0,240,255,0.05);
    }

    td a {
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 10px;
        background: linear-gradient(90deg, #00f0ff, #004cff);
        color: #fff;
        text-decoration: none;
        transition: 0.3s;
        margin: 0 2px;
    }

    td a:hover {
        background: linear-gradient(90deg, #004cff, #00f0ff);
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 6px 15px rgba(0,255,255,0.5);
    }

    /* Logout button at bottom */
    .logout-btn {
        margin-top: 30px;
        padding: 12px 30px;
        border-radius: 12px;
        background: linear-gradient(90deg, #00f0ff, #004cff);
        font-weight: bold;
        box-shadow: 0 8px 20px rgba(0,255,255,0.5);
        transition: 0.3s;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Users List</h2>
    <a href="create.php" class="button">Add New User</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Username</th>
            <th>Course</th>
            <th>Actions</th>
        </tr>

        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo isset($row['course']) ? $row['course'] : '-'; ?></td>
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

    <!-- Logout button at bottom -->
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>