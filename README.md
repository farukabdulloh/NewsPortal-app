# 🌿 NewsPortal — Modern News & Editorial Web Application

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-v5.0-F59E0B?style=flat&logo=filament)](https://filamentphp.com)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-v4.0-38B2AC?style=flat&logo=tailwind-css)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

**NewsPortal** adalah aplikasi portal berita dan artikel berbasis **Laravel 12** dan **Filament v5** dengan antarmuka modern bertema **Soft Sage Green**, dukungan **Light Mode & Night Mode** adaptif, sistem otentikasi berbasis peran (*Admin* & *Author*), serta manajemen konten berita yang dinamis.

Dirancang dengan standar rekayasa perangkat lunak modern (clean architecture, robust security, zero-downtime database seeding, dan automated testing) sebagai portofolio profesional Software Engineer / Full Stack Web Developer.

---

## ✨ Fitur Utama

### 🌐 Antarmuka Publik (Public Website)
- **Desain Modern 2026 (Soft Sage Green Aesthetic):** Menggunakan palet warna hijau lembut (*sage green*), *off-white*, dan tipografi *Plus Jakarta Sans* yang nyaman dibaca untuk konten editorial.
- **Night Mode / Dark Mode:**
  - Pilihan tema *Light Mode* dan *Night Mode* (warna dasar *charcoal* & *muted green*, bukan *pure black*).
  - Preferensi tema disimpan secara persisten di `localStorage` tanpa efek kedip (*anti-FOUC*).
  - Transisi warna yang halus (*subtle CSS transitions*).
- **Hero Carousel Banner:** Menampilkan sorotan berita utama menggunakan *Swiper Carousel*.
- **Berita Unggulan & Liputan Terbaru:** Grid berita responsif dengan kategori dan *reading time estimate*.
- **Pencarian Berita:** Fitur pencarian artikel *real-time* berdasarkan judul dan isi berita.
- **Halaman Detail Berita & Profil Author:** Dilengkapi *breadcrumbs*, informasi penulis, artikel terkait, dan *author bio*.
- **Desain Responsif:** Optimal di semua ukuran layar (Desktop, Laptop, Tablet, dan Mobile Smartphone).
- **Fallback Aset Pintar:** Mencegah gambar rusak (*broken image 404*) secara otomatis jika file penyimpanan lokal belum terpasang.

### 🛡️ Admin Panel & Otentikasi (Filament v5)
- **Role-based Authentication:** Pemisahan hak akses antara `Admin` (akses penuh: Kelola Pengguna, Penulis, Berita, Kategori, Banner) dan `Author` (hanya dapat mengelola berita miliknya sendiri).
- **Tombol Back ke Website:** Halaman login Filament dilengkapi tombol `← Kembali ke Website (Back)` yang mengarah kembali ke beranda publik tanpa mengubah integritas otentikasi.
- **Registrasi Penulis Mandiri:** Calon kontributor dapat mendaftar melalui `/admin/register` dengan menyertakan biodata dan avatar.
- **Manajemen Berita Interaktif:** Rich text editor, status berita unggulan (*featured toggle*), upload thumbnail, dan pembuatan *slug* otomatis.

### ⚙️ Keamanan & Kestabilan
- Password dienkripsi dengan standar bcrypt Laravel (`'password' => 'hashed'`).
- Mencegah *N+1 Query Problem* dengan *eager loading* relasi Eloquent.
- *Strict Model Not Found Handling* (`firstOrFail()`) untuk mencegah celah *null pointer exception*.
- CLI Command aman `php artisan admin:manage` untuk membuat atau mereset password admin tanpa *hardcode* kredensial ke repository.

---

## 🛠️ Tech Stack

- **Backend:** PHP 8.2+, Laravel 12.x
- **Admin Panel:** Filament v5
- **Frontend / Styling:** Blade, Tailwind CSS v4, Vite 7, Swiper JS
- **Database:** MySQL / SQLite
- **Testing:** Pest PHP / PHPUnit

---

## 🚀 Panduan Instalasi Lokal (Getting Started)

### 1. Clone Repository
```bash
git clone https://github.com/farukabdulloh/NewsPortal-app.git
cd NewsPortal-app
```

### 2. Install Dependency PHP & Node
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
# Pada Windows PowerShell:
# Copy-Item .env.example .env
```
Buka file `.env` dan sesuaikan koneksi database Anda, contohnya:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=newsportal_app
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key & Storage Link
```bash
php artisan key:generate
php artisan storage:link
```

### 5. Jalankan Migration & Database Seeder
Database seeder sudah dilengkapi data kategori, artikel berita lengkap, banner, penulis, serta penyediaan thumbnail otomatis:
```bash
php artisan migrate --seed
```

### 6. Kelola / Reset Akun Admin
Jika Anda ingin melihat atau mereset akun administrator secara aman:
```bash
# Melihat daftar admin terdaftar:
php artisan admin:manage --list

# Membuat admin baru atau mereset password:
php artisan admin:manage --email=admin@newsportal.com --password=PasswordBaru123!
```

### 7. Jalankan Build Aset & Server
```bash
# Compile aset frontend:
npm run build

# Jalankan server lokal:
php artisan serve
```
Buka browser pada:
- **Website Publik:** `http://localhost:8000`
- **Admin Panel:** `http://localhost:8000/admin`

---

## 🧪 Menjalankan Automated Testing

Proyek ini telah dilengkapi dengan *test suite* otomatis untuk memastikan kestabilan seluruh endpoint publik, otentikasi, dan fungsionalitas CRUD:

```bash
php artisan test
```

Semua pengujian berjalan secara otomatis menggunakan *in-memory SQLite* dengan *RefreshDatabase*.

---

## 📦 Panduan Deployment ke Production

1. Pastikan variabel pada `.env` server production:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_KEY` terisi
   - Konfigurasi database produksi (`DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) terisi dengan benar.
2. Jalankan perintah optimasi:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan storage:link
   php artisan migrate --force
   ```
3. Lakukan build frontend:
   ```bash
   npm ci
   npm run build
   ```
4. Jika database produksi masih kosong, Anda dapat menjalankan seeder awal:
   ```bash
   php artisan db:seed --force
   ```

---

## 📄 Lisensi

Proyek ini dirilis di bawah lisensi [MIT](LICENSE).
