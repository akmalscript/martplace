<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MartPlace') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-primary: #F1F3E0;
            --text-primary: #2E2E2E;
            --text-secondary: #6B7280;
            --accent: #6B8F71;
            --card-bg: #FFFFFF;
            --border: rgba(0, 0, 0, 0.08);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        html,
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            scroll-behavior: smooth;
        }

        /* Navbar */
        nav {
            background-color: var(--bg-primary);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: var(--shadow-sm);
        }

        .navbar-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 4rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-auth {
            display: flex;
            gap: 1rem;
        }

        /* Hero Section */
        .hero {
            max-width: 1280px;
            margin: 0 auto;
            padding: 6rem 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
        }

        .hero-content p {
            font-size: 1.15rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 2rem;
            max-width: 90%;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.875rem 2rem;
            border-radius: 12px;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: var(--accent);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            background-color: #5a7961;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background-color: var(--card-bg);
            color: var(--accent);
            border: 1.5px solid var(--accent);
        }

        .btn-secondary:hover {
            background-color: #f8faf4;
            transform: translateY(-2px);
        }

        .hero-image {
            background: linear-gradient(135deg, #f5f7ed 0%, #e8ecdb 100%);
            border-radius: 24px;
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 400px;
            box-shadow: var(--shadow-md);
        }

        .hero-image img {
            width: 100%;
            height: auto;
            border-radius: 16px;
        }

        /* Section Title */
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }

        .section-title p {
            font-size: 1.1rem;
            color: var(--text-secondary);
        }

        /* Card Section */
        .section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent);
        }

        .card-icon {
            width: 48px;
            height: 48px;
            background-color: #f0f4ed;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--accent);
            font-size: 1.5rem;
        }

        .card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }

        .card p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Features Grid */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
            margin-top: 3rem;
        }

        .feature-item {
            padding: 2rem;
            background-color: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border);
            display: flex;
            gap: 1.5rem;
        }

        .feature-number {
            flex-shrink: 0;
            width: 44px;
            height: 44px;
            background-color: var(--accent);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .feature-content h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .feature-content p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--accent) 0%, #5a7961 100%);
            color: white;
            text-align: center;
            padding: 4rem 2rem;
            border-radius: 24px;
            margin: 4rem auto;
            max-width: 1280px;
        }

        .cta-section h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta-section p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        /* Footer */
        footer {
            background-color: var(--text-primary);
            color: white;
            padding: 4rem 2rem 2rem;
            margin-top: 6rem;
        }

        .footer-content {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 2rem;
        }

        .footer-column h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column li {
            margin-bottom: 0.75rem;
        }

        .footer-column a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-column a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero {
                grid-template-columns: 1fr;
                padding: 3rem 1rem;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .nav-links {
                display: none;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="navbar-container">
            <a href="#" class="logo">MartPlace</a>
            <ul class="nav-links">
                <li><a href="#features">Fitur</a></li>
                <li><a href="#about">Tentang</a></li>
                <li><a href="#contact">Kontak</a></li>
            </ul>
            <div class="nav-auth">
                <a href="{{ route('login') }}" class="btn btn-secondary" style="padding: 0.625rem 1.5rem;">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.625rem 1.5rem;">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Belanja Mudah, Harga Terjangkau</h1>
            <p>Temukan ribuan produk pilihan dengan harga terbaik. Belanja aman, pembayaran terjamin, dan pengiriman
                cepat ke seluruh Indonesia.</p>
            <div class="hero-buttons">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Mulai Belanja</a>
                <a href="{{ route('sellers.create') }}" class="btn btn-secondary">Jadi Seller</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="https://via.placeholder.com/400x400/e8ecdb/6b8f71?text=Shopping" alt="Shopping Illustration">
        </div>
    </section>

    <!-- Features Section -->
    <section class="section" id="features">
        <div class="section-title">
            <h2>Mengapa Pilih MartPlace?</h2>
            <p>Kami menyediakan pengalaman belanja online terbaik untuk Anda</p>
        </div>
        <div class="card-grid">
            <div class="card">
                <div class="card-icon">🛡️</div>
                <h3>Aman & Terpercaya</h3>
                <p>Belanja dengan jaminan keamanan transaksi dan perlindungan pembeli yang maksimal.</p>
            </div>
            <div class="card">
                <div class="card-icon">⚡</div>
                <h3>Pengiriman Cepat</h3>
                <p>Produk sampai dengan cepat dan aman ke tangan Anda dengan berbagai pilihan kurir.</p>
            </div>
            <div class="card">
                <div class="card-icon">💰</div>
                <h3>Harga Kompetitif</h3>
                <p>Dapatkan harga terbaik dengan berbagai promo dan diskon menarik setiap hari.</p>
            </div>
            <div class="card">
                <div class="card-icon">📱</div>
                <h3>Mudah Digunakan</h3>
                <p>Interface yang user-friendly membuat belanja online menjadi mudah dan menyenangkan.</p>
            </div>
            <div class="card">
                <div class="card-icon">💬</div>
                <h3>Layanan Pelanggan</h3>
                <p>Tim support kami siap membantu Anda 24/7 untuk menjawab semua pertanyaan Anda.</p>
            </div>
            <div class="card">
                <div class="card-icon">⭐</div>
                <h3>Rating Terpercaya</h3>
                <p>Lihat rating dan ulasan dari pembeli lain untuk membantu Anda membuat keputusan.</p>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="section" id="about">
        <div class="section-title">
            <h2>Cara Menggunakan MartPlace</h2>
            <p>Hanya beberapa langkah mudah untuk memulai belanja</p>
        </div>
        <div class="features">
            <div class="feature-item">
                <div class="feature-number">1</div>
                <div class="feature-content">
                    <h4>Buat Akun</h4>
                    <p>Daftar dengan email Anda dan lengkapi profil untuk mulai berbelanja.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-number">2</div>
                <div class="feature-content">
                    <h4>Cari Produk</h4>
                    <p>Jelajahi ribuan produk dengan kategori yang lengkap dan pencarian yang canggih.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-number">3</div>
                <div class="feature-content">
                    <h4>Tambah Keranjang</h4>
                    <p>Pilih produk favorit Anda dan tambahkan ke keranjang belanja dengan mudah.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-number">4</div>
                <div class="feature-content">
                    <h4>Checkout</h4>
                    <p>Lanjutkan ke checkout, pilih metode pembayaran dan pengiriman favorit Anda.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-number">5</div>
                <div class="feature-content">
                    <h4>Bayar dengan Aman</h4>
                    <p>Gunakan berbagai metode pembayaran yang aman dan terpercaya untuk transaksi Anda.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-number">6</div>
                <div class="feature-content">
                    <h4>Terima Produk</h4>
                    <p>Terima produk di alamat Anda dan nikmati pengalaman belanja yang memuaskan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Siap Mulai Belanja?</h2>
        <p>Bergabunglah dengan jutaan pembeli yang telah mempercayai MartPlace untuk kebutuhan belanja online mereka.
        </p>
        <a href="{{ route('register') }}" class="btn btn-secondary"
            style="background-color: white; color: var(--accent); border: none;">Daftar Sekarang</a>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h4>MartPlace</h4>
                <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: 1rem;">Platform belanja online terpercaya
                    dengan jutaan produk pilihan dan harga terbaik.</p>
            </div>
            <div class="footer-column">
                <h4>Kategori</h4>
                <ul>
                    <li><a href="#">Elektronik</a></li>
                    <li><a href="#">Fashion</a></li>
                    <li><a href="#">Rumah & Dapur</a></li>
                    <li><a href="#">Olahraga</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Bantuan</h4>
                <ul>
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="#">Hubungi Kami</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kebijakan</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Tentang Kami</h4>
                <ul>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Karir</a></li>
                    <li><a href="#">Siapa Kami</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 MartPlace. Semua hak cipta dilindungi. Platform belanja online Indonesia.</p>
        </div>
    </footer>
</body>

</html>