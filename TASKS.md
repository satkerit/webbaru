# 📋 TASK LIST - Website Company Profile BPRS Bangka Belitung

**Project Repository:** https://github.com/satkerit/webbaru.git  
**Last Updated:** 03 Juli 2026  
**Status:** 🚧 In Progress

---

## 📊 Progress Overview

- **Total Tasks:** 89
- **Completed:** 25 ✅
- **In Progress:** 2 🚧
- **Not Started:** 62 ⏳
- **Overall Progress:** 28%

---

## 🎯 FASE 1: SETUP & PERSIAPAN (100% Complete)

### 1.1 Repository & Version Control

- [x] ✅ Initialize Git repository
- [x] ✅ Setup remote GitHub repository
- [x] ✅ Create .gitignore file
- [x] ✅ Create README.md
- [x] ✅ First commit & push to main branch

### 1.2 Project Structure

- [x] ✅ Create folder structure (MVC)
- [x] ✅ Setup app/ directory (Config, Controllers, Models, Views, Helpers, Middleware)
- [x] ✅ Setup public/ directory (assets, uploads, index.php, .htaccess)
- [x] ✅ Setup database/ directory
- [x] ✅ Setup storage/ directory (logs, cache, sessions)
- [x] ✅ Create .gitkeep files for empty directories

### 1.3 Configuration Files

- [x] ✅ Create .env.example
- [x] ✅ Create composer.json
- [x] ✅ Create app/Config/database.php
- [x] ✅ Create app/Config/app.php
- [x] ✅ Create app/Config/routes.php

---

## 🗄️ FASE 2: DATABASE & BACKEND CORE (100% Complete)

### 2.1 Database Schema

- [x] ✅ Create complete database schema (schema.sql)
- [x] ✅ Define users table with RBAC
- [x] ✅ Define roles & permissions tables
- [x] ✅ Define articles, categories tables
- [x] ✅ Define products table
- [x] ✅ Define publications table
- [x] ✅ Define management table
- [x] ✅ Define auctions table
- [x] ✅ Define careers table
- [x] ✅ Define whistleblows table
- [x] ✅ Define contacts table
- [x] ✅ Define settings table
- [x] ✅ Define visitor_logs & login_logs tables
- [x] ✅ Create indexes for optimization
- [x] ✅ Insert default data (admin user, roles, permissions, settings)

### 2.2 Core Helpers & Classes

- [x] ✅ Create Database helper (PDO Singleton)
- [x] ✅ Create Security helper (CSRF, Sanitasi, Password, Rate Limiting)
- [x] ✅ Create RBAC helper
- [x] ✅ Create Common helper functions
- [x] ✅ Create Router class
- [x] ✅ Create BaseController
- [x] ✅ Create AuthMiddleware

### 2.3 Backend Controllers (Admin)

- [x] ✅ AuthController (Login, Logout)
- [x] ✅ DashboardController (Stats, Reports)
- [ ] ⏳ UserController (CRUD Users)
- [ ] ⏳ ContentController (Sliders, Pages)
- [ ] ⏳ ArticleAdminController (CRUD Articles)
- [ ] ⏳ ProductAdminController (CRUD Products)
- [ ] ⏳ PublicationAdminController (Upload & Manage Publications)
- [ ] ⏳ ManagementAdminController (CRUD Management)
- [ ] ⏳ AuctionAdminController (CRUD Auctions)
- [ ] ⏳ CareerAdminController (CRUD Careers)
- [ ] ⏳ WhistleblowController (View & Manage)
- [ ] ⏳ ContactAdminController (View Messages)
- [ ] ⏳ SettingController (Website Settings)

---

## 🎨 FASE 3: FRONTEND CONTROLLERS (100% Complete)

### 3.1 Public Controllers

- [x] ✅ HomeController (Beranda)
- [x] ✅ AboutController (Tentang Kami, Visi Misi, Sejarah, Struktur, Lokasi)
- [x] ✅ ManagementController (Dewan Komisaris, Direksi, Pengawas Syariah)
- [x] ✅ ProductController (Produk & Layanan, Detail, FAQ)
- [x] ✅ ArticleController (Blog, Berita, Detail, Kategori)
- [x] ✅ ContactController (Form Kontak, Whistleblowing)
- [x] ✅ PublicationController (Publikasi, Download)
- [x] ✅ AuctionController (Lelang Aset)
- [x] ✅ CareerController (Lowongan Kerja)

---

## 🖼️ FASE 4: FRONTEND VIEWS (20% Complete)

