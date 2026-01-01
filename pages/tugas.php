<?php
include "../config/koneksi.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ... (session dan koneksi di atasnya jangan dihapus)

$user_id = $_SESSION['user_id'];
$search = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'deadline_asc';

// 1. Ambil Parameter (Pastikan nama 'status_filter' sama dengan di name input radio)
$filter_status = isset($_GET['status_filter']) ? trim($_GET['status_filter']) : 'semua';

// 2. Mulai Query Dasar
$query = "SELECT * FROM tugas WHERE user_id = '$user_id'";

// 3. Tambahkan Filter Status (Langsung cek isi variabelnya)
if (strtolower($filter_status) == 'pending') {
    $query .= " AND status = 'Pending'";
} elseif (strtolower($filter_status) == 'selesai') {
    $query .= " AND status = 'Selesai'";
}

// 4. Tambahkan Filter Pencarian (Jika ada)
if (!empty($search)) {
    $query .= " AND (judul LIKE '%$search%' OR kategori LIKE '%$search%')";
}

// 5. Akhiri dengan Order By (WAJIB PALING AKHIR)
if ($sort == 'terbaru') {
    $query .= " ORDER BY id DESC"; // Ini yang bikin tugas baru di kiri atas
} else {
    $query .= " ORDER BY deadline ASC"; // Default deadline terdekat
}


