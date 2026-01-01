<?php
session_start();
include "../config/koneksi.php";

// --- LOGIKA SIGNUP ---
if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']); // Tambahan Email
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; // Ambil konfirmasi password

    // VALIDASI 1: Minimal Password 8 Karakter
    if (strlen($password) < 8) {
        header("Location: ../pages/signup.php?status=password_short");
        exit();
    }

    // VALIDASI 2: Cek apakah Password dan Konfirmasi Password sama
    if ($password !== $confirm_password) {
        header("Location: ../pages/signup.php?status=password_missmatch");
        exit();
    }

    // Hash password biar aman
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Update Query: Tambahkan kolom email (pastikan kolom email ada di DB)
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password_hashed')";

    if (mysqli_query($conn, $query)) {
        header("Location: ../pages/login.php?status=registered");
    } else {
        header("Location: ../pages/signup.php?status=error");
    }
    exit();
}

// --- LOGIKA LOGIN ---
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password yang diinput dengan yang ada di DB
        if (password_verify($password, $user['password'])) {
            // Set session untuk tanda user sudah masuk

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: ../pages/index.php");
            exit();
        }
    }
    // Jika gagal login
    header("Location: ../pages/login.php?status=wrong_auth");
    exit();
}