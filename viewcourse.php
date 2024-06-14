<?php
include('koneksi.php');

// Query untuk mengambil semua data mata kuliah dari database
$sql_mata_kuliah = "SELECT * FROM mata_kuliah";
$result_mata_kuliah = $conn->query($sql_mata_kuliah);
$mata_kuliahs = $result_mata_kuliah->fetch_all(MYSQLI_ASSOC);

// Query untuk mengambil semua data jadwal kuliah dari database
$sql_jadwal = "SELECT * FROM jadwal_kuliah";
$result_jadwal = $conn->query($sql_jadwal);
$jadwal_kuliahs = $result_jadwal->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Courses</title>
    <link rel="stylesheet" href="semua.css?v=<?php echo time();?>">
</head>
<body>
<div class="container">
<a href="javascript:history.back()" class="back-button">Back</a>
    <h1>View Courses</h1>

    <h2>Mata Kuliah</h2>
    <?php if ($mata_kuliahs): ?>
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>ID Dosen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mata_kuliahs as $mata_kuliah): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mata_kuliah['kode']); ?></td>
                        <td><?php echo htmlspecialchars($mata_kuliah['nama']); ?></td>
                        <td><?php echo htmlspecialchars($mata_kuliah['deskripsi']); ?></td>
                        <td><?php echo htmlspecialchars($mata_kuliah['dosen_id']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data mata kuliah.</p>
    <?php endif; ?>

    <h2>Jadwal Kuliah</h2>
    <?php if ($jadwal_kuliahs): ?>
        <table>
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Ruangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jadwal_kuliahs as $jadwal): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($jadwal['mata_kuliah_id']); ?></td>
                        <td><?php echo htmlspecialchars($jadwal['hari']); ?></td>
                        <td><?php echo htmlspecialchars($jadwal['jam']); ?></td>
                        <td><?php echo htmlspecialchars($jadwal['ruangan']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data jadwal kuliah.</p>
    <?php endif; ?>

</div>
</body>
</html>
