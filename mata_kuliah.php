<?php
include('koneksi.php');

// Create function
function tambahMataKuliah($kode, $nama, $deskripsi, $dosen_id) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO mata_kuliah (kode, nama, deskripsi, dosen_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $kode, $nama, $deskripsi, $dosen_id);
    $stmt->execute();
    $stmt->close();
    // Redirect to prevent duplicate submissions
    header("Location: $_SERVER[PHP_SELF]");
    exit();
}

// Read functions
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

function ambilSemuaMataKuliah() {
    global $conn;
    $result = $conn->query("SELECT * FROM mata_kuliah");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Update function
function updateMataKuliah($id, $kode, $nama, $deskripsi, $dosen_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE mata_kuliah SET kode = ?, nama = ?, deskripsi = ?, dosen_id = ? WHERE id = ?");
    $stmt->bind_param("sssii", $kode, $nama, $deskripsi, $dosen_id, $id);
    $stmt->execute();
    $stmt->close();
    // Redirect to prevent duplicate submissions
    header("Location: $_SERVER[PHP_SELF]");
    exit();
}

// Delete function
function hapusMataKuliah($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM mata_kuliah WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    // Redirect to prevent duplicate submissions
    header("Location: $_SERVER[PHP_SELF]");
    exit();
}

// Handle form submission for adding a new mata kuliah
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah_mata_kuliah'])) {
        $kode = $_POST['kode'];
        $nama = $_POST['nama'];
        $deskripsi = $_POST['deskripsi'];
        $dosen_id = $_POST['dosen_id'];
        tambahMataKuliah($kode, $nama, $deskripsi, $dosen_id);
    } elseif (isset($_POST['update_mata_kuliah'])) {
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $nama = $_POST['nama'];
        $deskripsi = $_POST['deskripsi'];
        $dosen_id = $_POST['dosen_id'];
        updateMataKuliah($id, $kode, $nama, $deskripsi, $dosen_id);
    }
}

// Handle delete request
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    hapusMataKuliah($id);
}

// Fetch all mata kuliah
$mataKuliahList = ambilSemuaMataKuliah();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Mata Kuliah</title>
    <link rel="stylesheet" href="semua.css?v=<?php echo time();?>">
</head>
<body>
<div class="container">
    <h1>Data Mata Kuliah</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>ID Dosen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mataKuliahList as $mata_kuliah): ?>
                <tr>
                    <td><?php echo htmlspecialchars($mata_kuliah['id']); ?></td>
                    <td><?php echo htmlspecialchars($mata_kuliah['kode']); ?></td>
                    <td><?php echo htmlspecialchars($mata_kuliah['nama']); ?></td>
                    <td><?php echo htmlspecialchars($mata_kuliah['deskripsi']); ?></td>
                    <td><?php echo htmlspecialchars($mata_kuliah['dosen_id']); ?></td>
                    <td>
                        <a href="edit_mata_kuliah.php?id=<?php echo $mata_kuliah['id']; ?>">Edit</a> |
                        <a href="mata_kuliah.php?hapus=<?php echo $mata_kuliah['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <h2>Tambah Mata Kuliah</h2>
    <form method="POST" action="mata_kuliah.php">
        <label for="kode">Kode:</label>
        <input type="text" id="kode" name="kode" required><br>
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required><br>
        <label for="deskripsi">Deskripsi:</label>
        <textarea id="deskripsi" name="deskripsi" required></textarea><br>
        <label for="dosen_id">ID Dosen:</label>
        <input type="number" id="dosen_id" name="dosen_id" required><br>
        <input type="submit" name="tambah_mata_kuliah" value="Tambah Mata Kuliah">
    </form>
</div>
</body>
</html>
