<?php
// Memulai sesi PHP untuk menyimpan informasi sesi pengguna
session_start();

// Konfigurasi koneksi ke database
include("koneksi.php");

// Proses Login
if (isset($_POST['login'])) {
    // Mendapatkan nilai username dan role dari form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Membuat query SQL untuk memeriksa apakah username ada di database
    $stmt = $conn->prepare("SELECT * FROM `login` WHERE `username` = ? AND `role` = ? AND `password`= ?");
    $stmt->bind_param("sss", $username, $role, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika hasil query mengembalikan satu baris
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Memulai sesi dan menyimpan username dan role
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        // Mengarahkan pengguna ke halaman sambutan (welcome.php)
        header("Location: welcome.php");
        exit();
    } else {
        // Jika username atau role tidak ditemukan, tampilkan pesan kesalahan
        echo "Invalid username,password or role";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up</title>
    <link rel="stylesheet" href="login&signin.css?v=<?php echo time();?>">
</head>
<body>
    
    <!-- Formulir untuk Login -->
    <form method="post">
    <h2>Login SIAKAD</h2>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username">
        <input type="text" id="password" name="password" placeholder="Enter your username">
        
        <label for="role">Role</label>
        <div class="custom-select">
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <input type="submit" name="login" value="Login">
        <a href="forgotpassword.php">Forgot Password?</a>
        <a href="SignIn.php">Register Now</a>
    </form>
    <script src="java.js"></script>
</body>
</html>
