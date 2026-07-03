-- ============================================================
-- DATABASE: bprs_babel_profile
-- DBMS: MySQL 8.0+
-- Website Company Profile BPRS Bangka Belitung
-- ============================================================

CREATE DATABASE IF NOT EXISTS bprs_babel_profile
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE bprs_babel_profile;

-- ============================================================
-- TABEL: roles
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
-- TABEL: permissions
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
-- TABEL: role_permissions
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
-- TABEL: users
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

-- Default Admin: password = Admin@12345
INSERT INTO users (username, email, password_hash, full_name, role_id, is_active) VALUES
    ('admin', 'admin@bprsbabel.id', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 1, 1);

-- ============================================================
-- TABEL: user_permissions
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
-- TABEL: categories
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

INSERT INTO categories (name, slug, type) VALUES
    ('Perusahaan', 'perusahaan', 'article'),
    ('Produk', 'produk', 'article'),
    ('CSR', 'csr', 'article'),
    ('Lainnya', 'lainnya', 'article');

-- ============================================================
-- TABEL: articles
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
-- TABEL: sliders
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
-- TABEL: pages
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
-- TABEL: products
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
-- TABEL: publications
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
-- TABEL: management
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
-- TABEL: auctions
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
-- TABEL: careers
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
-- TABEL: whistleblows
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
-- TABEL: contacts
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
-- TABEL: settings
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
-- TABEL: visitor_logs
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
-- TABEL: login_logs
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
