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

    /* Container */
    .container {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        padding: 40px 40px 80px 40px; /* extra bottom padding for logout button */
        width: 90%;
        max-width: 900px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        color: #fff;
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
        text-shadow: 1px 1px 5px rgba(0,255,255,0.5);
    }

    a.button {
        display: inline-block;
        padding: 10px 20px;
        margin: 10px 5px;
        border-radius: 10px;
        background: linear-gradient(90deg, #00e5ff, #0077cc);
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
        box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }

    a.button:hover {
        background: linear-gradient(90deg, #0077cc, #00e5ff);
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.3);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.2);
    }

    th, td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    th {
        background: rgba(0,255,255,0.2);
        color: #00f0ff;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    tr:hover {
        background: rgba(0,255,255,0.1);
    }

    td a {
        padding: 5px 12px;
        border-radius: 8px;
        background: linear-gradient(90deg, #00e5ff, #0077cc);
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s;
        margin: 0 2px;
    }

    td a:hover {
        background: linear-gradient(90deg, #0077cc, #00e5ff);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    /* Logout button at bottom */
    .logout-btn {
        display: inline-block;
        margin-top: 30px;
        padding: 12px 30px;
        border-radius: 12px;
        background: linear-gradient(90deg, #00e5ff, #0077cc);
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
        box-shadow: 0 5px 12px rgba(0,0,0,0.3);
    }

    .logout-btn:hover {
        background: linear-gradient(90deg, #0077cc, #00e5ff);
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.4);
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