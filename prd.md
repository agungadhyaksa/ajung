# Product Requirement Document (PRD)
## Proyek Web PHP: Sistem Manajemen & Dashboard Dinamis (Ajung Portal)

---

### 1. Ringkasan Eksekutif (Executive Summary)
**Ajung Portal** adalah aplikasi web berbasis PHP modern yang dirancang untuk menyediakan sistem manajemen data, dashboard analitik, dan autentikasi pengguna yang ringan, aman, dan mudah digunakan. Aplikasi ini dibangun dengan arsitektur MVC (Model-View-Controller) modular tanpa ketergantungan library eksternal yang rumit, sehingga dapat langsung dijalankan menggunakan PHP Built-in Server atau lingkungan server lokal seperti XAMPP.

---

### 2. Sasaran & Tujuan (Goals & Objectives)
- **Kemudahan Deployment**: Dapat dijalankan langsung dengan XAMPP PHP (`php -S localhost:8000`) atau Apache.
- **Portabilitas Database**: Mendukung SQLite (out-of-the-box tanpa konfigurasi tambahan) dan MySQL/MariaDB (untuk skala produksi / XAMPP MySQL).
- **Keamanan Standar Industri**: Meliputi perlindungan CSRF token, hashing kata sandi (`password_hash`), perlindungan SQL Injection via PDO Prepared Statements, dan pencegahan XSS via escaping.
- **Tampilan Responsif & Modern**: Desain antarmuka clean dan interaktif menggunakan CSS modern dan Tailwind CSS (via CDN) yang ramah perangkat seluler dan desktop.

---

### 3. Persona Pengguna (User Personas)
1. **Administrator (Admin)**:
   - Mengelola seluruh data pengguna dan hak akses.
   - Melihat metrik ringkasan data di dashboard.
   - Menambah, mengubah, mencari, dan menghapus entitas data (operasi CRUD penuh).
2. **Pengguna Reguler (Staff / User)**:
   - Melihat data dashboard dan status entitas.
   - Menambahkan dan mengedit data miliknya sendiri.

---

### 4. Lingkup Fitur (Feature Scope)

#### 4.1 Modul Autentikasi & Akun
- **Login & Logout**: Autentikasi berbasis sesi aman (PHP Session Management).
- **Proteksi Rute**: Middleware/Guard sederhana untuk memblokir akses rute privat jika belum terautentikasi.
- **Manajemen Profil**: Pengguna dapat melihat informasi akun yang sedang login.

#### 4.2 Modul Dashboard
- **Statistik Cepat**: Widget total item, item aktif, dan ringkasan aktivitas.
- **Tabel Aktivitas Terakhir**: Menampilkan daftar data yang baru ditambahkan/diperbarui.
- **Notifikasi Pesan (Flash Messages)**: Umpan balik visual saat operasi berhasil atau gagal.

#### 4.3 Modul CRUD (Manajemen Entitas Data)
- **Create**: Form penambahan data dengan validasi input di sisi server.
- **Read**: Tampilan daftar data tabular dengan fitur pencarian dan filter status.
- **Update**: Edit data yang sudah tersimpan dengan pre-filled form.
- **Delete**: Konfirmasi penghapusan data secara aman dengan proteksi CSRF.

---

### 5. Arsitektur Teknis & Struktur Direktori

#### 5.1 Tech Stack
- **Bahasa**: PHP 8.x
- **Database Driver**: PHP Data Objects (PDO)
- **Database**: SQLite (default lokal) / MySQL (XAMPP)
- **Frontend**: HTML5, CSS3, Tailwind CSS (CDN), Vanilla JavaScript
- **Web Server**: PHP Built-in Server / Apache (XAMPP)

