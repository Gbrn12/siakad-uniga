<?php
session_start();
include('koneksi.php');

// Verifikasi apakah pengguna telah masuk atau belum, jika tidak, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Verifikasi apakah pengguna telah mengirimkan permintaan pengaturan ulang kata sandi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data yang dikirim oleh pengguna
    $inputUsername = $_POST['username']; // Menggunakan input nama pengguna dari formulir
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validasi kata sandi baru
    if ($newPassword !== $confirmPassword) {
        $errorMessage = "Kata sandi baru dan konfirmasi kata sandi tidak cocok.";
    } else {
        // Query SQL untuk memperbarui kata sandi dalam database
        $query = "UPDATE login SET password = '$newPassword' WHERE username = '$inputUsername'";

        // Menjalankan query
        $result = mysqli_query($conn, $query);

        // Periksa apakah query berhasil dieksekusi
        if ($result) {
            $successMessage = "Kata sandi berhasil diubah.";
        } else {
            $errorMessage = "Terjadi kesalahan dalam mengubah kata sandi.";
        }
    }
}
?>

<!-- Kode HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="login&signin.css"> <!-- Ganti dengan file CSS Anda -->
</head>
<body>
    <div class="container">
        <?php
        // Tampilkan pesan kesalahan jika ada
        if (isset($errorMessage)) {
            echo '<div class="alert error">' . $errorMessage . '</div>';
        }
        // Tampilkan pesan sukses jika ada
        if (isset($successMessage)) {
            echo '<div class="alert success">' . $successMessage . '</div>';
        }
        ?>
        <form method="post">
        <h2>Change Password</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <input type="submit" value="Change Password">
            <a href="login.php">Login now</a>

        </form>
    </div>
</body>
</html>
