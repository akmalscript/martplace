<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Ditolak</title>
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
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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
        .error-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: #dc2626;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            color: white;
        }
        .alert-box {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .reason-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #e5e7eb;
        }
        .reason-title {
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .reason-text {
            color: #374151;
            line-height: 1.8;
        }
        .info-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
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
        .checklist {
            background: #f0fdf4;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .checklist h4 {
            color: #16a34a;
            margin-top: 0;
        }
        .checklist ul {
            padding-left: 20px;
            margin: 10px 0;
        }
        .checklist li {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="error-icon">✕</div>
        <h1 style="margin: 0; font-size: 28px;">Pemberitahuan Penolakan</h1>
        <p style="margin: 10px 0 0 0; font-size: 16px;">Pendaftaran Seller</p>
    </div>

    <div class="content">
        <p>Halo <strong>{{ $seller->pic_name }}</strong>,</p>

        <div class="alert-box">
            <p style="margin: 0;">
                Terima kasih atas minat Anda untuk bergabung sebagai seller di MartPlace. Setelah melakukan verifikasi terhadap data dan dokumen yang Anda kirimkan, dengan sangat menyesal kami informasikan bahwa pendaftaran toko "<strong>{{ $seller->store_name }}</strong>" Anda <strong>belum dapat kami setujui</strong> saat ini.
            </p>
        </div>

        <h3 style="color: #dc2626; border-bottom: 2px solid #fca5a5; padding-bottom: 10px;">Alasan Penolakan</h3>

        <div class="reason-box">
            <div class="reason-title">📋 Informasi dari Tim Verifikasi:</div>
            <div class="reason-text">
                {{ $reason }}
            </div>
        </div>

        <div class="info-box">
            <p style="margin: 0;">
                <strong>💡 Jangan khawatir!</strong> Anda masih dapat mendaftar kembali setelah melengkapi atau memperbaiki data dan dokumen yang dibutuhkan.
            </p>
        </div>

        <div class="checklist">
            <h4>✓ Pastikan Kelengkapan Dokumen Berikut:</h4>
            <ul>
                <li><strong>Foto Profil PIC:</strong> Pas foto terbaru dengan ukuran maksimal 2MB</li>
                <li><strong>Foto KTP:</strong> KTP asli, jelas terbaca, tidak blur, ukuran maksimal 5MB</li>
                <li><strong>Nomor KTP:</strong> Sesuai dengan foto KTP yang diunggah</li>
                <li><strong>Data Toko:</strong> Nama toko dan deskripsi yang lengkap</li>
                <li><strong>Data PIC:</strong> Nama lengkap, nomor telepon aktif, dan email valid</li>
                <li><strong>Alamat Lengkap:</strong> Alamat detail hingga kelurahan/desa, RT/RW</li>
            </ul>
        </div>

        <h3 style="color: #16a34a;">Cara Mendaftar Ulang:</h3>
        <ol style="padding-left: 20px;">
            <li>Siapkan dokumen dan data yang lengkap sesuai persyaratan</li>
            <li>Pastikan foto KTP jelas dan terbaca</li>
            <li>Lengkapi seluruh form pendaftaran dengan teliti</li>
            <li>Klik tombol di bawah untuk memulai pendaftaran ulang</li>
        </ol>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('sellers.create') }}" class="button">Daftar Ulang Sekarang</a>
        </div>

        <p>Jika Anda memiliki pertanyaan terkait penolakan ini atau membutuhkan klarifikasi lebih lanjut, silakan hubungi tim support kami. Kami siap membantu Anda untuk dapat bergabung sebagai seller di MartPlace.</p>

        <p style="margin-top: 30px;">
            Terima kasih atas pengertiannya,<br>
            <strong>Tim MartPlace</strong>
        </p>
    </div>

    <div class="footer">
        <p style="margin: 0;">Email ini dikirim otomatis dari sistem MartPlace</p>
        <p style="margin: 5px 0 0 0;">© 2025 MartPlace. All rights reserved.</p>
    </div>
</body>
</html>
