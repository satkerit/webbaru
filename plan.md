# DOKUMEN PERANCANGAN WEBSITE COMPANY PROFILE

## PT. Bank Perekonomian Rakyat Syariah Bangka Belitung

### Menggunakan PHP & MySQL

---

**Versi:** 1.0  
**Tanggal:** 3 Juli 2026  
**Penulis:** Tim Pengembangan IT  
**Status:** Draft Perancangan

---

## DAFTAR ISI

1. [Pendahuluan](#1-pendahuluan)
2. [Analisis Kebutuhan](#2-analisis-kebutuhan)
3. [Arsitektur Sistem](#3-arsitektur-sistem)
4. [Desain Database](#4-desain-database)
5. [Desain Antarmuka (UI/UX)](#5-desain-antarmuka-uiux)
6. [Struktur Menu & Fitur](#6-struktur-menu--fitur)
7. [Sistem RBAC (Role-Based Access Control)](#7-sistem-rbac-role-based-access-control)
8. [Implementasi Keamanan](#8-implementasi-keamanan)
9. [Struktur Folder & File](#9-struktur-folder--file)
10. [Timeline Pengembangan](#10-timeline-pengembangan)
11. [Lampiran](#11-lampiran)

---

## 1. PENDAHULUAN

### 1.1 Latar Belakang

PT. Bank Perekonomian Rakyat Syariah Bangka Belitung (BPRS Bangka Belitung) merupakan bank syariah yang beroperasi di wilayah Bangka Belitung. Sebagai institusi keuangan yang berkembang, BPRS Bangka Belitung memerlukan website company profile yang modern, responsif, dan aman untuk memperkenalkan perusahaan kepada publik, menyediakan informasi produk & layanan, serta menampilkan publikasi dan berita perusahaan.

### 1.2 Tujuan

- Membangun website company profile yang modern, ringan, dinamis, futuristik, auto-responsive
- Menyediakan informasi lengkap tentang perusahaan, produk, layanan, dan publikasi
- Membangun sistem dashboard admin dengan hak akses RBAC (Admin, Editor, Pelaporan)
- Menerapkan standar keamanan minimum untuk melindungi data dan sistem

### 1.3 Ruang Lingkup

| Komponen     | Keterangan                            |
| ------------ | ------------------------------------- |
| **Frontend** | Halaman publik untuk pengunjung umum  |
| **Backend**  | Dashboard admin dengan sistem RBAC    |
| **Database** | MySQL untuk penyimpanan data          |
| **Bahasa**   | PHP (Native / Framework)              |
| **Desain**   | Modern, Ringan, Responsif, Futuristik |

### 1.4 Referensi Website

Website referensi: [https://www.bprsbabel.id](https://www.bprsbabel.id)  
Website development: [https://dev.bprsbabel.id](https://dev.bprsbabel.id)

---

## 2. ANALISIS KEBUTUHAN

### 2.1 Kebutuhan Fungsional

#### 2.1.1 Frontend (Publik)

| No  | Fitur                                                                           | Prioritas |
| --- | ------------------------------------------------------------------------------- | --------- |
| 1   | Halaman Beranda (Home) dengan slider dinamis                                    | Tinggi    |
| 2   | Halaman Tentang Kami (Visi & Misi, Sejarah, Struktur Organisasi, Lokasi Kantor) | Tinggi    |
| 3   | Halaman Manajemen (Dewan Komisaris, Dewan Direksi, Dewan Pengawas Syariah)      | Tinggi    |
| 4   | Halaman Produk & Layanan (Tabungan, Deposito, Pembiayaan, FAQ)                  | Tinggi    |
| 5   | Halaman Publikasi (Laporan Keuangan, Tata Kelola, Tahunan, Berkelanjutan)       | Tinggi    |
| 6   | Halaman Blog & Berita (Artikel dinamis dengan kategori)                         | Tinggi    |
| 7   | Halaman Hubungi Kami (Form kontak, Lowongan Kerja, Whistleblowing System)       | Sedang    |
| 8   | Halaman Lelang (Informasi lelang aset)                                          | Sedang    |
| 9   | Info Perusahaan & Footer dinamis                                                | Sedang    |
| 10  | Integrasi Media Sosial                                                          | Sedang    |

#### 2.1.2 Backend (Dashboard Admin)

| No  | Fitur                                              | Prioritas |
| --- | -------------------------------------------------- | --------- |
| 1   | Sistem Login dengan RBAC                           | Tinggi    |
| 2   | Manajemen Pengguna (CRUD)                          | Tinggi    |
| 3   | Manajemen Konten (Slider, Artikel, Halaman Statis) | Tinggi    |
| 4   | Manajemen Produk & Layanan                         | Tinggi    |
| 5   | Manajemen Publikasi (Upload file PDF laporan)      | Tinggi    |
| 6   | Manajemen Manajemen (Profil jajaran direksi)       | Tinggi    |
| 7   | Manajemen Lelang                                   | Sedang    |
| 8   | Manajemen Lowongan Kerja                           | Sedang    |
| 9   | Manajemen Whistleblowing                           | Sedang    |
| 10  | Dashboard Analytics (Statistik pengunjung)         | Sedang    |
| 11  | Pengaturan Website (Logo, Footer, SEO)             | Sedang    |

### 2.2 Kebutuhan Non-Fungsional

| Aspek             | Kebutuhan                                                        |
| ----------------- | ---------------------------------------------------------------- |
| **Performa**      | Loading time < 3 detik, ukuran halaman < 2MB                     |
| **Responsif**     | Auto-responsive untuk Desktop, Tablet, Mobile                    |
| **Keamanan**      | Validasi input, sanitasi data, proteksi SQL Injection, XSS, CSRF |
| **SEO**           | Meta tags, Open Graph, Schema.org, friendly URL                  |
| **Aksesibilitas** | WCAG 2.1 Level AA                                                |
| **Browser**       | Chrome, Firefox, Safari, Edge (2 versi terakhir)                 |
| **Bahasa**        | Indonesia (default), opsional Bahasa Inggris                     |

---

## 3. ARSITEKTUR SISTEM

### 3.1 Diagram Arsitektur

```
┌─────────────────────────────────────────────────────────────┐
│                        CLIENT LAYER                         │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │   Desktop    │  │    Tablet    │  │    Mobile    │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└────────────────────────────┬────────────────────────────────┘
                             │ HTTPS/HTTP
┌────────────────────────────▼────────────────────────────────┐
│                     PRESENTATION LAYER                      │
│  ┌─────────────────────────────────────────────────────┐   │
│  │  Apache/Nginx Web Server                            │   │
│  │  ┌──────────────┐  ┌──────────────────────────────┐ │   │
│  │  │   Frontend   │  │      Backend (Dashboard)     │ │   │
│  │  │  (Public)    │  │         (Admin)              │ │   │
│  │  │  HTML/CSS/JS │  │   PHP + Template Engine      │ │   │
│  │  └──────────────┘  └──────────────────────────────┘ │   │
│  └─────────────────────────────────────────────────────┘   │
└────────────────────────────┬────────────────────────────────┘
                             │
┌────────────────────────────▼────────────────────────────────┐
│                      APPLICATION LAYER                      │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │  Controller  │  │   Service    │  │   Helper     │      │
│  │   (MVC)      │  │   (Logic)    │  │  (Utility)   │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │   Model      │  │   Router     │  │  Middleware  │      │
│  │  (ORM/DAO)   │  │  (Routing)   │  │  (Security)  │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└────────────────────────────┬────────────────────────────────┘
                             │ PDO/MySQLi
┌────────────────────────────▼────────────────────────────────┐
│                       DATA LAYER                            │
│  ┌─────────────────────────────────────────────────────┐   │
│  │              MySQL Database Server                    │   │
│  │  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌─────────┐ │   │
│  │  │  Users   │ │  Content │ │  Products│ │ Reports │ │   │
│  │  │   DB     │ │   DB     │ │    DB    │ │   DB    │ │   │
│  │  └──────────┘ └──────────┘ └──────────┘ └─────────┘ │   │
│  └─────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

### 3.2 Teknologi yang Digunakan

| Layer               | Teknologi                                      |
| ------------------- | ---------------------------------------------- |
| **Backend**         | PHP 8.1+ (Native / CodeIgniter 4 / Laravel 10) |
| **Database**        | MySQL 8.0+ / MariaDB 10.6+                     |
| **Frontend**        | HTML5, CSS3, JavaScript (Vanilla / Alpine.js)  |
| **CSS Framework**   | Tailwind CSS / Bootstrap 5                     |
| **Template Engine** | Blade (Laravel) / Native PHP                   |
| **Web Server**      | Apache 2.4+ / Nginx 1.20+                      |
| **Version Control** | Git                                            |
| **Package Manager** | Composer (PHP), NPM (JS)                       |

---

## 4. DESAIN DATABASE

### 4.1 Entity Relationship Diagram (ERD)

```
┌────────────────┐       ┌─────────────────┐       ┌──────────────────┐
│     users      │       │    roles        │       │  permissions     │
├────────────────┤       ├─────────────────┤       ├──────────────────┤
│ id (PK)        │       │ id (PK)         │       │ id (PK)          │
│ username       │       │ name            │       │ name             │
│ email          │       │ description     │       │ description      │
│ password       │       │ created_at      │       │ created_at       │
│ role_id (FK)   │◄─────►│ updated_at      │       │ updated_at       │
│ is_active      │       └─────────────────┘       └──────────────────┘
│ last_login     │                │                         │
│ created_at     │                │                         │
│ updated_at     │       ┌────────▼─────────┐    ┌─────────▼──────────┐
└────────────────┘       │ role_permissions │    │ user_permissions   │
                         ├──────────────────┤    ├────────────────────┤
                         │ role_id (FK)     │    │ user_id (FK)       │
                         │ permission_id(FK)│    │ permission_id (FK) │
                         └──────────────────┘    └────────────────────┘

┌────────────────┐       ┌─────────────────┐       ┌──────────────────┐
│    sliders     │       │    articles     │       │   categories     │
├────────────────┤       ├─────────────────┤       ├──────────────────┤
│ id (PK)        │       │ id (PK)         │       │ id (PK)          │
│ title          │       │ title           │       │ name             │
│ image          │       │ slug            │       │ slug             │
│ description    │       │ content         │       │ type             │
│ button_text    │       │ excerpt         │       │ description      │
│ button_link    │       │ featured_image  │       │ created_at       │
│ order          │       │ category_id(FK) │◄─────►│ updated_at       │
│ is_active      │       │ author_id (FK)  │       └──────────────────┘
│ created_at     │       │ is_published    │
│ updated_at     │       │ published_at    │
└────────────────┘       │ views           │
                         │ created_at      │
                         │ updated_at      │
                         └─────────────────┘

┌────────────────┐       ┌─────────────────┐       ┌──────────────────┐
│   products     │       │   pages         │       │   publications   │
├────────────────┤       ├─────────────────┤       ├──────────────────┤
│ id (PK)        │       │ id (PK)         │       │ id (PK)          │
│ name           │       │ title           │       │ title            │
│ slug           │       │ slug            │       │ type             │
│ type           │       │ content         │       │ file_path        │
│ description    │       │ meta_title      │       │ file_size        │
│ features       │       │ meta_desc       │       │ year             │
│ requirements   │       │ is_active       │       │ quarter          │
│ image          │       │ created_at      │       │ is_active        │
│ is_active      │       │ updated_at      │       │ created_at       │
│ created_at     │       └─────────────────┘       │ updated_at       │
│ updated_at     │                                 └──────────────────┘
└────────────────┘

┌────────────────┐       ┌─────────────────┐       ┌──────────────────┐
│  management    │       │   settings      │       │   contacts       │
├────────────────┤       ├─────────────────┤       ├──────────────────┤
│ id (PK)        │       │ id (PK)         │       │ id (PK)          │
│ name           │       │ key             │       │ name             │
│ position       │       │ value           │       │ email            │
│ type           │       │ group           │       │ phone            │
│ photo          │       │ description     │       │ subject          │
│ bio            │       │ created_at      │       │ message          │
│ order          │       │ updated_at      │       │ type             │
│ is_active      │       └─────────────────┘       │ is_read          │
│ created_at     │                                 │ created_at       │
│ updated_at     │                                 └──────────────────┘
└────────────────┘

┌────────────────┐       ┌─────────────────┐       ┌──────────────────┐
│   auctions     │       │   careers       │       │  whistleblows    │
├────────────────┤       ├─────────────────┤       ├──────────────────┤
│ id (PK)        │       │ id (PK)         │       │ id (PK)          │
│ title          │       │ title           │       │ name             │
│ description    │       │ department      │       │ email            │
│ asset_type     │       │ location        │       │ phone            │
│ start_date     │       │ requirements    │       │ category         │
│ end_date       │       │ description     │       │ description      │
│ starting_price │       │ deadline        │       │ attachment       │
│ status         │       │ is_active       │       │ is_anonymous     │
│ image          │       │ created_at      │       │ status           │
│ created_at     │       │ updated_at      │       │ created_at       │
│ updated_at     │       └─────────────────┘       └──────────────────┘
└────────────────┘
```

### 4.2 Skema Database (SQL)

````sql
-- ============================================================
-- DATABASE: bprs_babel_profile
-- DBMS: MySQL 8.0+
-- ============================================================

CREATE DATABASE IF NOT EXISTS bprs_babel_profile
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE bprs_babel_profile;

-- ============================================================
-- TABEL: roles (Peran Pengguna)
-- ============================================================
CREATE TABLE roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO roles (name, description) VALUES
    ('admin', 'Administrator - Full Access'),
    ('editor', 'Editor - Manage Content'),
    ('pelaporan', 'Pelaporan - Manage Reports & Publications');

-- ============================================================
-- TABEL: permissions (Izin Akses)
-- ============================================================
CREATE TABLE permissions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permissions (name, description) VALUES
    ('users.manage', 'Kelola pengguna'),
    ('roles.manage', 'Kelola peran'),
    ('content.manage', 'Kelola konten'),
    ('articles.manage', 'Kelola artikel'),
    ('products.manage', 'Kelola produk'),
    ('publications.manage', 'Kelola publikasi'),
    ('management.manage', 'Kelola manajemen'),
    ('auctions.manage', 'Kelola lelang'),
    ('careers.manage', 'Kelola lowongan'),
    ('whistleblows.manage', 'Kelola whistleblowing'),
    ('settings.manage', 'Kelola pengaturan'),
    ('reports.view', 'Lihat laporan/statistik'),
    ('contacts.manage', 'Kelola pesan kontak');

-- ============================================================
-- TABEL: role_permissions (Mapping Role ke Permission)
-- ============================================================
CREATE TABLE role_permissions (
    role_id INT UNSIGNED NOT NULL,
    permission_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin: Semua permission
INSERT INTO role_permissions (role_id, permission_id)
SELECT 1, id FROM permissions;

-- Editor: Konten, Artikel, Produk, Manajemen, Kontak
INSERT INTO role_permissions (role_id, permission_id) VALUES
    (2, 3), (2, 4), (2, 5), (2, 7), (2, 13);

-- Pelaporan: Publikasi, Lelang, Lowongan, Whistleblowing, Laporan
INSERT INTO role_permissions (role_id, permission_id) VALUES
    (3, 6), (3, 8), (3, 9), (3, 10), (3, 12);

-- ============================================================
-- TABEL: users (Pengguna)
-- ============================================================
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    phone VARCHAR(20),
    avatar VARCHAR(255),
    role_id INT UNSIGNED NOT NULL DEFAULT 2,
    is_active TINYINT(1) DEFAULT 1,
    email_verified_at TIMESTAMP NULL,
    last_login TIMESTAMP NULL,
    last_ip VARCHAR(45),
    failed_login_attempts INT DEFAULT 0,
    locked_until TIMESTAMP NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default Admin
INSERT INTO users (username, email, password_hash, full_name, role_id, is_active) VALUES
    ('admin', 'admin@bprsbabel.id', '$2y$10$...', 'Administrator', 1, 1);

-- ============================================================
-- TABEL: user_permissions (Permission khusus per user)
-- ============================================================
CREATE TABLE user_permissions (
    user_id INT UNSIGNED NOT NULL,
    permission_id INT UNSIGNED NOT NULL,
    granted TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, permission_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: categories (Kategori)
-- ============================================================
CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    type ENUM('article', 'product', 'publication', 'career') DEFAULT 'article',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: articles (Artikel/Berita)
-- ============================================================
CREATE TABLE articles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content LONGTEXT NOT NULL,
    excerpt TEXT,
    featured_image VARCHAR(255),
    category_id INT UNSIGNED,
    author_id INT UNSIGNED,
    is_published TINYINT(1) DEFAULT 0,
    published_at TIMESTAMP NULL,
    views INT UNSIGNED DEFAULT 0,
    meta_title VARCHAR(255),
    meta_description TEXT,
    meta_keywords VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: sliders (Slider/Banner Beranda)
-- ============================================================
CREATE TABLE sliders (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255),
    image VARCHAR(255) NOT NULL,
    description TEXT,
    button_text VARCHAR(50),
    button_link VARCHAR(255),
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: pages (Halaman Statis)
-- ============================================================
CREATE TABLE pages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content LONGTEXT NOT NULL,
    page_type ENUM('about', 'vision_mission', 'history', 'structure', 'location', 'faq') DEFAULT 'about',
    meta_title VARCHAR(255),
    meta_description TEXT,
    meta_keywords VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: products (Produk & Layanan)
-- ============================================================
CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    type ENUM('tabungan', 'deposito', 'pembiayaan') NOT NULL,
    description LONGTEXT,
    features LONGTEXT,
    requirements LONGTEXT,
    benefits LONGTEXT,
    image VARCHAR(255),
    brochure_file VARCHAR(255),
    is_featured TINYINT(1) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: publications (Publikasi/Laporan)
-- ============================================================
CREATE TABLE publications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type ENUM('laporan_keuangan', 'laporan_tata_kelola', 'laporan_tahunan', 'laporan_berkelanjutan') NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_size INT UNSIGNED,
    file_type VARCHAR(50),
    year YEAR NOT NULL,
    quarter ENUM('Q1', 'Q2', 'Q3', 'Q4', 'Full') DEFAULT 'Full',
    description TEXT,
    is_active TINYINT(1) DEFAULT 1,
    download_count INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: management (Jajaran Manajemen)
-- ============================================================
CREATE TABLE management (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    type ENUM('komisaris', 'direksi', 'pengawas_syariah') NOT NULL,
    photo VARCHAR(255),
    bio LONGTEXT,
    education TEXT,
    career_history TEXT,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: auctions (Lelang)
-- ============================================================
CREATE TABLE auctions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description LONGTEXT,
    asset_type ENUM('rumah', 'tanah', 'ruko', 'kendaraan', 'lainnya') NOT NULL,
    location VARCHAR(255),
    starting_price DECIMAL(18, 2) NOT NULL,
    current_price DECIMAL(18, 2),
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status ENUM('upcoming', 'active', 'completed', 'cancelled') DEFAULT 'upcoming',
    image VARCHAR(255),
    contact_person VARCHAR(100),
    contact_phone VARCHAR(20),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: careers (Lowongan Kerja)
-- ============================================================
CREATE TABLE careers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    department VARCHAR(100),
    location VARCHAR(100),
    employment_type ENUM('full_time', 'part_time', 'contract', 'internship') DEFAULT 'full_time',
    requirements LONGTEXT,
    responsibilities LONGTEXT,
    description LONGTEXT,
    deadline DATE,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: whistleblows (Whistleblowing System)
-- ============================================================
CREATE TABLE whistleblows (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    category ENUM('korupsi', 'penipuan', 'pelanggaran', 'lainnya') NOT NULL,
    description LONGTEXT NOT NULL,
    attachment VARCHAR(255),
    is_anonymous TINYINT(1) DEFAULT 0,
    status ENUM('new', 'in_review', 'investigating', 'resolved', 'rejected') DEFAULT 'new',
    admin_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: contacts (Pesan Kontak)
-- ============================================================
CREATE TABLE contacts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255),
    message LONGTEXT NOT NULL,
    type ENUM('general', 'complaint', 'suggestion', 'partnership') DEFAULT 'general',
    is_read TINYINT(1) DEFAULT 0,
    read_at TIMESTAMP NULL,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: settings (Pengaturan Website)
-- ============================================================
CREATE TABLE settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    setting_group ENUM('general', 'seo', 'social', 'contact', 'appearance') DEFAULT 'general',
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO settings (setting_key, setting_value, setting_group, description) VALUES
    ('site_name', 'BPRS Bangka Belitung', 'general', 'Nama website'),
    ('site_tagline', 'Bank Syariah Bangka Belitung', 'general', 'Tagline website'),
    ('site_logo', 'logo.png', 'general', 'Logo website'),
    ('site_favicon', 'favicon.ico', 'general', 'Favicon website'),
    ('meta_title', 'BPRS Bangka Belitung - Bank Syariah Terpercaya', 'seo', 'Meta title default'),
    ('meta_description', 'BPRS Bangka Belitung adalah bank syariah terpercaya di Bangka Belitung', 'seo', 'Meta description default'),
    ('meta_keywords', 'bank syariah, BPRS, Bangka Belitung, tabungan, deposito, pembiayaan', 'seo', 'Meta keywords default'),
    ('facebook_url', 'https://facebook.com/bprsbangkabelitung', 'social', 'URL Facebook'),
    ('instagram_url', 'https://instagram.com/bprsbangkabelitung', 'social', 'URL Instagram'),
    ('youtube_url', 'https://youtube.com/bprsbangkabelitung', 'social', 'URL YouTube'),
    ('phone', '0717-9103567', 'contact', 'Nomor telepon'),
    ('email', 'customercare@bprsbabel.id', 'contact', 'Email kontak'),
    ('address', 'Jl. [Alamat Kantor Pusat], Pangkalpinang, Bangka Belitung', 'contact', 'Alamat kantor'),
    ('footer_text', 'PT Bank Perekonomian Rakyat Syariah Bangka Belitung', 'appearance', 'Teks footer');

-- ============================================================
-- TABEL: visitor_logs (Log Pengunjung)
-- ============================================================
CREATE TABLE visitor_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    user_agent VARCHAR(255),
    page_url VARCHAR(500),
    referrer VARCHAR(500),
    session_id VARCHAR(100),
    visit_date DATE NOT NULL,
    visit_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABEL: login_logs (Log Aktivitas Login)
-- ============================================================
CREATE TABLE login_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED,
    username VARCHAR(50),
    ip_address VARCHAR(45),
    user_agent VARCHAR(255),
    status ENUM('success', 'failed', 'locked') NOT NULL,
    reason VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- INDEXES
-- ============================================================
CREATE INDEX idx_articles_slug ON articles(slug);
CREATE INDEX idx_articles_published ON articles(is_published, published_at);
CREATE INDEX idx_articles_category ON articles(category_id);
CREATE INDEX idx_products_slug ON products(slug);
CREATE INDEX idx_products_type ON products(type);
CREATE INDEX idx_publications_year ON publications(year);
CREATE INDEX idx_publications_type ON publications(type);
CREATE INDEX idx_management_type ON management(type);
CREATE INDEX idx_auctions_status ON auctions(status);
CREATE INDEX idx_careers_active ON careers(is_active, deadline);
CREATE INDEX idx_visitor_logs_date ON visitor_logs(visit_date);
CREATE INDEX idx_login_logs_user ON login_logs(user_id);
CREATE INDEX idx_login_logs_ip ON login_logs(ip_address);


---

## 5. DESAIN ANTARMUKA (UI/UX)

### 5.1 Prinsip Desain

| Prinsip | Implementasi |
|---------|-------------|
| **Ringan** | Minimalis, tidak ada elemen berat, lazy loading gambar |
| **Dinamis** | Konten dapat dikelola dari admin panel, animasi halus |
| **Futuristik** | Gradient modern, glassmorphism, micro-interactions |
| **Auto-Responsive** | Mobile-first design, breakpoint standar |
| **Modern** | Dark/light mode, clean typography, whitespace |

### 5.2 Palet Warna

```css
:root {
    /* Primary Colors */
    --primary: #1a5f4a;        /* Hijau tua - identitas syariah */
    --primary-light: #2d8b6f;
    --primary-dark: #0d3d2e;

    /* Secondary Colors */
    --secondary: #c9a84c;      /* Emas - kemakmuran */
    --secondary-light: #e0c06e;
    --secondary-dark: #a0853a;

    /* Accent Colors */
    --accent: #0ea5e9;         /* Biru modern */
    --accent-light: #38bdf8;
    --success: #22c55e;
    --warning: #f59e0b;
    --danger: #ef4444;

    /* Neutral Colors */
    --white: #ffffff;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;

    /* Dark Mode */
    --dark-bg: #0f172a;
    --dark-surface: #1e293b;
    --dark-text: #f1f5f9;
}
````

### 5.3 Tipografi

| Elemen     | Font    | Ukuran          | Berat |
| ---------- | ------- | --------------- | ----- |
| Heading H1 | Poppins | 48px / 3rem     | 700   |
| Heading H2 | Poppins | 36px / 2.25rem  | 600   |
| Heading H3 | Poppins | 24px / 1.5rem   | 600   |
| Body       | Inter   | 16px / 1rem     | 400   |
| Caption    | Inter   | 14px / 0.875rem | 400   |
| Button     | Poppins | 14px / 0.875rem | 500   |

### 5.4 Breakpoint Responsif

| Breakpoint | Ukuran | Target           |
| ---------- | ------ | ---------------- |
| sm         | 640px  | Mobile landscape |
| md         | 768px  | Tablet           |
| lg         | 1024px | Laptop           |
| xl         | 1280px | Desktop          |
| 2xl        | 1536px | Wide screen      |

### 5.5 Komponen UI Utama

#### 5.5.1 Navbar

- Sticky header dengan backdrop blur (glassmorphism)
- Logo kiri, menu tengah (desktop), hamburger menu (mobile)
- Dropdown menu untuk submenu
- Mode gelap/terang toggle
- CTA button (Hubungi Kami)

#### 5.5.2 Hero Section

- Full-width slider dengan auto-play
- Overlay gradient untuk keterbacaan teks
- Animated text (fade-in, slide-up)
- CTA buttons dengan hover effects

#### 5.5.3 Card Components

```
┌─────────────────────────────┐
│  [Gambar dengan overlay]    │
│                             │
│  ┌─────────────────────┐   │
│  │ Kategori Badge      │   │
│  │                     │   │
│  │ Judul Artikel       │   │
│  │                     │   │
│  │ Ringkasan singkat...│   │
│  │                     │   │
│  │ 📅 03 Jul 2026      │   │
│  └─────────────────────┘   │
└─────────────────────────────┘
```

#### 5.5.4 Footer

- 4 kolom: Info Perusahaan, Produk, Media Sosial, Kontak
- Logo & deskripsi perusahaan
- Quick links
- Social media icons
- Copyright & legal notices
- OJK & LPS badges

---

## 6. STRUKTUR MENU & FITUR

### 6.1 Frontend Menu Structure

```
🏠 BERANDA
    ├── Hero Slider
    ├── Info Perusahaan (Ringkasan)
    ├── Produk Unggulan
    ├── Berita Terbaru
    └── Footer

📋 TENTANG KAMI
    ├── Visi & Misi
    ├── Sejarah Perusahaan
    ├── Struktur Organisasi
    └── Lokasi Kantor

👔 MANAJEMEN
    ├── Dewan Komisaris
    ├── Dewan Direksi
    └── Dewan Pengawas Syariah

💰 PRODUK & LAYANAN
    ├── Tabungan
    │   ├── Tabungan Wadiah
    │   ├── Tabungan Mudharabah
    │   └── Tabungan Haji
    ├── Deposito
    │   ├── Deposito Mudharabah
    │   └── Deposito Wadiah
    ├── Pembiayaan
    │   ├── Pembiayaan Modal Kerja
    │   ├── Pembiayaan Investasi
    │   └── Pembiayaan Multiguna
    └── FAQ (Pertanyaan Umum)

📊 PUBLIKASI
    ├── Laporan Keuangan Publikasi
    ├── Laporan Tata Kelola
    ├── Laporan Tahunan
    └── Laporan Berkelanjutan

📰 BLOG & BERITA
    ├── Semua Berita
    ├── Kategori: Perusahaan
    ├── Kategori: Produk
    ├── Kategori: CSR
    └── Kategori: Lainnya

📞 HUBUNGI KAMI
    ├── Form Kontak
    ├── Lowongan Kerja
    └── Whistleblowing System

🔨 LELANG
    └── Daftar Lelang Aset
```

### 6.2 Backend Dashboard Menu Structure

```
📊 DASHBOARD
    ├── Statistik Pengunjung
    ├── Ringkasan Konten
    ├── Aktivitas Terbaru
    └── Notifikasi

📝 MANAJEMEN KONTEN
    ├── Slider/Banner
    ├── Artikel/Berita
    ├── Halaman Statis
    └── Kategori

🏦 PRODUK & LAYANAN
    ├── Daftar Produk
    ├── Tambah Produk
    └── FAQ

👔 MANAJEMEN
    ├── Dewan Komisaris
    ├── Dewan Direksi
    └── Dewan Pengawas Syariah

📄 PUBLIKASI
    ├── Laporan Keuangan
    ├── Laporan Tata Kelola
    ├── Laporan Tahunan
    └── Laporan Berkelanjutan

🔨 LELANG
    ├── Daftar Lelang
    └── Tambah Lelang

💼 LOWONGAN KERJA
    ├── Daftar Lowongan
    └── Pelamar

🚨 WHISTLEBLOWING
    ├── Daftar Laporan
    └── Status & Tindak Lanjut

📧 PESAN KONTAK
    ├── Kotak Masuk
    ├── Pesan Terbaca
    └── Arsip

⚙️ PENGATURAN
    ├── Informasi Website
    ├── SEO
    ├── Media Sosial
    ├── Kontak
    └── Tampilan

👥 PENGGUNA (Admin Only)
    ├── Daftar Pengguna
    ├── Peran (Roles)
    └── Izin (Permissions)

📈 LAPORAN (Pelaporan)
    ├── Statistik Pengunjung
    ├── Log Aktivitas
    └── Export Data
```

---

## 7. SISTEM RBAC (ROLE-BASED ACCESS CONTROL)

### 7.1 Definisi Role

| Role          | Deskripsi                                                          | Jumlah User |
| ------------- | ------------------------------------------------------------------ | ----------- |
| **Admin**     | Administrator sistem dengan akses penuh ke semua fitur             | 1-3         |
| **Editor**    | Mengelola konten website (artikel, halaman, produk, manajemen)     | 2-5         |
| **Pelaporan** | Mengelola publikasi, lelang, lowongan, whistleblowing, dan laporan | 1-3         |

### 7.2 Matriks Akses

| Fitur/Modul                |   Admin   | Editor  | Pelaporan |
| -------------------------- | :-------: | :-----: | :-------: |
| **Dashboard**              |    ✅     |   ✅    |    ✅     |
| **Manajemen Konten**       |           |         |           |
| ├── Slider/Banner          |  ✅ CRUD  | ✅ CRUD |    ❌     |
| ├── Artikel/Berita         |  ✅ CRUD  | ✅ CRUD |    ❌     |
| ├── Halaman Statis         |  ✅ CRUD  | ✅ CRUD |    ❌     |
| └── Kategori               |  ✅ CRUD  | ✅ CRUD |    ❌     |
| **Produk & Layanan**       |           |         |           |
| ├── Daftar Produk          |  ✅ CRUD  | ✅ CRUD |    ❌     |
| └── FAQ                    |  ✅ CRUD  | ✅ CRUD |    ❌     |
| **Manajemen**              |           |         |           |
| ├── Dewan Komisaris        |  ✅ CRUD  | ✅ CRUD |    ❌     |
| ├── Dewan Direksi          |  ✅ CRUD  | ✅ CRUD |    ❌     |
| └── Dewan Pengawas Syariah |  ✅ CRUD  | ✅ CRUD |    ❌     |
| **Publikasi**              |           |         |           |
| ├── Laporan Keuangan       |  ✅ CRUD  |   ❌    |  ✅ CRUD  |
| ├── Laporan Tata Kelola    |  ✅ CRUD  |   ❌    |  ✅ CRUD  |
| ├── Laporan Tahunan        |  ✅ CRUD  |   ❌    |  ✅ CRUD  |
| └── Laporan Berkelanjutan  |  ✅ CRUD  |   ❌    |  ✅ CRUD  |
| **Lelang**                 |           |         |           |
| ├── Daftar Lelang          |  ✅ CRUD  |   ❌    |  ✅ CRUD  |
| └── Tambah Lelang          |  ✅ CRUD  |   ❌    |  ✅ CRUD  |
| **Lowongan Kerja**         |           |         |           |
| ├── Daftar Lowongan        |  ✅ CRUD  |   ❌    |  ✅ CRUD  |
| └── Pelamar                |  ✅ CRUD  |   ❌    |  ✅ CRUD  |
| **Whistleblowing**         |           |         |           |
| ├── Daftar Laporan         |  ✅ CRUD  |   ❌    |  ✅ CRUD  |
| └── Status & Tindak Lanjut |  ✅ CRUD  |   ❌    |  ✅ CRUD  |
| **Pesan Kontak**           |           |         |           |
| ├── Kotak Masuk            |  ✅ CRUD  | ✅ Read |    ❌     |
| ├── Pesan Terbaca          |  ✅ CRUD  | ✅ Read |    ❌     |
| └── Arsip                  |  ✅ CRUD  | ✅ Read |    ❌     |
| **Pengaturan**             |           |         |           |
| ├── Informasi Website      |  ✅ CRUD  |   ❌    |    ❌     |
| ├── SEO                    |  ✅ CRUD  |   ❌    |    ❌     |
| ├── Media Sosial           |  ✅ CRUD  |   ❌    |    ❌     |
| ├── Kontak                 |  ✅ CRUD  |   ❌    |    ❌     |
| └── Tampilan               |  ✅ CRUD  |   ❌    |    ❌     |
| **Pengguna**               |           |         |           |
| ├── Daftar Pengguna        |  ✅ CRUD  |   ❌    |    ❌     |
| ├── Peran (Roles)          |  ✅ CRUD  |   ❌    |    ❌     |
| └── Izin (Permissions)     |  ✅ CRUD  |   ❌    |    ❌     |
| **Laporan**                |           |         |           |
| ├── Statistik Pengunjung   |  ✅ View  |   ❌    |  ✅ View  |
| ├── Log Aktivitas          |  ✅ View  |   ❌    |  ✅ View  |
| └── Export Data            | ✅ Export |   ❌    | ✅ Export |

### 7.3 Implementasi RBAC (PHP)

```php
<?php
/**
 * RBAC Helper Class
 * File: app/Helpers/RBAC.php
 */

class RBAC {

    private $db;
    private $userId;
    private $roleId;
    private $permissions = [];

    public function __construct($db, $userId) {
        $this->db = $db;
        $this->userId = $userId;
        $this->loadUserPermissions();
    }

    /**
     * Memuat permission user dari database
     */
    private function loadUserPermissions() {
        // Ambil role_id user
        $stmt = $this->db->prepare("SELECT role_id FROM users WHERE id = ?");
        $stmt->execute([$this->userId]);
        $user = $stmt->fetch();

        if (!$user) return;

        $this->roleId = $user['role_id'];

        // Ambil permission dari role
        $stmt = $this->db->prepare("
            SELECT p.name
            FROM permissions p
            JOIN role_permissions rp ON p.id = rp.permission_id
            WHERE rp.role_id = ?
        ");
        $stmt->execute([$this->roleId]);
        $rolePerms = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Ambil permission khusus user
        $stmt = $this->db->prepare("
            SELECT p.name
            FROM permissions p
            JOIN user_permissions up ON p.id = up.permission_id
            WHERE up.user_id = ? AND up.granted = 1
        ");
        $stmt->execute([$this->userId]);
        $userPerms = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $this->permissions = array_unique(array_merge($rolePerms, $userPerms));
    }

    /**
     * Cek apakah user memiliki permission
     */
    public function hasPermission($permission) {
        return in_array($permission, $this->permissions);
    }

    /**
     * Cek apakah user memiliki salah satu dari permissions
     */
    public function hasAnyPermission($permissions) {
        foreach ($permissions as $perm) {
            if ($this->hasPermission($perm)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Middleware untuk proteksi route
     */
    public function requirePermission($permission) {
        if (!$this->hasPermission($permission)) {
            header('HTTP/1.1 403 Forbidden');
            exit('Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    /**
     * Middleware untuk proteksi route (multiple permissions)
     */
    public function requireAnyPermission($permissions) {
        if (!$this->hasAnyPermission($permissions)) {
            header('HTTP/1.1 403 Forbidden');
            exit('Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    /**
     * Cek role user
     */
    public function hasRole($roleName) {
        $stmt = $this->db->prepare("SELECT id FROM roles WHERE name = ?");
        $stmt->execute([$roleName]);
        $role = $stmt->fetch();

        return $role && $role['id'] == $this->roleId;
    }

    /**
     * Dapatkan semua permission user
     */
    public function getPermissions() {
        return $this->permissions;
    }
}

/**
 * Penggunaan di Controller:
 *
 * $rbac = new RBAC($db, $_SESSION['user_id']);
 * $rbac->requirePermission('content.manage');
 *
 * // Di View:
 * if ($rbac->hasPermission('users.manage')) {
 *     // Tampilkan menu pengguna
 * }
 */
?>
```

---

## 8. IMPLEMENTASI KEAMANAN

### 8.1 Standar Keamanan Minimum

| No  | Aspek Keamanan               | Implementasi                                     | Level            |
| --- | ---------------------------- | ------------------------------------------------ | ---------------- |
| 1   | **HTTPS**                    | SSL/TLS certificate (Let's Encrypt)              | Wajib            |
| 2   | **Input Validation**         | Validasi semua input (server-side)               | Wajib            |
| 3   | **SQL Injection Prevention** | Prepared Statements / Parameterized Queries      | Wajib            |
| 4   | **XSS Prevention**           | Output encoding, CSP headers                     | Wajib            |
| 5   | **CSRF Protection**          | CSRF token pada form                             | Wajib            |
| 6   | **Password Security**        | Bcrypt hashing, minimum 8 karakter               | Wajib            |
| 7   | **Session Security**         | Regenerate ID, timeout, secure cookie            | Wajib            |
| 8   | **Rate Limiting**            | Limit login attempts, API throttling             | Wajib            |
| 9   | **File Upload Security**     | Validasi tipe, ukuran, scan virus                | Wajib            |
| 10  | **Error Handling**           | Custom error page, log tanpa expose detail       | Wajib            |
| 11  | **Security Headers**         | HSTS, X-Frame-Options, X-XSS-Protection          | Direkomendasikan |
| 12  | **Directory Traversal**      | Sanitasi path, whitelist direktori               | Wajib            |
| 13  | **Information Disclosure**   | Hide version info, error messages generik        | Wajib            |
| 14  | **Backup & Recovery**        | Backup otomatis database & file                  | Direkomendasikan |
| 15  | **Logging & Monitoring**     | Log aktivitas, failed login, suspicious activity | Direkomendasikan |

### 8.2 Implementasi Keamanan (PHP)

```php
<?php
/**
 * Security Helper Class
 * File: app/Helpers/Security.php
 */

class Security {

    private $db;
    private $maxLoginAttempts = 5;
    private $lockoutDuration = 900; // 15 menit

    public function __construct($db) {
        $this->db = $db;
    }

    // ============================================================
    // 1. CSRF PROTECTION
    // ============================================================

    /**
     * Generate CSRF Token
     */
    public function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Validate CSRF Token
     */
    public function validateCSRFToken($token) {
        if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            throw new Exception('CSRF token validation failed');
        }
        return true;
    }

    /**
     * CSRF Input Field
     */
    public function csrfField() {
        $token = $this->generateCSRFToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }

    // ============================================================
    // 2. INPUT SANITIZATION & VALIDATION
    // ============================================================

    /**
     * Sanitize string input
     */
    public static function sanitize($input, $type = 'string') {
        switch ($type) {
            case 'string':
                return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
            case 'email':
                return filter_var(trim($input), FILTER_SANITIZE_EMAIL);
            case 'int':
                return filter_var($input, FILTER_VALIDATE_INT);
            case 'float':
                return filter_var($input, FILTER_VALIDATE_FLOAT);
            case 'url':
                return filter_var(trim($input), FILTER_VALIDATE_URL);
            case 'html':
                // Allow specific HTML tags
                $allowed = '<p><br><strong><em><ul><ol><li><h1><h2><h3><h4><a>';
                return strip_tags(trim($input), $allowed);
            default:
                return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
        }
    }

    /**
     * Validate input
     */
    public static function validate($input, $rules) {
        $errors = [];

        foreach ($rules as $field => $ruleSet) {
            $value = $input[$field] ?? '';
            $rulesArray = explode('|', $ruleSet);

            foreach ($rulesArray as $rule) {
                $parts = explode(':', $rule);
                $ruleName = $parts[0];
                $ruleValue = $parts[1] ?? null;

                switch ($ruleName) {
                    case 'required':
                        if (empty($value)) {
                            $errors[$field][] = "Field $field wajib diisi.";
                        }
                        break;
                    case 'min':
                        if (strlen($value) < $ruleValue) {
                            $errors[$field][] = "Field $field minimal $ruleValue karakter.";
                        }
                        break;
                    case 'max':
                        if (strlen($value) > $ruleValue) {
                            $errors[$field][] = "Field $field maksimal $ruleValue karakter.";
                        }
                        break;
                    case 'email':
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $errors[$field][] = "Format email tidak valid.";
                        }
                        break;
                    case 'numeric':
                        if (!is_numeric($value)) {
                            $errors[$field][] = "Field $field harus berupa angka.";
                        }
                        break;
                    case 'alpha':
                        if (!ctype_alpha(str_replace(' ', '', $value))) {
                            $errors[$field][] = "Field $field hanya boleh huruf.";
                        }
                        break;
                }
            }
        }

        return empty($errors) ? true : $errors;
    }

    // ============================================================
    // 3. PASSWORD SECURITY
    // ============================================================

    /**
     * Hash password
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Verify password
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    /**
     * Validate password strength
     */
    public static function validatePasswordStrength($password) {
        $errors = [];

        if (strlen($password) < 8) {
            $errors[] = 'Password minimal 8 karakter.';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password harus mengandung huruf besar.';
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password harus mengandung huruf kecil.';
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password harus mengandung angka.';
        }
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = 'Password harus mengandung karakter khusus.';
        }

        return empty($errors) ? true : $errors;
    }

    // ============================================================
    // 4. RATE LIMITING (Login Protection)
    // ============================================================

    /**
     * Check login attempts
     */
    public function checkLoginAttempts($username, $ip) {
        $stmt = $this->db->prepare("
            SELECT failed_login_attempts, locked_until
            FROM users
            WHERE username = ? OR email = ?
        ");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        if (!$user) return true;

        // Cek apakah masih terkunci
        if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
            $remaining = strtotime($user['locked_until']) - time();
            throw new Exception("Akun terkunci. Coba lagi dalam " . ceil($remaining / 60) . " menit.");
        }

        return true;
    }

    /**
     * Record failed login
     */
    public function recordFailedLogin($username, $ip) {
        $stmt = $this->db->prepare("
            UPDATE users
            SET failed_login_attempts = failed_login_attempts + 1,
                locked_until = CASE
                    WHEN failed_login_attempts + 1 >= ?
                    THEN DATE_ADD(NOW(), INTERVAL ? SECOND)
                    ELSE locked_until
                END
            WHERE username = ? OR email = ?
        ");
        $stmt->execute([$this->maxLoginAttempts, $this->lockoutDuration, $username, $username]);

        // Log failed login
        $stmt = $this->db->prepare("
            INSERT INTO login_logs (username, ip_address, status, reason)
            VALUES (?, ?, 'failed', 'Invalid credentials')
        ");
        $stmt->execute([$username, $ip]);
    }

    /**
     * Reset login attempts on success
     */
    public function resetLoginAttempts($userId) {
        $stmt = $this->db->prepare("
            UPDATE users
            SET failed_login_attempts = 0, locked_until = NULL
            WHERE id = ?
        ");
        $stmt->execute([$userId]);
    }

    // ============================================================
    // 5. FILE UPLOAD SECURITY
    // ============================================================

    private $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private $allowedDocumentTypes = ['application/pdf'];
    private $maxFileSize = 5242880; // 5MB

    /**
     * Secure file upload
     */
    public function uploadFile($file, $directory, $allowedTypes = null) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Upload gagal: ' . $this->getUploadError($file['error']));
        }

        // Cek ukuran file
        if ($file['size'] > $this->maxFileSize) {
            throw new Exception('Ukuran file maksimal 5MB.');
        }

        // Validasi MIME type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        $allowed = $allowedTypes ?? array_merge($this->allowedImageTypes, $this->allowedDocumentTypes);

        if (!in_array($mimeType, $allowed)) {
            throw new Exception('Tipe file tidak diizinkan.');
        }

        // Generate nama file unik
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        $filepath = $directory . '/' . $filename;

        // Cek direktori
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Move file
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            throw new Exception('Gagal memindahkan file.');
        }

        return $filename;
    }

    private function getUploadError($code) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File terlalu besar (server limit).',
            UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (form limit).',
            UPLOAD_ERR_PARTIAL => 'File hanya terupload sebagian.',
            UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diupload.',
            UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary tidak ditemukan.',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke disk.',
            UPLOAD_ERR_EXTENSION => 'Upload dihentikan oleh ekstensi PHP.'
        ];
        return $errors[$code] ?? 'Unknown error';
    }

    // ============================================================
    // 6. SESSION SECURITY
    // ============================================================

    /**
     * Secure session start
     */
    public static function secureSessionStart() {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_secure', 1);
        ini_set('session.cookie_samesite', 'Strict');
        ini_set('session.use_strict_mode', 1);
        ini_set('session.gc_maxlifetime', 3600); // 1 jam

        session_start();

        // Regenerate session ID periodically
        if (!isset($_SESSION['last_regeneration'])) {
            $_SESSION['last_regeneration'] = time();
        } elseif (time() - $_SESSION['last_regeneration'] > 300) { // 5 menit
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }
    }

    // ============================================================
    // 7. SECURITY HEADERS
    // ============================================================

    /**
     * Set security headers
     */
    public static function setSecurityHeaders() {
        header('X-Frame-Options: DENY');
        header('X-Content-Type-Options: nosniff');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' fonts.googleapis.com cdn.jsdelivr.net; font-src 'self' fonts.gstatic.com; img-src 'self' data:; frame-ancestors 'none';");
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    }

    // ============================================================
    // 8. ANTI-BRUTE FORCE (IP-based)
    // ============================================================

    private $ipAttempts = [];

    /**
     * Check IP-based rate limiting
     */
    public function checkIPRateLimit($ip, $maxRequests = 100, $window = 3600) {
        $key = 'rate_limit_' . md5($ip);

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['count' => 1, 'start' => time()];
            return true;
        }

        $data = $_SESSION[$key];

        if (time() - $data['start'] > $window) {
            $_SESSION[$key] = ['count' => 1, 'start' => time()];
            return true;
        }

        if ($data['count'] >= $maxRequests) {
            throw new Exception('Terlalu banyak request. Silakan coba lagi nanti.');
        }

        $_SESSION[$key]['count']++;
        return true;
    }
}
?>
```

### 8.3 Konfigurasi .htaccess (Apache)

```apache
# ============================================================
# SECURITY CONFIGURATION
# ============================================================

# Disable directory browsing
Options -Indexes

# Disable server signature
ServerSignature Off

# Protect .htaccess and sensitive files
<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>

<FilesMatch "^(\.env|composer\.json|composer\.lock|package\.json)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Protect config and database files
<FilesMatch "\.(sql|ini|log|sh)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Enable rewrite engine
RewriteEngine On

# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R=301,L]

# Remove trailing slashes
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)/$ /$1 [R=301,L]

# Pretty URLs
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Security Headers
<IfModule mod_headers.c>
    Header always set X-Frame-Options "DENY"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always set Permissions-Policy "geolocation=(), microphone=(), camera=()"

    # HSTS (enable after SSL is confirmed working)
    # Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
</IfModule>

# PHP Settings
<IfModule mod_php.c>
    php_flag display_errors off
    php_value upload_max_filesize 5M
    php_value post_max_size 5M
    php_value max_execution_time 30
    php_value memory_limit 128M
</IfModule>

# Enable Gzip compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css
    AddOutputFilterByType DEFLATE application/javascript application/json
    AddOutputFilterByType DEFLATE image/svg+xml
</IfModule>

# Browser caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/webp "access plus 1 month"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType text/html "access plus 1 hour"
</IfModule>
```

---

## 9. STRUKTUR FOLDER & FILE

### 9.1 Struktur Direktori

```
bprs-babel-website/
│
├── 📁 app/
│   ├── 📁 Config/
│   │   ├── database.php          # Konfigurasi database
│   │   ├── app.php               # Konfigurasi aplikasi
│   │   └── routes.php            # Definisi routing
│   │
│   ├── 📁 Controllers/
│   │   ├── 📁 Frontend/
│   │   │   ├── HomeController.php
│   │   │   ├── AboutController.php
│   │   │   ├── ManagementController.php
│   │   │   ├── ProductController.php
│   │   │   ├── PublicationController.php
│   │   │   ├── ArticleController.php
│   │   │   ├── ContactController.php
│   │   │   ├── AuctionController.php
│   │   │   └── CareerController.php
│   │   │
│   │   └── 📁 Backend/
│   │       ├── DashboardController.php
│   │       ├── AuthController.php
│   │       ├── UserController.php
│   │       ├── RoleController.php
│   │       ├── ContentController.php
│   │       ├── ArticleAdminController.php
│   │       ├── ProductAdminController.php
│   │       ├── PublicationAdminController.php
│   │       ├── ManagementAdminController.php
│   │       ├── AuctionAdminController.php
│   │       ├── CareerAdminController.php
│   │       ├── WhistleblowController.php
│   │       ├── ContactAdminController.php
│   │       └── SettingController.php
│   │
│   ├── 📁 Models/
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Permission.php
│   │   ├── Article.php
│   │   ├── Category.php
│   │   ├── Slider.php
│   │   ├── Page.php
│   │   ├── Product.php
│   │   ├── Publication.php
│   │   ├── Management.php
│   │   ├── Auction.php
│   │   ├── Career.php
│   │   ├── Whistleblow.php
│   │   ├── Contact.php
│   │   ├── Setting.php
│   │   ├── VisitorLog.php
│   │   └── LoginLog.php
│   │
│   ├── 📁 Helpers/
│   │   ├── Security.php          # Helper keamanan
│   │   ├── RBAC.php              # Helper RBAC
│   │   ├── Validator.php         # Helper validasi
│   │   ├── Upload.php            # Helper upload file
│   │   ├── Mailer.php            # Helper email
│   │   └── Common.php            # Helper umum
│   │
│   ├── 📁 Middleware/
│   │   ├── AuthMiddleware.php
│   │   ├── RBACMiddleware.php
│   │   └── SecurityMiddleware.php
│   │
│   └── 📁 Views/
│       ├── 📁 frontend/
│       │   ├── 📁 layouts/
│       │   │   ├── main.php
│       │   │   ├── header.php
│       │   │   ├── footer.php
│       │   │   └── navbar.php
│       │   ├── 📁 pages/
│       │   │   ├── home.php
│       │   │   ├── about/
│       │   │   │   ├── vision-mission.php
│       │   │   │   ├── history.php
│       │   │   │   ├── structure.php
│       │   │   │   └── location.php
│       │   │   ├── management/
│       │   │   │   ├── commissioners.php
│       │   │   │   ├── directors.php
│       │   │   │   └── sharia-supervisors.php
│       │   │   ├── products/
│       │   │   │   ├── index.php
│       │   │   │   └── detail.php
│       │   │   ├── publications/
│       │   │   │   └── index.php
│       │   │   ├── articles/
│       │   │   │   ├── index.php
│       │   │   │   └── detail.php
│       │   │   ├── contact.php
│       │   │   ├── auction.php
│       │   │   └── career.php
│       │   └── 📁 components/
│       │       ├── slider.php
│       │       ├── product-card.php
│       │       ├── article-card.php
│       │       ├── pagination.php
│       │       └── breadcrumb.php
│       │
│       └── 📁 backend/
│           ├── 📁 layouts/
│           │   ├── dashboard.php
│           │   ├── sidebar.php
│           │   ├── topbar.php
│           │   └── footer.php
│           ├── 📁 auth/
│           │   ├── login.php
│           │   └── forgot-password.php
│           ├── 📁 dashboard/
│           │   └── index.php
│           ├── 📁 users/
│           │   ├── index.php
│           │   ├── create.php
│           │   └── edit.php
│           ├── 📁 roles/
│           │   └── index.php
│           ├── 📁 content/
│           │   ├── sliders.php
│           │   ├── articles.php
│           │   └── pages.php
│           ├── 📁 products/
│           │   ├── index.php
│           │   ├── create.php
│           │   └── edit.php
│           ├── 📁 publications/
│           │   ├── index.php
│           │   └── upload.php
│           ├── 📁 management/
│           │   └── index.php
│           ├── 📁 auctions/
│           │   └── index.php
│           ├── 📁 careers/
│           │   └── index.php
│           ├── 📁 whistleblows/
│           │   └── index.php
│           ├── 📁 contacts/
│           │   └── index.php
│           ├── 📁 settings/
│           │   └── index.php
│           └── 📁 reports/
│               └── index.php
│
├── 📁 public/
│   ├── 📁 assets/
│   │   ├── 📁 css/
│   │   │   ├── main.css
│   │   │   ├── admin.css
│   │   │   └── responsive.css
│   │   ├── 📁 js/
│   │   │   ├── main.js
│   │   │   ├── admin.js
│   │   │   ├── slider.js
│   │   │   └── validation.js
│   │   ├── 📁 images/
│   │   │   ├── logo.png
│   │   │   ├── favicon.ico
│   │   │   └── icons/
│   │   └── 📁 fonts/
│   ├── 📁 uploads/
│   │   ├── 📁 sliders/
│   │   ├── 📁 articles/
│   │   ├── 📁 products/
│   │   ├── 📁 publications/
│   │   ├── 📁 management/
│   │   ├── 📁 auctions/
│   │   └── 📁 whistleblows/
│   ├── index.php
│   └── .htaccess
│
├── 📁 database/
│   ├── schema.sql                # Skema database lengkap
│   └── seeds.sql                 # Data awal
│
├── 📁 storage/
│   ├── 📁 logs/
│   │   └── app.log
│   ├── 📁 cache/
│   └── 📁 sessions/
│
├── 📁 tests/
│   └── (Unit tests)
│
├── 📁 docs/
│   └── Dokumen_Perancangan.md
│
├── .env                          # Environment variables (tidak di-commit)
├── .env.example                  # Template environment
├── .gitignore
├── composer.json
├── composer.lock
├── package.json
├── README.md
└── LICENSE
```

---

## 10. TIMELINE PENGEMBANGAN

### 10.1 Fase Pengembangan

| Fase              | Kegiatan                         | Durasi       | Minggu |
| ----------------- | -------------------------------- | ------------ | ------ |
| **1. Persiapan**  |                                  | **1 minggu** | 1      |
|                   | Analisis kebutuhan & perancangan | 3 hari       |        |
|                   | Setup environment & repository   | 2 hari       |        |
| **2. Backend**    |                                  | **3 minggu** | 2-4    |
|                   | Setup database & migrasi         | 3 hari       |        |
|                   | Implementasi autentikasi & RBAC  | 4 hari       |        |
|                   | CRUD semua modul admin           | 10 hari      |        |
|                   | Implementasi keamanan            | 3 hari       |        |
| **3. Frontend**   |                                  | **3 minggu** | 5-7    |
|                   | Desain UI/UX & slicing           | 5 hari       |        |
|                   | Implementasi halaman publik      | 10 hari      |        |
|                   | Integrasi API & dinamis konten   | 5 hari       |        |
| **4. Testing**    |                                  | **1 minggu** | 8      |
|                   | Unit testing                     | 2 hari       |        |
|                   | Integration testing              | 2 hari       |        |
|                   | Security testing                 | 2 hari       |        |
|                   | UAT (User Acceptance Test)       | 1 hari       |        |
| **5. Deployment** |                                  | **1 minggu** | 9      |
|                   | Setup server production          | 2 hari       |        |
|                   | Deploy & konfigurasi             | 2 hari       |        |
|                   | Monitoring & stabilisasi         | 3 hari       |        |
| **Total**         |                                  | **9 minggu** |        |

### 10.2 Milestone

| Milestone | Target         | Deliverable                                 |
| --------- | -------------- | ------------------------------------------- |
| M1        | Akhir Minggu 1 | Dokumen perancangan final, environment siap |
| M2        | Akhir Minggu 4 | Backend API & admin panel selesai           |
| M3        | Akhir Minggu 7 | Frontend selesai, integrasi berjalan        |
| M4        | Akhir Minggu 8 | Testing selesai, bug fixes                  |
| M5        | Akhir Minggu 9 | Go-live production                          |

---

## 11. LAMPIRAN

### 11.1 Daftar API Endpoint (REST)

```
# AUTHENTICATION
POST   /api/auth/login
POST   /api/auth/logout
POST   /api/auth/forgot-password
POST   /api/auth/reset-password

# USERS (Admin only)
GET    /api/users
POST   /api/users
GET    /api/users/{id}
PUT    /api/users/{id}
DELETE /api/users/{id}

# ROLES (Admin only)
GET    /api/roles
POST   /api/roles
PUT    /api/roles/{id}
DELETE /api/roles/{id}

# ARTICLES
GET    /api/articles
POST   /api/articles
GET    /api/articles/{slug}
PUT    /api/articles/{id}
DELETE /api/articles/{id}

# PRODUCTS
GET    /api/products
POST   /api/products
GET    /api/products/{slug}
PUT    /api/products/{id}
DELETE /api/products/{id}

# PUBLICATIONS
GET    /api/publications
POST   /api/publications
GET    /api/publications/{id}/download
DELETE /api/publications/{id}

# MANAGEMENT
GET    /api/management
POST   /api/management
PUT    /api/management/{id}
DELETE /api/management/{id}

# AUCTIONS
GET    /api/auctions
POST   /api/auctions
PUT    /api/auctions/{id}
DELETE /api/auctions/{id}

# CAREERS
GET    /api/careers
POST   /api/careers
PUT    /api/careers/{id}
DELETE /api/careers/{id}

# CONTACTS
POST   /api/contact
GET    /api/contacts (admin)
PUT    /api/contacts/{id}/read (admin)

# WHISTLEBLOWS
POST   /api/whistleblow
GET    /api/whistleblows (admin)
PUT    /api/whistleblows/{id}/status (admin)

# SETTINGS
GET    /api/settings
PUT    /api/settings

# DASHBOARD
GET    /api/dashboard/stats
GET    /api/dashboard/activities
```

### 11.2 Checklist SEO

- [ ] Meta title & description unik per halaman
- [ ] Open Graph tags (Facebook)
- [ ] Twitter Card tags
- [ ] Schema.org structured data
- [ ] XML Sitemap
- [ ] Robots.txt
- [ ] Canonical URLs
- [ ] Friendly URL (slug)
- [ ] Alt text pada gambar
- [ ] Heading hierarchy (H1-H6)
- [ ] Internal linking
- [ ] Mobile-friendly
- [ ] Page speed optimization
- [ ] SSL/HTTPS

### 11.3 Checklist Performa

- [ ] Gzip compression enabled
- [ ] Browser caching configured
- [ ] Image optimization (WebP format)
- [ ] Lazy loading images
- [ ] Minify CSS & JS
- [ ] CDN untuk assets statis
- [ ] Database indexing
- [ ] Query optimization
- [ ] Pagination untuk data besar
- [ ] Connection pooling (jika memungkinkan)

### 11.4 Checklist Aksesibilitas (WCAG 2.1)

- [ ] Alt text pada semua gambar
- [ ] ARIA labels pada komponen interaktif
- [ ] Keyboard navigation support
- [ ] Color contrast ratio minimum 4.5:1
- [ ] Resizable text (up to 200%)
- [ ] Focus indicators visible
- [ ] Skip navigation link
- [ ] Form labels terkait
- [ ] Error messages deskriptif
- [ ] Screen reader compatible

---

## PENUTUP

Dokumen perancangan ini disusun sebagai panduan komprehensif untuk pengembangan website company profile BPRS Bangka Belitung. Dokumen ini mencakup aspek teknis, desain, keamanan, dan manajemen proyek yang diperlukan untuk membangun sistem yang modern, aman, dan terkelola dengan baik.

### Tim Proyek

| Peran              | Nama   | Kontak  |
| ------------------ | ------ | ------- |
| Project Manager    | [Nama] | [Email] |
| Lead Developer     | [Nama] | [Email] |
| UI/UX Designer     | [Nama] | [Email] |
| Backend Developer  | [Nama] | [Email] |
| Frontend Developer | [Nama] | [Email] |
| QA/Tester          | [Nama] | [Email] |

### Riwayat Revisi

| Versi | Tanggal      | Perubahan    | Penulis |
| ----- | ------------ | ------------ | ------- |
| 1.0   | 03 Juli 2026 | Dokumen awal | Tim IT  |

---

**PT. Bank Perekonomian Rakyat Syariah Bangka Belitung**  
Berizin dan Diawasi oleh Otoritas Jasa Keuangan (OJK)  
Bank Peserta Penjaminan Lembaga Penjamin Simpanan (LPS)

© 2026 PT. BPRS Bangka Belitung. All Rights Reserved.