### 4.1 Layout Templates

- [x] ✅ Create main layout (layouts/main.php)
- [x] ✅ Create responsive navbar (layouts/navbar.php)
- [x] ✅ Create footer (layouts/footer.php)
- [ ] 🚧 Create breadcrumb component
- [ ] ⏳ Create pagination component
- [ ] ⏳ Create loading spinner component

### 4.2 Homepage

- [ ] 🚧 Create homepage view (pages/home.php)
- [ ] ⏳ Hero slider section
- [ ] ⏳ Info perusahaan section
- [ ] ⏳ Produk unggulan section
- [ ] ⏳ Berita terbaru section
- [ ] ⏳ CTA section

### 4.3 Tentang Kami Pages

- [ ] ⏳ pages/about/index.php
- [ ] ⏳ pages/about/visi-misi.php
- [ ] ⏳ pages/about/sejarah.php
- [ ] ⏳ pages/about/struktur.php
- [ ] ⏳ pages/about/lokasi.php

### 4.4 Manajemen Pages

- [ ] ⏳ pages/management/komisaris.php
- [ ] ⏳ pages/management/direksi.php
- [ ] ⏳ pages/management/pengawas-syariah.php

### 4.5 Produk & Layanan Pages

- [ ] ⏳ pages/products/index.php
- [ ] ⏳ pages/products/detail.php
- [ ] ⏳ pages/products/faq.php

### 4.6 Publikasi Pages

- [ ] ⏳ pages/publications/index.php
- [ ] ⏳ pages/publications/list.php

### 4.7 Blog & Berita Pages

- [ ] ⏳ pages/articles/index.php
- [ ] ⏳ pages/articles/detail.php

### 4.8 Other Pages

- [ ] ⏳ pages/contact.php
- [ ] ⏳ pages/whistleblowing.php
- [ ] ⏳ pages/auction.php
- [ ] ⏳ pages/auction-detail.php
- [ ] ⏳ pages/career.php
- [ ] ⏳ pages/career-detail.php
- [ ] ⏳ errors/404.php
- [ ] ⏳ errors/500.php

---

## 🎛️ FASE 5: BACKEND ADMIN VIEWS (0% Complete)

### 5.1 Auth & Layout

- [ ] ⏳ backend/layouts/auth.php (Login layout)
- [ ] ⏳ backend/layouts/dashboard.php (Main admin layout)
- [ ] ⏳ backend/layouts/sidebar.php
- [ ] ⏳ backend/layouts/topbar.php
- [ ] ⏳ backend/auth/login.php

### 5.2 Dashboard

- [ ] ⏳ backend/dashboard/index.php (Stats & widgets)
- [ ] ⏳ backend/reports/index.php (Analytics & reports)

### 5.3 Content Management

- [ ] ⏳ backend/content/sliders.php (CRUD Sliders)
- [ ] ⏳ backend/content/pages.php (Manage Pages)

### 5.4 Articles Management

- [ ] ⏳ backend/articles/index.php (List articles)
- [ ] ⏳ backend/articles/create.php (Create article)
- [ ] ⏳ backend/articles/edit.php (Edit article)

### 5.5 Products Management

- [ ] ⏳ backend/products/index.php
- [ ] ⏳ backend/products/create.php
- [ ] ⏳ backend/products/edit.php

### 5.6 Publications Management

- [ ] ⏳ backend/publications/index.php
- [ ] ⏳ backend/publications/upload.php

### 5.7 Management (Direksi) Admin

- [ ] ⏳ backend/management/index.php

### 5.8 Auctions Management

- [ ] ⏳ backend/auctions/index.php

### 5.9 Careers Management

- [ ] ⏳ backend/careers/index.php

### 5.10 Whistleblows Management

- [ ] ⏳ backend/whistleblows/index.php
- [ ] ⏳ backend/whistleblows/show.php

### 5.11 Contacts Management

- [ ] ⏳ backend/contacts/index.php
- [ ] ⏳ backend/contacts/show.php

### 5.12 Users & Roles Management

- [ ] ⏳ backend/users/index.php
- [ ] ⏳ backend/users/create.php
- [ ] ⏳ backend/users/edit.php
- [ ] ⏳ backend/roles/index.php

### 5.13 Settings

- [ ] ⏳ backend/settings/index.php (Website settings)

---

## 🎨 FASE 6: ASSETS (CSS, JS, IMAGES) (0% Complete)

### 6.1 CSS

