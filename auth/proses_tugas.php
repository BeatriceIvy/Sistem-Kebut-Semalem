<?php
session_start();
include "../config/koneksi.php"; // Pastikan path benar sesuai struktur folder SKS

// 1. LOGIKA TAMBAH TUGAS (Create)
if (isset($_POST['tambah_tugas'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $user_id = $_SESSION['user_id'];
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $deadline = $_POST['deadline'];
    $status = 'Pending'; // Status default sesuai instruksi 

    $query = "INSERT INTO tugas (user_id, kategori, judul, deskripsi, deadline, status) VALUES ('$user_id', '$kategori', '$judul', '$deskripsi', '$deadline', '$status')";

    if (mysqli_query($conn, $query)) {
        header("Location: ../pages/tugas.php?status=success_add");
    } else {
        header("Location: ../pages/tugas.php?status=error");
    }
}

// 2. LOGIKA HAPUS DATA (Delete) 
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $query = "DELETE FROM tugas WHERE id = '$id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $query)) {
        header("Location: ../pages/tugas.php?status=success_delete");
    } else {
        header("Location: ../pages/tugas.php?status=error");
    }
}

// 3. LOGIKA UPDATE STATUS (Update) 
if (isset($_GET['action']) && $_GET['action'] == 'update_status') {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Mengubah status menjadi 'Selesai' dengan satu klik sesuai instruksi 
    $query = "UPDATE tugas SET status = 'Selesai' WHERE id = '$id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $query)) {
        header("Location: ../pages/tugas.php?status=success_update");
    } else {
        header("Location: ../pages/tugas.php?status=error");
    }
}
?>