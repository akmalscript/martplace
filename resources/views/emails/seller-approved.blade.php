<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Disetujui</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #22d3ee 0%, #86efac 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #ffffff;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            color: white;
        }
        .info-box {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .credentials {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .credentials-item {
            margin: 10px 0;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }
        .credentials-label {
            font-weight: bold;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
        }
        .credentials-value {
            color: #111827;
            font-size: 16px;
            margin-top: 5px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
            text-align: center;
        }
        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-radius: 0 0 10px 10px;
        }
        .warning {
            color: #dc2626;
            font-size: 14px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="success-icon">✓</div>
        <h1 style="margin: 0; font-size: 28px;">Selamat!</h1>
        <p style="margin: 10px 0 0 0; font-size: 16px;">Pendaftaran Seller Anda Disetujui</p>
    </div>

    <div class="content">
        <p>Halo <strong>{{ $seller->pic_name }}</strong>,</p>

        <div class="info-box">
            <p style="margin: 0;">
                <strong>Pendaftaran toko "{{ $seller->store_name }}" Anda telah diverifikasi dan disetujui!</strong>
            </p>
        </div>

        <p>Terima kasih telah mendaftar sebagai seller di MartPlace. Setelah melakukan verifikasi kelengkapan data dan dokumen administrasi, kami dengan senang hati mengumumkan bahwa pendaftaran Anda telah <strong>DITERIMA</strong>.</p>

        <h3 style="color: #16a34a; border-bottom: 2px solid #86efac; padding-bottom: 10px;">Informasi Akun Anda</h3>

        <div class="credentials">
            <div class="credentials-item">
                <div class="credentials-label">Email Login</div>
                <div class="credentials-value">{{ $seller->pic_email }}</div>
            </div>
            <div class="credentials-item">
                <div class="credentials-label">Nama Toko</div>
                <div class="credentials-value">{{ $seller->store_name }}</div>
            </div>
            <div class="credentials-item">
                <div class="credentials-label">Status</div>
                <div class="credentials-value" style="color: #10b981; font-weight: bold;">ACTIVE</div>
            </div>
        </div>

        <p class="warning">
            <strong>⚠️ Penting:</strong> Gunakan password yang Anda buat saat registrasi untuk login. Jika Anda lupa password, gunakan fitur "Lupa Password" di halaman login.
        </p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $loginUrl }}" class="button">Login ke Dashboard Seller</a>
        </div>

        <h3 style="color: #16a34a;">Langkah Selanjutnya:</h3>
        <ol style="padding-left: 20px;">
            <li>Login ke dashboard seller menggunakan email dan password Anda</li>
            <li>Lengkapi profil toko Anda</li>
            <li>Mulai menambahkan produk untuk dijual</li>
            <li>Kelola pesanan dan transaksi Anda</li>
        </ol>

        <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi tim support kami.</p>

        <p style="margin-top: 30px;">
            Salam sukses,<br>
            <strong>Tim MartPlace</strong>
        </p>
    </div>

    <div class="footer">
        <p style="margin: 0;">Email ini dikirim otomatis dari sistem MartPlace</p>
        <p style="margin: 5px 0 0 0;">© 2025 MartPlace. All rights reserved.</p>
    </div>
</body>
</html>
