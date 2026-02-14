<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Sistem Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        .hero-section .book-icon {
            font-size: 5rem;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .content-section {
            padding: 40px;
        }
        .feature-box {
            text-align: center;
            padding: 20px;
            margin: 15px 0;
            background: #f8f9fa;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .feature-box .icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .btn-main {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-main:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            color: white;
        }
        .stats-box {
            background: #e9ecef;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 10px 0;
        }
        .stats-box h3 {
            color: #667eea;
            font-size: 2rem;
            margin-bottom: 5px;
        }
        .stats-box p {
            color: #6c757d;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="welcome-card">
                    <!-- Hero Section -->
                    <div class="hero-section">
                        <div class="book-icon">📚</div>
                        <h1>Sistem Perpustakaan</h1>
                        <p class="lead">Kelola koleksi buku dengan mudah dan efisien</p>
                    </div>

                    <!-- Content Section -->
                    <div class="content-section">
                        <div class="text-center mb-5">
                            <h2 class="mb-3">Selamat Datang!</h2>
                            <p class="text-muted">Sistem manajemen perpustakaan modern untuk mengelola koleksi buku Anda</p>
                        </div>

                        <!-- Features -->
                        <div class="row mb-4">
                            <div class="col-md-3 col-6">
                                <div class="feature-box">
                                    <div class="icon">➕</div>
                                    <h5>Tambah Buku</h5>
                                    <p class="text-muted small">Input data buku baru</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="feature-box">
                                    <div class="icon">📖</div>
                                    <h5>Lihat Koleksi</h5>
                                    <p class="text-muted small">Daftar semua buku</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="feature-box">
                                    <div class="icon">✏️</div>
                                    <h5>Edit Data</h5>
                                    <p class="text-muted small">Update informasi buku</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="feature-box">
                                    <div class="icon">🗑️</div>
                                    <h5>Hapus Buku</h5>
                                    <p class="text-muted small">Kelola koleksi buku</p>
                                </div>
                            </div>
                        </div>

                        <!-- Stats (Optional - bisa dihapus jika belum ada data) -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="stats-box">
                                    <h3>✨</h3>
                                    <p><strong>Mudah Digunakan</strong></p>
                                    <small class="text-muted">Interface yang intuitif</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stats-box">
                                    <h3>⚡</h3>
                                    <p><strong>Cepat & Efisien</strong></p>
                                    <small class="text-muted">Proses data dengan cepat</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stats-box">
                                    <h3>🔒</h3>
                                    <p><strong>Aman & Terpercaya</strong></p>
                                    <small class="text-muted">Data terproteksi dengan baik</small>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <div class="text-center mt-5">
                            <a href="{{ route('books.index') }}" class="btn btn-main">
                                Masuk ke Sistem 🚀
                            </a>
                            <p class="text-muted mt-3 mb-0">
                                <small>Mulai kelola koleksi buku Anda sekarang!</small>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <p class="text-white">
                        <small>© 2026 Sistem Perpustakaan | Dibuat dengan ❤️ menggunakan Laravel</small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>