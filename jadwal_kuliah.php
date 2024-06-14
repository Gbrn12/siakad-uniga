<?php
include('koneksi.php');

// Create
function tambahJadwalKuliah($mata_kuliah_id, $hari, $jam, $ruangan) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO jadwal_kuliah (mata_kuliah_id, hari, jam, ruangan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $mata_kuliah_id, $hari, $jam, $ruangan);
    $stmt->execute();
    $stmt->close();
}


// Read
$result = $conn->query("SELECT * FROM jadwal_kuliah");
$jadwal_kuliahs = $result->fetch_all(MYSQLI_ASSOC);

function ambilJadwalKuliah($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM jadwal_kuliah WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $jadwal_kuliah = $result->fetch_assoc();
    $stmt->close();
    return $jadwal_kuliah;
}

function ambilJadwalKuliahByMataKuliah($mata_kuliah_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM jadwal_kuliah WHERE mata_kuliah_id = ?");
    $stmt->bind_param("i", $mata_kuliah_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Update
function updateJadwalKuliah($id, $mata_kuliah_id, $hari, $jam, $ruangan) {
    global $conn;
    $stmt = $conn->prepare("UPDATE jadwal_kuliah SET mata_kuliah_id = ?, hari = ?, jam = ?, ruangan = ? WHERE id = ?");
    $stmt->bind_param("isssi", $mata_kuliah_id, $hari, $jam, $ruangan, $id);
    $stmt->execute();
    $stmt->close();
}

// Delete
function hapusJadwalKuliah($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM jadwal_kuliah WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Jika formulir untuk menambah jadwal dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_jadwal'])) {
    $mata_kuliah_id = $_POST['mata_kuliah_id'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $ruangan = $_POST['ruangan'];

    // Panggil fungsi tambahJadwalKuliah
    tambahJadwalKuliah($mata_kuliah_id, $hari, $jam, $ruangan);

    // Redirect untuk menghindari pengiriman formulir ulang
    header("Location: jadwal_kuliah.php");
    exit();
}

// Jika formulir untuk menghapus jadwal dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_jadwal'])) {
    $jadwal_id = $_POST['jadwal_id'];

    // Panggil fungsi hapusJadwalKuliah untuk menghapus jadwal kuliah
    hapusJadwalKuliah($jadwal_id);

    // Redirect untuk menghindari pengiriman formulir ulang
    header("Location: jadwal_kuliah.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Kuliah</title>
    <link rel="stylesheet" href="semua.css?v=<?php echo time();?>">
</head>
<body>
<div class="container">
    <h1>Jadwal Kuliah</h1>
    
    <table>
        <thead>
            <tr>
                <th>Mata Kuliah</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Ruangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jadwal_kuliahs as $jadwal): ?>
                <tr>
                    <td><?php echo htmlspecialchars($jadwal['mata_kuliah_id']); ?></td>
                    <td><?php echo htmlspecialchars($jadwal['hari']); ?></td>
                    <td><?php echo htmlspecialchars($jadwal['jam']); ?></td>
                    <td><?php echo htmlspecialchars($jadwal['ruangan']); ?></td>
                    <td>
                        <form method="POST" action="jadwal_kuliah.php">
                            <input type="hidden" name="jadwal_id" value="<?php echo $jadwal['id']; ?>">
                            <input type="submit" name="hapus_jadwal" value="Hapus">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Tambah Jadwal Kuliah</h2>
    <form method="POST" action="jadwal_kuliah.php">
        <label for="mata_kuliah_id">Mata Kuliah:</label>
        <select id="mata_kuliah_id" name="mata_kuliah_id" required>
            <?php
            // Fetch all mata kuliah from the database
            $result_mata_kuliah = $conn->query("SELECT id, nama FROM mata_kuliah");
            while ($row_mata_kuliah = $result_mata_kuliah->fetch_assoc()) {
                echo '<option value="' . $row_mata_kuliah['id'] . '">' . htmlspecialchars($row_mata_kuliah['nama']) . '</option>';
            }
            ?>
        </select>
        <label for="hari">Hari:</label>
        <input type="text" id="hari" name="hari" required>
        <label for="jam">Jam:</label>
        <input type="text" id="jam" name="jam" required>
        <label for="ruangan">Ruangan:</label>
        <input type="text" id="ruangan" name="ruangan" required>
        <input type="submit" name="tambah_jadwal" value="Tambah">
    </form>
</div>
</body>
</html>
