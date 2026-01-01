<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$nama_user = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

$seed = date('Ymd');
$queryMotivasi = "SELECT pesan FROM motivasi ORDER BY RAND($seed) LIMIT 1";
$resultMotivasi = mysqli_query($conn, $queryMotivasi);
$dataMotivasi = mysqli_fetch_assoc($resultMotivasi);

$pesan_semangat = ($dataMotivasi) ? $dataMotivasi['pesan'] : "Semangat ngerjain tugasnya bro!";


$queryPending = "SELECT COUNT(*) as total FROM tugas WHERE status = 'Pending'";
$resultPending = mysqli_query($conn, $queryPending);
$dataPending = mysqli_fetch_assoc($resultPending);
$jumlahPending = $dataPending['total'];

$querySelesai = "SELECT COUNT(*) as total FROM tugas WHERE status = 'Selesai'";
$resultSelesai = mysqli_query($conn, $querySelesai);
$dataSelesai = mysqli_fetch_assoc($resultSelesai);
$jumlahSelesai = $dataSelesai['total'];

$queryTotal = "SELECT COUNT(*) as total FROM tugas";
$resultTotal = mysqli_query($conn, $queryTotal);
$jumlahTotal = mysqli_fetch_assoc($resultTotal)['total'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - SKS</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/image/SKS.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
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
                    <a href="#">Beranda</a>
                </li>
                <li>
                    <a href="tugas.php">Tugas Saya</a>
                </li>

            </ul>
        </nav>

        <div class="user-actions">
            <form action="tugas.php" method="GET" class="search-container">
                <input type="text" name="q" class="search-input" placeholder="Cari Tugas..." required>
                <button type="submit" class="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <button class="hamburger" id="hamburger">
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

    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Halo, <?php echo htmlspecialchars($nama_user); ?>! 👋</h1>
                <p><?php echo htmlspecialchars($pesan_semangat); ?></p>
                <div class="hero-buttons">
                    <!-- <button class="btn-primary" onclick="openAddModal()">
                        <i class="fas fa-plus"></i> Tambah Tugas
                    </button> -->
                    <a href="tugas.php"><button class="btn-secondary">Lihat Tugas</button></a>
                </div>
            </div>
            <div class="hero-stats">
                <div class="stat-card">
                    <span class="stat-value"><?php echo $jumlahTotal; ?></span>
                    <span class="stat-label">Total</span>
                </div>
                <div class="stat-card">
                    <span class="stat-value"><?php echo $jumlahPending; ?></span>
                    <span class="stat-label">Pending</span>
                </div>
                <div class="stat-card">
                    <span class="stat-value"><?php echo $jumlahSelesai; ?></span>
                    <span class="stat-label">Selesai</span>
                </div>
            </div>
        </div>
    </section>

    <div class="task-grid">
        <?php
        $query = "SELECT * FROM tugas WHERE user_id = '$user_id' ORDER BY deadline ASC LIMIT 3";
        $result = mysqli_query($conn, $query);

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
    <script src="../assets/js/main.js"></script>
    <!-- <script src="../assets/js/tugas.js"></script> -->

</body>

</html>