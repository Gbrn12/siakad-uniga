<?php
include('koneksi.php');

// Create
function tambahSiswa($nama, $email) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO siswa (nama, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama, $email);
    $stmt->execute();
    $stmt->close();
}

// Read
function ambilSiswa($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM siswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $siswa = $result->fetch_assoc();
    $stmt->close();
    return $siswa;
}

function ambilSemuaSiswa() {
    global $conn;
    $result = $conn->query("SELECT * FROM siswa");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Update
function updateSiswa($id, $nama, $email) {
    global $conn;
    $stmt = $conn->prepare("UPDATE siswa SET nama = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nama, $email, $id);
    $stmt->execute();
    $stmt->close();
}

// Delete
function hapusSiswa($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM siswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>
