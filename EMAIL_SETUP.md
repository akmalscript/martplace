# 📧 Panduan Konfigurasi Email Outlook untuk MartPlace

## ✅ Sistem Sudah Siap!

Sistem verifikasi seller dengan email notification sudah lengkap:
- ✓ Email template untuk approval
- ✓ Email template untuk rejection
- ✓ Controller dengan integrasi email
- ✓ Admin interface untuk verifikasi
- ✓ Modal rejection dengan input alasan

## 🔧 Langkah Konfigurasi Outlook

### 1. Update File `.env`

Ganti kredensial email Anda di file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=your-email@outlook.com
MAIL_PASSWORD=your-outlook-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@outlook.com"
MAIL_FROM_NAME="MartPlace"
```

**Catatan:**
- Gunakan email Outlook/Hotmail yang valid
- Password adalah password login Outlook Anda
- Jika menggunakan 2FA, buat App Password di account.microsoft.com

### 2. Clear Config Cache

Setelah mengubah `.env`, jalankan:

```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Test Email Connectivity

Buka terminal dan jalankan:

```bash
php artisan tinker
```

Lalu test kirim email:

```php
Mail::raw('Test email dari MartPlace', function($message) {
    $message->to('test-email@gmail.com')
            ->subject('Test Email');
});
```

Jika berhasil, akan return `null`. Jika error, akan muncul pesan kesalahan.

## 🎯 Cara Menggunakan Sistem Verifikasi

### A. Registrasi Seller (Public)

1. Buka: `http://localhost/martplace/public/sellers/register`
2. Isi semua form (4 section):
   - Data Toko
   - Data PIC (termasuk email valid untuk terima notifikasi)
   - Alamat PIC (dropdown otomatis dari API)
   - Dokumen Identitas (upload foto & KTP)
3. Submit form
4. Status awal: **PENDING**

### B. Verifikasi oleh Admin

1. Login sebagai admin
2. Buka: `http://localhost/martplace/public/sellers`
3. Lihat daftar seller yang menunggu verifikasi
4. Klik "Detail" pada seller yang ingin diverifikasi
5. Review semua data dan dokumen

**Untuk MENYETUJUI:**
- Klik tombol "Setujui Seller"
- Email approval otomatis terkirim ke seller
- Email berisi: akun login (email + reminder password)

**Untuk MENOLAK:**
- Klik tombol "Tolak Seller"
- Modal akan muncul
- Isi alasan penolakan
- Klik "Kirim Penolakan"
- Email rejection otomatis terkirim ke seller
- Email berisi: alasan penolakan + link untuk daftar ulang

### C. Seller Menerima Email

**Email Approval:**
- Subject: "Selamat! Pendaftaran Seller Anda Disetujui"
- Isi:
  - Informasi akun (email login, nama toko)
  - Status ACTIVE
  - Tombol "Login ke Dashboard Seller"
  - Langkah selanjutnya

**Email Rejection:**
- Subject: "Pemberitahuan Penolakan Pendaftaran Seller"
- Isi:
  - Alasan penolakan dari admin
  - Checklist kelengkapan dokumen
  - Tombol "Daftar Ulang Sekarang"
  - Panduan perbaikan data

## 🧪 Test Flow Lengkap

### Test Scenario 1: Approval

1. Registrasi seller baru dengan email valid
2. Login sebagai admin → lihat di `/sellers`
3. Klik detail seller → klik "Setujui Seller"
4. Cek email seller → harus terima email approval
5. Seller bisa login dengan email & password yang didaftarkan

### Test Scenario 2: Rejection

1. Registrasi seller baru dengan email valid
2. Login sebagai admin → lihat di `/sellers`
3. Klik detail seller → klik "Tolak Seller"
4. Isi alasan: "Foto KTP tidak jelas, silakan upload ulang"
5. Klik "Kirim Penolakan"
6. Cek email seller → harus terima email rejection dengan alasan

## 🔍 Troubleshooting

### Error: "Connection refused"
**Solusi:** Pastikan port 587 tidak diblok firewall

### Error: "Authentication failed"
**Solusi:** 
1. Cek username/password di `.env`
2. Jika pakai 2FA, buat App Password di Microsoft Account
3. Pastikan akun Outlook tidak terkunci

### Error: "SSL certificate problem"
**Solusi:** Update file `config/mail.php`, tambahkan:
```php
'stream' => [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
    ],
],
```

### Email tidak terkirim tapi tidak error
**Solusi:**
1. Cek `storage/logs/laravel.log` untuk error
2. Cek folder Sent di Outlook untuk memastikan terkirim
3. Cek folder Spam di email penerima

## 📊 Monitoring Email

Untuk development, gunakan **Mailtrap** agar email tidak benar-benar terkirim:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

Daftar gratis di: https://mailtrap.io

## 📝 Routes Admin

```
GET  /sellers           → Daftar semua seller (dengan statistik)
GET  /sellers/{id}      → Detail seller (dengan tombol approve/reject)
POST /sellers/{id}/approve  → Approve seller + kirim email
POST /sellers/{id}/reject   → Reject seller + kirim email dengan reason
```

## 🎨 Fitur Email Template

**Design Email:**
- Responsive HTML email
- Gradient header (cyan-green sesuai tema MartPlace)
- Icon Font Awesome
- CTA button dengan gradient
- Footer dengan copyright

**Approval Email:**
- Success icon (✓)
- Informasi akun lengkap
- Warning untuk simpan password
- Direct login link

**Rejection Email:**
- Error icon (✕)
- Alasan penolakan jelas
- Checklist kelengkapan dokumen
- Encouragement untuk daftar ulang
- Link daftar ulang

## ✅ Checklist Testing

- [ ] Update `.env` dengan kredensial Outlook
- [ ] Clear config cache
- [ ] Test koneksi dengan `php artisan tinker`
- [ ] Registrasi seller baru dengan email valid
- [ ] Login admin dan approve seller
- [ ] Cek email approval diterima seller
- [ ] Registrasi seller lain
- [ ] Reject seller dengan alasan
- [ ] Cek email rejection diterima seller
- [ ] Verify email template tampil bagus
- [ ] Test link login di email approval
- [ ] Test link daftar ulang di email rejection

---

**Status:** ✅ Sistem siap digunakan! Tinggal konfigurasi email Outlook dan test.