#### 5.2 Struktur Folder Proyek (`C:/agung/ajung/`)
```
C:/agung/ajung/
├── prd.md                    # Dokumen spesifikasi kebutuhan produk
├── README.md                 # Panduan instalasi dan menjalankan proyek
├── index.php                 # Front Controller / Entry Point aplikasi
├── config/
│   ├── config.php            # Pengaturan umum aplikasi (BASE_URL, App Name)
│   └── database.php          # Koneksi database via PDO (SQLite / MySQL)
├── app/
│   ├── controllers/
│   │   ├── AuthController.php    # Logika login, logout, sesi
│   │   ├── DashboardController.php# Logika tampilan metrik & ringkasan
│   │   └── ItemController.php    # Logika CRUD data
│   ├── models/
│   │   ├── User.php          # Interaksi database untuk data pengguna
│   │   └── Item.php          # Interaksi database untuk data entitas
│   └── helpers/
│       ├── AuthHelper.php    # Pengecekan sesi & hak akses
│       ├── CsrfHelper.php    # Pembuatan dan validasi token CSRF
│       └── ViewHelper.php    # Helper sanitasi XSS & format data
├── views/
│   ├── layouts/
│   │   ├── header.php        # Navigasi & asset CSS
│   │   └── footer.php        # Penutup layout & asset JS
│   ├── auth/
│   │   └── login.php         # Halaman form login
│   ├── dashboard/
│   │   └── index.php         # Tampilan dashboard & widget
│   └── items/
│       ├── index.php         # Tabel daftar data
│       ├── create.php        # Form tambah data
│       └── edit.php          # Form edit data
├── public/
│   ├── css/
│   │   └── style.css         # Styling kustom tambahan
│   └── js/
│       └── main.js           # Interaktivitas UI & konfirmasi dialog
└── database/
    ├── schema.sql            # Script SQL untuk inisialisasi tabel
    └── app.sqlite            # File database SQLite otomatis
```

---

### 6. Desain Basis Data (Database Schema)

#### Tabel `users`
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INTEGER PRIMARY KEY (AUTOINCREMENT) | ID unik pengguna |
| `username` | VARCHAR(50) UNIQUE NOT NULL | Username login |
| `email` | VARCHAR(100) UNIQUE NOT NULL | Alamat email |
| `password` | VARCHAR(255) NOT NULL | Hash kata sandi (`bcrypt`) |
| `role` | VARCHAR(20) DEFAULT 'user' | Peran pengguna (`admin` / `user`) |
| `created_at` | DATETIME DEFAULT CURRENT_TIMESTAMP | Waktu pendaftaran |

#### Tabel `items`
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INTEGER PRIMARY KEY (AUTOINCREMENT) | ID unik data |
| `user_id` | INTEGER NOT NULL | Relasi ke tabel `users.id` |
| `title` | VARCHAR(150) NOT NULL | Judul / Nama item |
| `category` | VARCHAR(50) NOT NULL | Kategori item |
| `status` | VARCHAR(20) DEFAULT 'active' | Status (`active` / `pending` / `completed`) |
| `description` | TEXT NULL | Deskripsi detail |
| `created_at` | DATETIME DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan |
| `updated_at` | DATETIME DEFAULT CURRENT_TIMESTAMP | Waktu pembaruan |

---

### 7. Kebutuhan Non-Fungsional (Non-Functional Requirements)
1. **Keamanan**:
   - Mencegah serangan CSRF dengan validasi token acak pada setiap form submission `POST`.
   - Menggunakan `htmlspecialchars()` untuk sanitasi output agar kebal XSS.
   - PDO Prepared Statement untuk semua query SQL dinamis.
2. **Kinerja & Kompatibilitas**:
   - Waktu muat halaman kurang dari 1 detik di lingkungan lokal.
   - Kompatibel penuh dengan PHP 8.0 ke atas.
3. **Penyimpanan**:
   - SQLite dipilih secara default agar pengguna tidak perlu repot setup database server awal.
   - Konfigurasi siap dialihkan ke MySQL di `config/database.php` hanya dengan mengubah satu baris setting.

---

### 8. Rencana Implementasi (Implementation Roadmap)
- [x] **Fase 1**: Penyusunan Dokumen Kebutuhan Produk (`prd.md`).
- [x] **Fase 2**: Pembuatan struktur folder proyek di `C:/agung/ajung/`.
- [x] **Fase 3**: Konfigurasi koneksi database & inisialisasi tabel default beserta user admin demo.
- [x] **Fase 4**: Pembuatan layout responsif (header, navbar, footer) dan helper keamanan.
- [x] **Fase 5**: Implementasi modul Autentikasi (login/logout), Dashboard, dan CRUD Item.
- [x] **Fase 6**: Uji coba aplikasi menggunakan PHP CLI server lokal.
