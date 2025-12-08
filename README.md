# AUCTOBID - Laravel Backend & Admin Panel

![AUCTOBID Logo](auctobid-logo/AUCTOBID-Logo.png)
![AUCTOBID Favicon](auctobid-logo/AUCTOBID-Favicon.png)

**Sistem Pelelangan Online dengan Tema Medieval Fantasy**

---

## 🏰 Tentang Proyek

AUCTOBID adalah sistem lelang online berbasis web yang dibangun menggunakan Laravel 12. Aplikasi ini menyediakan REST API untuk mobile app dan panel admin untuk mengelola sistem lelang secara keseluruhan.

### 🎨 Tema Desain

Medieval Fantasy dengan palet warna:

-   **Primary**: `#8B4513` (Saddle Brown)
-   **Secondary**: `#D4AF37` (Gold)
-   **Background**: `#FFF8DC` (Cornsilk/Parchment)
-   **Text**: `#2F4F4F` (Dark Slate)
-   **Font**: Cinzel (heading), Merriweather (body)

---

## 🛠️ Tech Stack

-   **Framework**: Laravel 12
-   **Database**: MySQL / MariaDB
-   **Authentication**: Laravel Sanctum
-   **WebSocket**: Laravel Reverb
-   **Export**: Laravel Excel, DomPDF
-   **Styling**: Tailwind CSS
-   **Templating**: Blade

---

## 👥 Role Sistem

| Role           | Akses                                                                        |
| -------------- | ---------------------------------------------------------------------------- |
| **Admin**      | Dashboard, kelola user, kategori, kondisi, item, lelang, laporan, pengaturan |
| **Petugas**    | Kelola item, persetujuan barang, kelola lelang                               |
| **Masyarakat** | Submit barang, ikut lelang, bid, pembayaran (via API)                        |

---

## 📋 Fitur Utama

### Admin Panel

-   ✅ Dashboard statistik real-time
-   ✅ Manajemen pengguna (approve/suspend)
-   ✅ Manajemen kategori & kondisi barang
-   ✅ Persetujuan barang (approve/reject)
-   ✅ Manajemen lelang (buat/tutup)
-   ✅ Laporan (export Excel/PDF)
-   ✅ Pengaturan sistem

### REST API

-   ✅ Autentikasi (login, register, logout)
-   ✅ CRUD kategori & kondisi
-   ✅ Submit & kelola barang
-   ✅ Lelang & bidding real-time
-   ✅ Notifikasi pengguna
-   ✅ Pembayaran (simulasi)

---

## ⚙️ Instalasi

### Prasyarat

-   PHP >= 8.2
-   Composer
-   MySQL/MariaDB
-   Node.js >= 18 (untuk build assets)

### Langkah Instalasi

```bash
# 1. Install dependencies PHP
composer install

# 2. Copy file environment
cp .env.example .env

# 3. Generate application key
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=auctobid
# DB_USERNAME=root
# DB_PASSWORD=root

# 5. Jalankan migrasi database
php artisan migrate

# 6. Jalankan seeder untuk data awal
php artisan db:seed

# 7. Install Node dependencies dan build assets
npm install
npm run build

# 8. Buat symbolic link untuk storage
php artisan storage:link
```

---

## 🚀 Menjalankan Aplikasi

### Web Server

```bash
php artisan serve --port=8000
```

Akses panel admin: **http://localhost:8000/login**

### WebSocket (Laravel Reverb)

```bash
php artisan reverb:start --port=8080
```

---

## 🔑 Akun Default

| Role       | Email                | Password    |
| ---------- | -------------------- | ----------- |
| Admin      | admin@auctobid.com   | password123 |
| Petugas    | petugas@auctobid.com | password123 |
| Masyarakat | john@example.com     | password123 |

---

## 📡 API Endpoint Summary

**Base URL**: `http://localhost:8000/api/v1`

### Public

-   `GET /categories` - Daftar kategori
-   `GET /conditions` - Daftar kondisi
-   `GET /auctions` - Daftar lelang aktif
-   `POST /login` - Login pengguna
-   `POST /register` - Registrasi pengguna

### Authenticated

-   `GET /me` - Profil pengguna
-   `POST /items` - Submit barang
-   `POST /auctions/{id}/bid` - Pasang bid
-   `GET /notifications` - Daftar notifikasi

---

## 📁 Struktur Folder

```
AUCTOBID-Website/
├── app/
│   ├── Events/           # WebSocket events
│   ├── Exports/          # Excel exports
│   ├── Http/Controllers/
│   │   ├── Api/          # API controllers
│   │   └── Web/          # Web controllers
│   └── Models/           # Eloquent models
├── database/
│   ├── migrations/       # Database migrations
│   └── seeders/          # Database seeders
├── resources/views/      # Blade templates
├── routes/
│   ├── api.php           # API routes
│   └── web.php           # Web routes
└── public/images/        # Logo assets
```

---

## 🎯 Environment Variables

Key konfigurasi di `.env`:

```env
APP_NAME=AUCTOBID
DB_CONNECTION=mysql
DB_DATABASE=auctobid

BROADCAST_CONNECTION=reverb
REVERB_HOST=127.0.0.1
REVERB_PORT=8080
```

---

## 📝 Logo Assets

Logo disimpan di folder `auctobid-logo/`:

-   `AUCTOBID-Logo.png` - Logo utama
-   `AUCTOBID-Favicon.png` - Favicon

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan pendidikan TB Kelas 12.

---

**© 2024 AUCTOBID Team**
