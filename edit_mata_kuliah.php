<?php
include('koneksi.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fungsi untuk mengambil data mata kuliah
function ambilMataKuliah($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM mata_kuliah WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $mata_kuliah = $result->fetch_assoc();
    $stmt->close();
    return $mata_kuliah;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_mata_kuliah'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $dosen_id = isset($_POST['dosen_id']) ? intval($_POST['dosen_id']) : 0;

    $stmt = $conn->prepare("UPDATE mata_kuliah SET kode = ?, nama = ?, deskripsi = ?, dosen_id = ? WHERE id = ?");
    $stmt->bind_param("sssii", $kode, $nama, $deskripsi, $dosen_id, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: mata_kuliah.php");
    exit();
}

$mata_kuliah = ambilMataKuliah($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Mata Kuliah</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], textarea, select { width: 100%; padding: 8px; margin-bottom: 10px; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        input[type="submit"]:hover { background-color: #45a049; }
    </style>
</head>
<body>
<div class="container">
    <h1>Edit Mata Kuliah</h1>
    <form method="POST" action="edit_mata_kuliah.php?id=<?php echo $id; ?>">
        <label for="kode">Kode:</label>
        <input type="text" id="kode" name="kode" value="<?php echo htmlspecialchars($mata_kuliah['kode']); ?>" required>
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($mata_kuliah['nama']); ?>" required>
        <label for="deskripsi">Deskripsi:</label>
        <textarea id="deskripsi" name="deskripsi" required><?php echo htmlspecialchars($mata_kuliah['deskripsi']); ?></textarea>
        <label for="dosen_id">ID Dosen:</label>
        <input type="number" id="dosen_id" name="dosen_id" value="<?php echo $mata_kuliah['dosen_id']; ?>" required>
        <input type="submit" name="update_mata_kuliah" value="Simpan Perubahan">
    </form>
</div>
</body>
</html>
