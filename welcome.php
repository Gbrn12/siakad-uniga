<?php
// Mulai session
session_start();

// Cek apakah pengguna telah login dan memiliki peran admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Jika tidak, redirect ke halaman login
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SIAKAD</title>
    <link rel="stylesheet" href="welcome.css?v=<?php echo time();?>">
</head>
<body>
<div class="sidebar">
        <h3>Dashboard</h3>
        <ul>
            <li><a href="viewcourse.php">View Courses</a></li>
            <li><a href="#">View Grades</a></li>
            <li><a href="#">Update Profile</a></li>
        </ul>
    </div>
<div class="container">
  
        <!-- Div untuk alert -->
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            Welcome To SIAKAD!
        </div>

        <h1>Welcome To SIAKAD, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>!</h1>
        <p>You have successfully logged in as <?php echo isset($_SESSION['role']) ? $_SESSION['role'] : ''; ?>.</p>
    </div>
    
    <form action="login.php" method="post">
            <input type="submit" value="Logout" class="logout-btn">
    </form>
    <script src="welcome.js"></script>
</body>
</html>
