-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Des 2025 pada 10.17
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_praktikum`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `motivasi`
--

CREATE TABLE `motivasi` (
  `id` int(11) NOT NULL,
  `pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `motivasi`
--

INSERT INTO `motivasi` (`id`, `pesan`) VALUES
(1, 'Jangan Lupa Bernapas Bro, Ingat Tugasmu Masih Banyak'),
(2, 'Tugas bukan halangan, Tapi Jalan Menuju Kesuksesan!'),
(3, 'Istirahat Boleh, Nyerah Jangan!'),
(4, 'Ingat Bro UKT Mahal Loh, Masak Gak Mau Kerjain Tugasnya!'),
(5, 'Tidur Opsional, Selesaiin Tugas Kewajiban'),
(6, 'Push ML Dia Gaskan, Nyelesaiin Tugas Dia Tak Mau!');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` enum('Pending','Selesai') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id`, `user_id`, `kategori`, `judul`, `deskripsi`, `deadline`, `status`) VALUES
(25, 8, 'Tugas 2', 'Tugas 2', 'Ini tugas 2', '2026-02-01', 'Pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(5, 'user1', 'user1@gmail.com', '$2y$10$DYkbmSELetooeBv03QeEYebOvkPjrYynAUCPbclOnx.HLOri3jo4O'),
(6, 'user', 'user@gmail.com', '$2y$10$wTaLTxaBJBAx7IZ1B37t2eglE6j1ORi3fQh.fT/bvaqo.dF8QAQri'),
(7, 'Fatkhur', 'fatkhur@gmail.com', '$2y$10$K3Av.b8e4pyCE65BREtql.XyEBPFaOqNEOY7heEB16E6H7PjRuiD6'),
(8, 'fatkur', 'fatkur@gmail.com', '$2y$10$CKKZZH3yQwzBxkan/k.8muS1p2JxlyYS9jUwvbHbITjiqQoqbwb6i'),
(9, 'wisnu', 'wisnu@gmail.com', '$2y$10$OMsyWVr6stMZFXH52lSFdukro9IeLNEVmBC4HEsucS1z6dgtv9jri');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `motivasi`
--
ALTER TABLE `motivasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `motivasi`
--
ALTER TABLE `motivasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
