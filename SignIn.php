<?php
// Proses Sign Up
include('koneksi.php');
if (isset($_POST['signup'])) {
    // Mendapatkan nilai username, password, dan role dari form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']); // Role harus ditentukan dalam form signup

    // Validasi input
    if (!empty($username) && !empty($password) && !empty($role)) {
        if ($role === 'admin') {
            // Hash the password for admin


            // Membuat query SQL untuk memasukkan data pengguna baru ke dalam database menggunakan prepared statements
            $stmt = $conn->prepare("INSERT INTO `login` (`username`, `password`, `role`) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $role);
        } else {
            // Untuk user biasa, simpan password tanpa hashing
            $stmt = $conn->prepare("INSERT INTO `login` (`username`, `password`, `role`) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $password, $role);
        }

        // Menjalankan query dan menampilkan pesan sukses atau kesalahan
        if ($stmt->execute()) {
            echo "Sign up successful";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}

// Menutup koneksi ke database
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="login&signin.css?v=<?php echo time();?>">
</head>
<body>
    <form method="post" id="signup-form">
        <h2>Sign Up SIAKAD</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <div class="custom-select">
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <input type="submit" name="signup" value="Sign Up">
        <a href="login.php">Login now</a>
    </form>
    <script src="java.js?v=<?php echo time();?>"></script>
</body>
</html>