$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Saya - SKS</title>
    <link rel="stylesheet" href="../assets/css/tugas.css">
    <link rel="icon" href="../assets/image/SKS.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header class="header">
        <div class="logo">
            <img src="../assets/image/SKS.png" alt="logo-sks" class="logo-img">
            SKS
        </div>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Beranda</a>
                </li>
                <li>
                    <a href="#">Tugas Saya</a>
                </li>

            </ul>
        </nav>

        <div class="user-actions">
            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>


            <div class="profile-dropdown">
                <button class="profile-btn"><i class="fa-solid fa-circle-user"></i></button>
                <div class="dropdown-content">
                    <a href="login.php" class="login-link">Login</a>
                    <a href="signup.php">Daftar</a>
                    <a href="../auth/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <main class="tugas-container">
        <aside class="sidebar-glass">
            <form action="tugas.php" method="get">
                <div class="filter-group">
                    <h3><i class="fas fa-filter"></i> Filter</h3>

                    <div class="control-box">
                        <label>Urutkan Berdasarkan</label>
                        <select name="sort" class="input-glass" onchange="this.form.submit()">
                            <option value="terbaru" <?php echo $sort == 'terbaru' ? 'selected' : ''; ?>>Terbaru</option>
                            <option value="deadline_asc" <?php echo $sort == 'deadline_asc' ? 'selected' : ''; ?>>Deadline
                                Terdekat</option>
                        </select>
                    </div>
                    <input type="hidden" name="q" value="<?php echo htmlspecialchars($search); ?>">

                    <div class="control-box">
                        <label>Status Tugas</label>
                        <div class="checkbox-group">
                            <label class="check-item">
                                <input type="radio" name="status_filter" value="semua" <?php echo $filter_status == 'semua' ? 'checked' : ''; ?> onchange="this.form.submit()" /> Semua
                            </label>
                            <label class="check-item">
                                <input type="radio" name="status_filter" value="Pending" <?php echo $filter_status == 'Pending' ? 'checked' : ''; ?> onchange="this.form.submit()" />
                                Belum Selesai
                            </label>
                            <label class="check-item">
                                <input type="radio" name="status_filter" value="Selesai" <?php echo $filter_status == 'Selesai' ? 'checked' : ''; ?> onchange="this.form.submit()" />
                                Selesai
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </aside>

        <section class="content-glass">
            <div class="content-header">
                <div class="title-section">
                    <h2>Manajemen Tugas</h2>
                    <p>Kelola semua tugas kuliahmu di sini</p>
                </div>
                <button class="btn-add" onclick="openAddModal()">
                    <i class="fas fa-plus"></i> Tugas Baru
                </button>
            </div>

            <form action="tugas.php" method="GET" class="searchForm">
                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" id="mainSearchInput" value="<?php echo htmlspecialchars($search); ?>"
                        class="search-input" placeholder="Cari berdasarkan judul atau mata kuliah..." required />
                    <input type="hidden" name="status_filter" value="<?php echo $filter_status; ?>">
                    <input type="hidden" name="sort" value="<?php echo $sort; ?>">

                </div>
            </form>

            <div class="task-grid">
                <?php

                // Loop untuk menampilkan card tugas
                while ($row = mysqli_fetch_assoc($result)) {
                    $status = $row['status'];
                    $deadline = strtotime($row['deadline']);
                    $sekarang = time();
                    $selisih = $deadline - $sekarang;
                    $sisa_hari = floor($selisih / (60 * 60 * 24));

                    if ($status == 'Selesai') {
                        $status_class = "clear";
                    } elseif ($sisa_hari <= 1) {
                        $status_class = "urgent";
                    } else {
                        $status_class = "pending";
                    }
                    ?>
                    <div class="task-card b-<?php echo $status_class; ?> ">
                        <div class="card-header">
                            <span class="category"><?php echo $row['kategori']; ?></span>
                            <span class="priority-dot d-<?php echo $status_class; ?>"></span>
                        </div>

                        <h3 class="task-title"><?php echo htmlspecialchars($row['judul']); ?></h3>
                        <p class="task-desc"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                        <div class="card-footer">
                            <div class="deadline">
                                <i class="far fa-clock"></i>
                                <?php
                                if ($sisa_hari < 0) {
                                    $text_hari = "Terlambat";
                                } elseif ($sisa_hari == 0) {
                                    $text_hari = "Hari ini";
                                } else {
                                    $text_hari = $sisa_hari . " Hari lagi";
                                }
                                ?>
                                <span><?php echo $text_hari; ?></span>
                            </div>
                            <div class="sambung">
                                <button class="btn-primary"
                                    onclick="openDeleteModal(<?php echo $row['id']; ?>, '<?php echo addslashes($row['judul']); ?>')">
                                    <i class="fas fa-trash-can"></i> Hapus
                                </button>

                                <?php if ($row['status'] !== 'Selesai'): ?>
                                    <a href="../auth/proses_tugas.php?action=update_status&id=<?php echo $row['id']; ?>"
                                        class="btn-primary">
                                        <button><i class="fas fa-check"></i> Selesai</button>
                                    </a>
                                <?php else: ?>
                                    <button class="btn-primary" style="background: #95a5a6;" disabled>
                                        <i class="fas fa-check-double"></i> Beres
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>




    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Tentang Kami</h4>
                <p>Platform yang membantu mendata tugas anda.</p>
            </div>
            <div class="footer-section">
                <h4>Kontak</h4>
                <p>Email: sks@gmail.com</p>
                <p>Telepon: 085123456789</p>
            </div>
            <div class="footer-section">
                <h4>Social Media</h4>
                <div class="social-icons">
                    <a href="https://www.instagram.com/iamsunraku/">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=100073343155289">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="whatsapp.com">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 Sistem Kebut Semalam. All rights reserved.</p>
        </div>
    </footer>

    <!-- ADD MODAL -->
    <div id="addModal" class="modal-overlay">
        <div class="modal-content-glass">
            <h3>Tambah Tugas Baru</h3>
            <form id="formTambahTugas" action="../auth/proses_tugas.php" method="POST">
                <div class="input-group">
                    <label>Kategori <span style="color:red">*</span></label>
                    <input type="text" name="kategori" id="kategoriInput" placeholder="Masukkan Kategori tugas..."
                        required>
                    <small id="errorKategori" style="color: #ff4d4d; display: none;">Waduh, kategori jangan dikosongin
                        bro!</small>
                </div>

                <div class="input-group">
                    <label>Judul Tugas <span style="color:red">*</span></label>
                    <input type="text" name="judul" id="judulInput" placeholder="Masukkan judul tugas...">
                    <small id="errorJudul" style="color: #ff4d4d; display: none;">Waduh, judul jangan dikosongin
                        bro!</small>
                </div>

                <div class="input-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" placeholder="Detail tugasnya apa nih?"></textarea>
                </div>

                <div class="input-group">
                    <label>Deadline</label>
                    <input type="date" name="deadline" required>
                </div>

                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeAddModal()">Batal</button>
                    <button type="submit" name="tambah_tugas" class="btn-tambah">Simpan Tugas</button>
                </div>
            </form>
        </div>
    </div>

    <!-- DELETE MODAL -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-content-glass">
            <i class="fas fa-exclamation-triangle modal-icon"></i>
            <h3>Hapus Tugas?</h3>
            <p>Apakah kamu yakin ingin menghapus tugas "<span id="taskTitleToDelete"></span>"? Tindakan ini tidak bisa
                dibatalkan.</p>
            <div class="modal-buttons">
                <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
                <a href="#" id="confirmDeleteBtn" class="btn-confirm-delete">Hapus Sekarang</a>
            </div>
        </div>
    </div>
    <script src="../assets/js/tugas.js"></script>
</body>

</html>