- [ ] ⏳ Create public/assets/css/main.css (Custom styles)
- [ ] ⏳ Create public/assets/css/admin.css (Admin styles)
- [ ] ⏳ Optimize responsive styles
- [ ] ⏳ Add dark mode styles

### 6.2 JavaScript

- [ ] ⏳ Create public/assets/js/main.js (Main scripts)
- [ ] ⏳ Create public/assets/js/admin.js (Admin scripts)
- [ ] ⏳ Create public/assets/js/slider.js (Hero slider)
- [ ] ⏳ Add form validation script
- [ ] ⏳ Add lazy loading images
- [ ] ⏳ Add smooth scroll & back to top

### 6.3 Images & Icons

- [ ] ⏳ Add default logo
- [ ] ⏳ Add favicon
- [ ] ⏳ Add placeholder images
- [ ] ⏳ Add OJK & LPS badges
- [ ] ⏳ Optimize all images

---

## 🔧 FASE 7: SETUP & DEPLOYMENT (0% Complete)

### 7.1 Local Setup

- [ ] ⏳ Copy .env.example to .env
- [ ] ⏳ Configure database credentials in .env
- [ ] ⏳ Import schema.sql to MySQL database
- [ ] ⏳ Test database connection
- [ ] ⏳ Run composer install
- [ ] ⏳ Set proper folder permissions (uploads, storage)

### 7.2 Testing

- [ ] ⏳ Test frontend pages (all routes)
- [ ] ⏳ Test admin login
- [ ] ⏳ Test CRUD operations (Articles, Products, etc)
- [ ] ⏳ Test file uploads
- [ ] ⏳ Test form validations
- [ ] ⏳ Test RBAC permissions
- [ ] ⏳ Test responsive design (mobile, tablet, desktop)
- [ ] ⏳ Test dark mode
- [ ] ⏳ Cross-browser testing (Chrome, Firefox, Safari, Edge)
- [ ] ⏳ Security testing (XSS, CSRF, SQL Injection)
- [ ] ⏳ Performance testing (PageSpeed, GTmetrix)

### 7.3 Bug Fixes & Optimization

- [ ] ⏳ Fix identified bugs
- [ ] ⏳ Optimize database queries
- [ ] ⏳ Minify CSS & JS
- [ ] ⏳ Optimize images (WebP format)
- [ ] ⏳ Setup caching strategy
- [ ] ⏳ Add meta tags for SEO

### 7.4 Documentation

- [ ] ⏳ Update README.md with setup instructions
- [ ] ⏳ Create API documentation (if needed)
- [ ] ⏳ Create user manual for admin panel
- [ ] ⏳ Document deployment process

### 7.5 Production Deployment

- [ ] ⏳ Setup production server
- [ ] ⏳ Configure production .env
- [ ] ⏳ Setup SSL certificate (HTTPS)
- [ ] ⏳ Configure production .htaccess
- [ ] ⏳ Setup automated database backup
- [ ] ⏳ Setup error logging
- [ ] ⏳ Configure email settings
- [ ] ⏳ Setup monitoring (uptime, errors)
- [ ] ⏳ Deploy to production
- [ ] ⏳ Final testing on production
- [ ] ⏳ Go-live! 🚀

---

## 📝 NOTES & ISSUES

### Known Issues

- None yet

### Pending Decisions

- None

### Future Enhancements (Post-Launch)

- Multi-language support (English)
- Newsletter subscription
- Member portal
- Mobile app (PWA)
- Live chat support

---

## 🔗 Quick Links

- **GitHub Repo:** https://github.com/satkerit/webbaru.git
- **Local Dev:** http://localhost/company/public
- **Admin Panel:** http://localhost/company/public/admin/login
- **Default Admin:**
  - Username: `admin`
  - Password: `Admin@12345`

---

## 📅 Timeline Estimate

| Fase        | Durasi Estimasi | Target Selesai        |
| ----------- | --------------- | --------------------- |
| ✅ Fase 1-3 | 1 minggu        | 03 Jul 2026 (Selesai) |
| 🚧 Fase 4   | 3 minggu        | 24 Jul 2026           |
| ⏳ Fase 5   | 3 minggu        | 14 Agu 2026           |
| ⏳ Fase 6   | 1 minggu        | 21 Agu 2026           |
| ⏳ Fase 7   | 1 minggu        | 28 Agu 2026           |
| **Total**   | **9 minggu**    | **28 Agustus 2026**   |

---

**Last Updated:** 03 Juli 2026, 14:00 WIB  
**Updated By:** Kiro AI Assistant
