# 📊 Skema Database Martplace

## Daftar Isi
- [Overview](#overview)
- [Diagram Relasi](#diagram-relasi)
- [Tabel Utama](#tabel-utama)
- [Tabel Pendukung](#tabel-pendukung)
- [Relasi Antar Tabel](#relasi-antar-tabel)
- [Index & Optimasi](#index--optimasi)

---

## Overview

Database Martplace terdiri dari **12 tabel** yang dibagi menjadi beberapa kategori:
- **Autentikasi & User Management**: users, password_reset_tokens, sessions
- **E-Commerce Core**: categories, sellers, products, product_variants, product_images
- **Review & Rating System**: product_reviews, visitor_logs
- **Cache System**: cache, cache_locks

---

## Diagram Relasi

```
┌─────────────┐
│    USERS    │
│   (id, PK)  │
└──────┬──────┘
       │
       │ 1:1
       │
       ↓
┌─────────────────────┐         ┌──────────────────┐
│      SELLERS        │         │   CATEGORIES     │
│   (id, PK)          │         │   (id, PK)       │
│   (user_id, FK)     │         └────────┬─────────┘
└──────────┬──────────┘                  │
           │                             │
           │ 1:N                         │ 1:N
           │                             │
           ↓                             ↓
     ┌─────────────────────────────────────────┐
     │            PRODUCTS                     │
     │   (id, PK)                              │
     │   (seller_id, FK → sellers)             │
     │   (category_id, FK → categories)        │
     └───────┬──────────┬──────────┬───────────┘
             │          │          │
        1:N  │     1:N  │     1:N  │
             ↓          ↓          ↓
   ┌─────────────┐  ┌──────────────┐  ┌──────────────────┐
   │  PRODUCT    │  │   PRODUCT    │  │     PRODUCT      │
   │  VARIANTS   │  │   IMAGES     │  │     REVIEWS      │
   │  (id, PK)   │  │   (id, PK)   │  │   (id, PK)       │
   │ (product_id)│  │ (product_id) │  │  (product_id)    │
   └─────────────┘  └──────────────┘  └────────┬─────────┘
                                                │
                                                │ 1:N
                                                ↓
                                        ┌──────────────────┐
                                        │   VISITOR_LOGS   │
                                        │   (id, PK)       │
                                        │ (product_id, FK) │
                                        │ (review_id, FK)  │
                                        └──────────────────┘
```

---

## Tabel Utama

### 1. **users** (Tabel User & Autentikasi)
Menyimpan data pengguna sistem dengan multi-role support.

| Column | Type | Constraint | Keterangan |
|--------|------|-----------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| name | VARCHAR(255) | NOT NULL | Nama lengkap user |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email untuk login |
| email_verified_at | TIMESTAMP | NULLABLE | Waktu verifikasi email |
| password | VARCHAR(255) | NOT NULL | Password ter-hash |
| role | ENUM | DEFAULT 'user' | admin, seller, user |
| remember_token | VARCHAR(100) | NULLABLE | Token "remember me" |
| created_at | TIMESTAMP | | Waktu registrasi |
| updated_at | TIMESTAMP | | Waktu update terakhir |

**Index:**
- PRIMARY KEY (`id`)
- UNIQUE KEY (`email`)

---

### 2. **sellers** (Tabel Penjual/Toko)
Menyimpan informasi lengkap seller dan data verifikasi.

| Column | Type | Constraint | Keterangan |
|--------|------|-----------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | FK → users(id) | Relasi ke user |
| store_name | VARCHAR(255) | NOT NULL | Nama toko |
| store_description | TEXT | NULLABLE | Deskripsi toko |
| pic_name | VARCHAR(255) | NOT NULL | Nama PIC (Person In Charge) |
| pic_phone | VARCHAR(255) | NOT NULL | No. telepon PIC |
| pic_email | VARCHAR(255) | NOT NULL | Email PIC |
| password | VARCHAR(255) | NOT NULL | Password seller |
| pic_street | VARCHAR(255) | NOT NULL | Alamat jalan |
| pic_rt | VARCHAR(255) | NOT NULL | RT |
| pic_rw | VARCHAR(255) | NOT NULL | RW |
| pic_village | VARCHAR(255) | NOT NULL | Kelurahan/Desa |
| pic_district | VARCHAR(255) | NOT NULL | Kecamatan |
| pic_city | VARCHAR(255) | NOT NULL | Kota/Kabupaten |
| pic_province | VARCHAR(255) | NOT NULL | Provinsi |
| pic_ktp_number | VARCHAR(255) | UNIQUE, NOT NULL | Nomor KTP |
| pic_photo_path | VARCHAR(255) | NULLABLE | Path foto profil |
| pic_ktp_file_path | VARCHAR(255) | NULLABLE | Path file KTP |
| status | ENUM | DEFAULT 'PENDING' | PENDING, ACTIVE, REJECTED |
| city | VARCHAR(255) | NULLABLE | Kota toko |
| province | VARCHAR(255) | NULLABLE | Provinsi toko |
| district | VARCHAR(255) | NULLABLE | Kecamatan toko |
| rating | DECIMAL(3,2) | DEFAULT 0 | Rating toko (0-5) |
| total_products | INTEGER | DEFAULT 0 | Jumlah produk |
| created_at | TIMESTAMP | | Waktu daftar |
| updated_at | TIMESTAMP | | Waktu update terakhir |

**Foreign Keys:**
- `user_id` → `users(id)` ON DELETE CASCADE

**Index:**
- PRIMARY KEY (`id`)
- UNIQUE KEY (`pic_ktp_number`)
- INDEX (`user_id`)

---

### 3. **categories** (Tabel Kategori Produk)
Menyimpan kategori produk untuk klasifikasi dan filter.

| Column | Type | Constraint | Keterangan |
|--------|------|-----------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| name | VARCHAR(100) | NOT NULL | Nama kategori |
| slug | VARCHAR(100) | UNIQUE, NOT NULL | URL-friendly identifier |
| description | TEXT | NULLABLE | Deskripsi kategori |
| icon | VARCHAR(50) | NULLABLE | Font Awesome icon class |
| is_active | BOOLEAN | DEFAULT true | Status aktif |
| order | INTEGER | DEFAULT 0 | Urutan tampilan |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu update terakhir |

**Index:**
- PRIMARY KEY (`id`)
- UNIQUE KEY (`slug`)

---

### 4. **products** (Tabel Produk)
Tabel utama untuk menyimpan semua produk yang dijual.

| Column | Type | Constraint | Keterangan |
|--------|------|-----------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| seller_id | BIGINT UNSIGNED | FK → sellers(id) | Relasi ke seller |
| category_id | BIGINT UNSIGNED | FK → categories(id) | Relasi ke kategori |
| name | VARCHAR(200) | NOT NULL | Nama produk |
| slug | VARCHAR(200) | UNIQUE, NOT NULL | URL-friendly identifier |
| description | TEXT | NULLABLE | Deskripsi produk |
| price | DECIMAL(15,2) | NOT NULL | Harga satuan |
| stock | INTEGER | DEFAULT 0 | Jumlah stok |
| sold_count | INTEGER | DEFAULT 0 | Jumlah terjual |
| has_variants | BOOLEAN | DEFAULT false | Apakah punya varian |
| min_order | INTEGER | DEFAULT 1 | Minimal pemesanan |
| max_order | INTEGER | NULLABLE | Maksimal pemesanan |
| image_url | VARCHAR(255) | NULLABLE | URL gambar utama |
| average_rating | DECIMAL(3,2) | DEFAULT 0 | Rating rata-rata (0-5) |
| total_reviews | INTEGER | DEFAULT 0 | Jumlah review |
| province | VARCHAR(100) | NULLABLE | Provinsi asal produk |
| city | VARCHAR(100) | NULLABLE | Kota asal produk |
| is_active | BOOLEAN | DEFAULT true | Status aktif |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu update terakhir |
| deleted_at | TIMESTAMP | NULLABLE | Soft delete timestamp |

**Foreign Keys:**
- `seller_id` → `sellers(id)` ON DELETE CASCADE
- `category_id` → `categories(id)` ON DELETE SET NULL

**Index:**
- PRIMARY KEY (`id`)
- UNIQUE KEY (`slug`)
- INDEX (`name`)
- INDEX (`category_id`)
- INDEX (`seller_id`)
- INDEX (`province`)
- INDEX (`city`)
- INDEX (`average_rating`)

---

### 5. **product_variants** (Tabel Varian Produk)
Menyimpan varian produk dengan support 2 dimensi (misal: Warna x Ukuran).

| Column | Type | Constraint | Keterangan |
|--------|------|-----------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| product_id | BIGINT UNSIGNED | FK → products(id) | Relasi ke produk |
| variant_type_1 | VARCHAR(255) | NULLABLE | Tipe varian 1 (Warna) |
| variant_value_1 | VARCHAR(255) | NULLABLE | Nilai varian 1 (Merah) |
| variant_type_2 | VARCHAR(255) | NULLABLE | Tipe varian 2 (Ukuran) |
| variant_value_2 | VARCHAR(255) | NULLABLE | Nilai varian 2 (L) |
| price | DECIMAL(15,2) | NOT NULL | Harga varian |
| stock | INTEGER | DEFAULT 0 | Stok varian |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu update terakhir |

**Foreign Keys:**
- `product_id` → `products(id)` ON DELETE CASCADE

**Index:**
- PRIMARY KEY (`id`)
- INDEX (`product_id`, `variant_type_1`, `variant_value_1`)

---

### 6. **product_images** (Tabel Gambar Produk)
Menyimpan multiple images untuk setiap produk.

| Column | Type | Constraint | Keterangan |
|--------|------|-----------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| product_id | BIGINT UNSIGNED | FK → products(id) | Relasi ke produk |
| image_path | VARCHAR(255) | NOT NULL | Path file gambar |
| is_primary | BOOLEAN | DEFAULT false | Apakah gambar utama |
| order | INTEGER | DEFAULT 0 | Urutan tampilan |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu update terakhir |

**Foreign Keys:**
- `product_id` → `products(id)` ON DELETE CASCADE

**Index:**
- PRIMARY KEY (`id`)
- INDEX (`product_id`)

---

### 7. **product_reviews** (Tabel Review & Rating Produk)
Menyimpan review dan rating dari visitor dengan tracking email notification.

| Column | Type | Constraint | Keterangan |
|--------|------|-----------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| product_id | BIGINT UNSIGNED | FK → products(id) | Relasi ke produk |
| visitor_name | VARCHAR(100) | NOT NULL | Nama pemberi review |
| visitor_phone | VARCHAR(20) | NOT NULL | No. telepon visitor |
| visitor_email | VARCHAR(100) | NOT NULL | Email visitor |
| visitor_province | VARCHAR(100) | NOT NULL | Provinsi visitor |
| rating | INTEGER | NOT NULL | Rating 1-5 |
| comment | TEXT | NULLABLE | Komentar review |
| thank_you_email_sent | BOOLEAN | DEFAULT false | Status kirim email |
| email_sent_at | TIMESTAMP | NULLABLE | Waktu kirim email |
| is_visible | BOOLEAN | DEFAULT true | Status tampil |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu update terakhir |

**Foreign Keys:**
- `product_id` → `products(id)` ON DELETE CASCADE

**Index:**
- PRIMARY KEY (`id`)
- INDEX (`product_id`)
- INDEX (`rating`)
- INDEX (`visitor_province`)
- INDEX (`created_at`)

---

### 8. **visitor_logs** (Tabel Log Aktivitas Visitor)
Tracking aktivitas visitor untuk analytics dan reporting.

| Column | Type | Constraint | Keterangan |
|--------|------|-----------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| visitor_email | VARCHAR(100) | NOT NULL | Email visitor |
| visitor_name | VARCHAR(100) | NULLABLE | Nama visitor |
| visitor_province | VARCHAR(100) | NULLABLE | Provinsi visitor |
| activity_type | ENUM | DEFAULT 'view' | review, rating, view |
| product_id | BIGINT UNSIGNED | FK → products(id) | Relasi ke produk |
| product_review_id | BIGINT UNSIGNED | FK → reviews(id) | Relasi ke review |
| ip_address | VARCHAR(45) | NULLABLE | IP address visitor |
| user_agent | TEXT | NULLABLE | Browser info |
| created_at | TIMESTAMP | | Waktu aktivitas |
| updated_at | TIMESTAMP | | Waktu update terakhir |

**Foreign Keys:**
- `product_id` → `products(id)` ON DELETE SET NULL
- `product_review_id` → `product_reviews(id)` ON DELETE SET NULL

**Index:**
- PRIMARY KEY (`id`)
- INDEX (`visitor_email`)
- INDEX (`activity_type`)
- INDEX (`visitor_province`)
- INDEX (`created_at`)

---

## Tabel Pendukung

### 9. **password_reset_tokens** (Reset Password)
Menyimpan token untuk reset password.

| Column | Type | Constraint |
|--------|------|-----------|
| email | VARCHAR(255) | PRIMARY KEY |
| token | VARCHAR(255) | NOT NULL |
| created_at | TIMESTAMP | NULLABLE |

---

### 10. **sessions** (Session Management)
Menyimpan session user yang sedang login.

| Column | Type | Constraint |
|--------|------|-----------|
| id | VARCHAR(255) | PRIMARY KEY |
| user_id | BIGINT UNSIGNED | FK → users(id), INDEX |
| ip_address | VARCHAR(45) | NULLABLE |
| user_agent | TEXT | NULLABLE |
| payload | LONGTEXT | NOT NULL |
| last_activity | INTEGER | INDEX |

---

### 11. **cache** (Cache Storage)
Menyimpan data cache untuk performa.

| Column | Type | Constraint |
|--------|------|-----------|
| key | VARCHAR(255) | PRIMARY KEY |
| value | MEDIUMTEXT | NOT NULL |
| expiration | INTEGER | NOT NULL |

---

### 12. **cache_locks** (Cache Locking)
Mencegah race condition pada cache.

| Column | Type | Constraint |
|--------|------|-----------|
| key | VARCHAR(255) | PRIMARY KEY |
| owner | VARCHAR(255) | NOT NULL |
| expiration | INTEGER | NOT NULL |

---

## Relasi Antar Tabel

### 1️⃣ **users → sellers** (One-to-One)
```sql
sellers.user_id → users.id
ON DELETE CASCADE
```
- Setiap user bisa memiliki maksimal 1 seller account
- Jika user dihapus, seller account juga terhapus

### 2️⃣ **sellers → products** (One-to-Many)
```sql
products.seller_id → sellers.id
ON DELETE CASCADE
```
- Setiap seller bisa memiliki banyak produk
- Jika seller dihapus, semua produknya terhapus

### 3️⃣ **categories → products** (One-to-Many)
```sql
products.category_id → categories.id
ON DELETE SET NULL
```
- Setiap kategori bisa memiliki banyak produk
- Jika kategori dihapus, category_id produk menjadi NULL

### 4️⃣ **products → product_variants** (One-to-Many)
```sql
product_variants.product_id → products.id
ON DELETE CASCADE
```
- Setiap produk bisa memiliki banyak varian
- Jika produk dihapus, semua variannya terhapus

### 5️⃣ **products → product_images** (One-to-Many)
```sql
product_images.product_id → products.id
ON DELETE CASCADE
```
- Setiap produk bisa memiliki banyak gambar
- Jika produk dihapus, semua gambarnya terhapus

### 6️⃣ **products → product_reviews** (One-to-Many)
```sql
product_reviews.product_id → products.id
ON DELETE CASCADE
```
- Setiap produk bisa memiliki banyak review
- Jika produk dihapus, semua reviewnya terhapus

### 7️⃣ **products → visitor_logs** (One-to-Many)
```sql
visitor_logs.product_id → products.id
ON DELETE SET NULL
```
- Setiap produk bisa memiliki banyak log aktivitas
- Jika produk dihapus, log tetap ada (product_id = NULL)

### 8️⃣ **product_reviews → visitor_logs** (One-to-Many)
```sql
visitor_logs.product_review_id → product_reviews.id
ON DELETE SET NULL
```
- Setiap review bisa memiliki banyak log aktivitas
- Jika review dihapus, log tetap ada (review_id = NULL)

---

## Index & Optimasi

### Search & Filter Optimization
```sql
-- Produk search
INDEX products(name)
INDEX products(category_id)
INDEX products(seller_id)

-- Location-based search (SRS-05)
INDEX products(province)
INDEX products(city)
INDEX products(average_rating)

-- Review analysis (SRS-06)
INDEX product_reviews(product_id)
INDEX product_reviews(rating)
INDEX product_reviews(visitor_province)
INDEX product_reviews(created_at)

-- Visitor tracking
INDEX visitor_logs(visitor_email)
INDEX visitor_logs(activity_type)
INDEX visitor_logs(visitor_province)
INDEX visitor_logs(created_at)
```

### Composite Index
```sql
-- Varian lookup
INDEX product_variants(product_id, variant_type_1, variant_value_1)
```

---

## Fitur Khusus

### 🎯 **Soft Delete**
Tabel `products` mendukung soft delete:
- Column: `deleted_at` (TIMESTAMP NULLABLE)
- Produk yang dihapus tidak benar-benar hilang, hanya ditandai
- Bisa di-restore jika dibutuhkan

### 📧 **Email Notification Tracking**
Tabel `product_reviews` melacak pengiriman email:
- `thank_you_email_sent`: Status pengiriman
- `email_sent_at`: Timestamp pengiriman
- Mencegah duplicate email ke reviewer

### 📊 **Calculated Fields**
Beberapa field dihitung otomatis:
- `products.average_rating`: Rata-rata dari semua review
- `products.total_reviews`: Jumlah review
- `products.sold_count`: Counter penjualan
- `sellers.rating`: Rating toko
- `sellers.total_products`: Jumlah produk seller

### 🔍 **Multi-dimensional Variants**
Support varian 2 dimensi (contoh: Warna x Ukuran):
- `variant_type_1` + `variant_value_1`: Dimensi pertama
- `variant_type_2` + `variant_value_2`: Dimensi kedua
- Setiap kombinasi punya price & stock sendiri

---

## Query Contoh

### Get All Products with Relations
```php
Product::with(['seller', 'category', 'images', 'reviews', 'variants'])
    ->where('is_active', true)
    ->get();
```

### Get Products by Category
```php
Product::where('category_id', $categoryId)
    ->where('is_active', true)
    ->paginate(12);
```

### Get Products by Location (SRS-05)
```php
Product::where('province', $province)
    ->orWhere('city', $city)
    ->where('is_active', true)
    ->get();
```

### Get Product Reviews with Visitor Logs (SRS-06)
```php
ProductReview::with(['product', 'visitorLogs'])
    ->where('product_id', $productId)
    ->orderBy('created_at', 'desc')
    ->get();
```

### Analytics: Reviews by Province
```php
DB::table('product_reviews')
    ->select('visitor_province', DB::raw('count(*) as total'))
    ->groupBy('visitor_province')
    ->orderBy('total', 'desc')
    ->get();
```

---

## Changelog

| Versi | Tanggal | Perubahan |
|-------|---------|-----------|
| 1.0 | 2025-12-01 | Initial database schema |
| 1.1 | 2025-12-01 | Removed SKU fields from products & variants |
| 1.2 | 2025-12-01 | Removed discount fields (discount_percentage, original_price) |
| 1.3 | 2025-12-01 | Removed badge field from products |

---

## Catatan Penting

1. **Cascade Delete**: Hati-hati dengan cascade delete, pastikan backup data sebelum menghapus seller/produk
2. **Performance**: Index sudah dioptimalkan untuk query yang sering digunakan
3. **Scalability**: Tabel visitor_logs bisa grow cepat, pertimbangkan archiving strategy
4. **Backup**: Lakukan backup rutin terutama untuk tabel products, product_reviews, dan sellers
5. **Migration**: Jalankan migration secara berurutan sesuai timestamp filename

---

**Dibuat oleh:** Tim Development Martplace  
**Terakhir diupdate:** 1 Desember 2025
