<?php
include('koneksi.php');

// Create
function tambahDosen($nama, $email) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO dosen (nama, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama, $email);
    $stmt->execute();
    $stmt->close();
}

// Read
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

function ambilSemuaDosen() {
    global $conn;
    $result = $conn->query("SELECT * FROM dosen");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Update
function updateDosen($id, $nama, $email) {
    global $conn;
    $stmt = $conn->prepare("UPDATE dosen SET nama = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nama, $email, $id);
    $stmt->execute();
    $stmt->close();
}

// Delete
function hapusDosen($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM dosen WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah_dosen'])) {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        tambahDosen($nama, $email);
    }
}

// Handle delete request
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    hapusDosen($id);
}

// Fetch all dosen
$dosenList = ambilSemuaDosen();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Dosen</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
        form { margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Data Dosen</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dosenList as $dosen): ?>
                <tr>
                    <td><?php echo htmlspecialchars($dosen['id']); ?></td>
                    <td><?php echo htmlspecialchars($dosen['nama']); ?></td>
                    <td><?php echo htmlspecialchars($dosen['email']); ?></td>
                    <td>
                        <a href="edit_dosen.php?id=<?php echo $dosen['id']; ?>">Edit</a> |
                        <a href="dosen.php?hapus=<?php echo $dosen['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus dosen ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <h2>Tambah Dosen</h2>
    <form method="POST" action="dosen.php">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <input type="submit" name="tambah_dosen" value="Tambah Dosen">
    </form>
</div>
</body>
</html>
