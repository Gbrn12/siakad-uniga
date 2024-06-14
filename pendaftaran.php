<?php
include('koneksi.php');

// Create
function tambahPendaftaran($siswa_id, $mata_kuliah_id) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO pendaftaran (siswa_id, mata_kuliah_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $siswa_id, $mata_kuliah_id);
    $stmt->execute();
    $stmt->close();
}

// Read
function ambilPendaftaran($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM pendaftaran WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pendaftaran = $result->fetch_assoc();
    $stmt->close();
    return $pendaftaran;
}

function ambilPendaftaranByMataKuliah($mata_kuliah_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT siswa.* FROM siswa
                            JOIN pendaftaran ON siswa.id = pendaftaran.siswa_id
                            WHERE pendaftaran.mata_kuliah_id = ?");
    $stmt->bind_param("i", $mata_kuliah_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Update
function updatePendaftaran($id, $siswa_id, $mata_kuliah_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE pendaftaran SET siswa_id = ?, mata_kuliah_id = ? WHERE id = ?");
    $stmt->bind_param("iii", $siswa_id, $mata_kuliah_id, $id);
    $stmt->execute();
    $stmt->close();
}

// Delete
function hapusPendaftaran($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM pendaftaran WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>
