# Website Company Profile BPRS Bangka Belitung

Website company profile modern untuk PT. Bank Perekonomian Rakyat Syariah Bangka Belitung, dibangun dengan PHP & MySQL.

## Tech Stack

- **Backend:** PHP 8.1+ (Native MVC)
- **Database:** MySQL 8.0+ / MariaDB 10.6+
- **Frontend:** HTML5, CSS3 (Tailwind CSS), JavaScript (Vanilla + Alpine.js)
- **Web Server:** Apache 2.4+ (Laragon)

## Fitur Utama

### Frontend (Publik)

- Halaman Beranda dengan hero slider dinamis
- Tentang Kami (Visi & Misi, Sejarah, Struktur Organisasi, Lokasi)
- Manajemen (Dewan Komisaris, Direksi, Pengawas Syariah)
- Produk & Layanan (Tabungan, Deposito, Pembiayaan, FAQ)
- Publikasi (Laporan Keuangan, Tata Kelola, Tahunan, Berkelanjutan)
- Blog & Berita
- Hubungi Kami (Form Kontak, Lowongan Kerja, Whistleblowing System)
- Lelang Aset

### Backend (Admin Dashboard)

- Sistem Login dengan RBAC (Admin, Editor, Pelaporan)
- Manajemen Konten (Slider, Artikel, Halaman Statis)
- Manajemen Produk & Layanan
- Manajemen Publikasi (Upload PDF)
- Manajemen Manajemen (Profil Direksi)
- Manajemen Lelang & Lowongan Kerja
- Whistleblowing System
- Dashboard Analytics
- Pengaturan Website (Logo, Footer, SEO)

## Instalasi

### Persyaratan

- PHP 8.1+
- MySQL 8.0+ atau MariaDB 10.6+
- Composer
- Web server (Apache/Nginx) - Laragon direkomendasikan

### Langkah Instalasi

1. Clone repository:

```bash
git clone https://github.com/satkerit/webbaru.git
cd webbaru
```

2. Copy file environment:

```bash
cp .env.example .env
```

3. Edit `.env` sesuai konfigurasi database lokal Anda

4. Import database:

```bash
mysql -u root -p < database/schema.sql
```

5. Akses di browser: `http://localhost/company/public`

### Akun Default Admin

- **URL:** `/admin/login`
- **Username:** `admin`
- **Password:** `Admin@12345`

> ⚠️ **Ganti password default segera setelah login pertama!**

## Struktur Folder

```
company/
├── app/
│   ├── Config/          # Konfigurasi database & aplikasi
│   ├── Controllers/     # Controller (Frontend & Backend)
│   ├── Models/          # Model database
│   ├── Helpers/         # Helper (Security, RBAC, dll)
│   ├── Middleware/      # Middleware autentikasi & otorisasi
│   └── Views/           # Template PHP (Frontend & Backend)
├── database/
│   └── schema.sql       # Skema database
├── public/
│   ├── assets/          # CSS, JS, Images
│   ├── uploads/         # File upload user
│   ├── index.php        # Entry point
│   └── .htaccess
└── storage/             # Logs, cache, sessions
```

## Security

- SQL Injection Prevention (Prepared Statements)
- XSS Prevention (Output encoding)
- CSRF Protection (Token-based)
- Bcrypt Password Hashing
- Rate Limiting & Brute Force Protection
- Secure Session Management
- Security Headers (X-Frame-Options, CSP, dll)
- File Upload Validation

## Kontribusi

Lihat [CONTRIBUTING.md](CONTRIBUTING.md) untuk panduan kontribusi.

## Lisensi

© 2026 PT. BPRS Bangka Belitung. All Rights Reserved.

Berizin dan Diawasi oleh Otoritas Jasa Keuangan (OJK)  
Bank Peserta Penjaminan Lembaga Penjamin Simpanan (LPS)
