<?php
include('koneksi.php');

// Define necessary functions here since we are not including dosen_functions.php

// Read function
function ambilDosen($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM dosen WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dosen = $result->fetch_assoc();
    $stmt->close();
    return $dosen;
}

// Update function
function updateDosen($id, $nama, $email) {
    global $conn;
    $stmt = $conn->prepare("UPDATE dosen SET nama = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nama, $email, $id);
    $stmt->execute();
    $stmt->close();
}

// Ensure the id parameter is present
if (!isset($_GET['id'])) {
    die('ID dosen tidak ditemukan.');
}

$id = intval($_GET['id']);
$dosen = ambilDosen($id);

if (!$dosen) {
    die('Dosen tidak ditemukan.');
}

// Handle dosen update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_dosen'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    updateDosen($id, $nama, $email);
    header('Location: dosen.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Dosen</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Edit Dosen</h1>
    <form method="POST" action="edit_dosen.php?id=<?php echo $id; ?>">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($dosen['nama']); ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($dosen['email']); ?>" required><br>
        <input type="submit" name="update_dosen" value="Update Dosen">
    </form>
</div>
</body>
</html>
