
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - SKS</title>
    <link rel="stylesheet" href="../assets/css/signup.css">
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
                    <a href="tugas.php">Tugas Saya</a>
                </li>
                
            </ul>
        </nav>

        <div class="user-actions">
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

    <div class="auth-container">
        <div class="auth-card-glass">
            <div class="auth-header">
                <img src="../assets/image/sks.png" alt="Logo" class="auth-logo">
                <h2>Selamat Datang</h2>
                <p>Selesaikan tugasmu tanpa drama SKS.</p>
            </div>

            <form action="../auth/proses_auth.php" method="POST" class="auth-form">
                <div class="input-group-glass">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Masukkan username..." required>
                    </div>
                </div>

                <div class="input-group-glass">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Masukkan email..." required>
                    </div>
                </div>

                <div class="input-group-glass">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="********" required>
                    </div>
                </div>

                <div class="input-group-glass">
                    <label>Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="confirm_password" placeholder="********" required>
                    </div>
                </div>

                <button type="submit" name="signup" class="btn-auth">Daftar Sekarang</button>
            </form>

            <div class="auth-footer">
                <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
            </div>
        </div>
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
</body>

</html>