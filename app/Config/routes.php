<?php

/**
 * Route Definitions
 * Format: ['METHOD', 'path', 'ControllerClass@method', 'middleware']
 */

return [
    // ==============================
    // FRONTEND ROUTES
    // ==============================

    // Beranda
    ['GET', '/', 'Frontend\HomeController@index'],

    // Tentang Kami
    ['GET', '/tentang-kami', 'Frontend\AboutController@index'],
    ['GET', '/tentang-kami/visi-misi', 'Frontend\AboutController@visiMisi'],
    ['GET', '/tentang-kami/sejarah', 'Frontend\AboutController@sejarah'],
    ['GET', '/tentang-kami/struktur-organisasi', 'Frontend\AboutController@struktur'],
    ['GET', '/tentang-kami/lokasi', 'Frontend\AboutController@lokasi'],

    // Manajemen
    ['GET', '/manajemen', 'Frontend\ManagementController@index'],
    ['GET', '/manajemen/dewan-komisaris', 'Frontend\ManagementController@komisaris'],
    ['GET', '/manajemen/dewan-direksi', 'Frontend\ManagementController@direksi'],
    ['GET', '/manajemen/dewan-pengawas-syariah', 'Frontend\ManagementController@pengawasSyariah'],

    // Produk & Layanan
    ['GET', '/produk', 'Frontend\ProductController@index'],
    ['GET', '/produk/{slug}', 'Frontend\ProductController@detail'],
    ['GET', '/produk/tabungan', 'Frontend\ProductController@tabungan'],
    ['GET', '/produk/deposito', 'Frontend\ProductController@deposito'],
    ['GET', '/produk/pembiayaan', 'Frontend\ProductController@pembiayaan'],
    ['GET', '/faq', 'Frontend\ProductController@faq'],

    // Publikasi
    ['GET', '/publikasi', 'Frontend\PublicationController@index'],
    ['GET', '/publikasi/laporan-keuangan', 'Frontend\PublicationController@keuangan'],
    ['GET', '/publikasi/laporan-tata-kelola', 'Frontend\PublicationController@tataKelola'],
    ['GET', '/publikasi/laporan-tahunan', 'Frontend\PublicationController@tahunan'],
    ['GET', '/publikasi/laporan-berkelanjutan', 'Frontend\PublicationController@berkelanjutan'],
    ['GET', '/publikasi/download/{id}', 'Frontend\PublicationController@download'],

    // Blog & Berita
    ['GET', '/berita', 'Frontend\ArticleController@index'],
    ['GET', '/berita/{slug}', 'Frontend\ArticleController@detail'],
    ['GET', '/berita/kategori/{slug}', 'Frontend\ArticleController@kategori'],

    // Hubungi Kami
    ['GET', '/hubungi-kami', 'Frontend\ContactController@index'],
    ['POST', '/hubungi-kami', 'Frontend\ContactController@store'],

    // Karir
    ['GET', '/karir', 'Frontend\CareerController@index'],
    ['GET', '/karir/{id}', 'Frontend\CareerController@detail'],

    // Whistleblowing
    ['GET', '/whistleblowing', 'Frontend\ContactController@whistleblow'],
    ['POST', '/whistleblowing', 'Frontend\ContactController@storeWhistleblow'],

    // Lelang
    ['GET', '/lelang', 'Frontend\AuctionController@index'],
    ['GET', '/lelang/{id}', 'Frontend\AuctionController@detail'],

    // ==============================
    // BACKEND / ADMIN ROUTES
    // ==============================

    // Auth
    ['GET', '/admin/login', 'Backend\AuthController@showLogin'],
    ['POST', '/admin/login', 'Backend\AuthController@login'],
    ['POST', '/admin/logout', 'Backend\AuthController@logout'],

    // Dashboard
    ['GET', '/admin', 'Backend\DashboardController@index', 'auth'],
    ['GET', '/admin/dashboard', 'Backend\DashboardController@index', 'auth'],

    // Users (Admin only)
    ['GET', '/admin/users', 'Backend\UserController@index', 'auth:users.manage'],
    ['GET', '/admin/users/create', 'Backend\UserController@create', 'auth:users.manage'],
    ['POST', '/admin/users', 'Backend\UserController@store', 'auth:users.manage'],
    ['GET', '/admin/users/{id}/edit', 'Backend\UserController@edit', 'auth:users.manage'],
    ['POST', '/admin/users/{id}', 'Backend\UserController@update', 'auth:users.manage'],
    ['POST', '/admin/users/{id}/delete', 'Backend\UserController@destroy', 'auth:users.manage'],

    // Sliders
    ['GET', '/admin/sliders', 'Backend\ContentController@sliders', 'auth:content.manage'],
    ['POST', '/admin/sliders', 'Backend\ContentController@storeSlider', 'auth:content.manage'],
    ['POST', '/admin/sliders/{id}', 'Backend\ContentController@updateSlider', 'auth:content.manage'],
    ['POST', '/admin/sliders/{id}/delete', 'Backend\ContentController@deleteSlider', 'auth:content.manage'],

    // Articles
    ['GET', '/admin/articles', 'Backend\ArticleAdminController@index', 'auth:articles.manage'],
    ['GET', '/admin/articles/create', 'Backend\ArticleAdminController@create', 'auth:articles.manage'],
    ['POST', '/admin/articles', 'Backend\ArticleAdminController@store', 'auth:articles.manage'],
    ['GET', '/admin/articles/{id}/edit', 'Backend\ArticleAdminController@edit', 'auth:articles.manage'],
    ['POST', '/admin/articles/{id}', 'Backend\ArticleAdminController@update', 'auth:articles.manage'],
    ['POST', '/admin/articles/{id}/delete', 'Backend\ArticleAdminController@destroy', 'auth:articles.manage'],

    // Products
    ['GET', '/admin/products', 'Backend\ProductAdminController@index', 'auth:products.manage'],
    ['GET', '/admin/products/create', 'Backend\ProductAdminController@create', 'auth:products.manage'],
    ['POST', '/admin/products', 'Backend\ProductAdminController@store', 'auth:products.manage'],
    ['GET', '/admin/products/{id}/edit', 'Backend\ProductAdminController@edit', 'auth:products.manage'],
    ['POST', '/admin/products/{id}', 'Backend\ProductAdminController@update', 'auth:products.manage'],
    ['POST', '/admin/products/{id}/delete', 'Backend\ProductAdminController@destroy', 'auth:products.manage'],

    // Publications
    ['GET', '/admin/publications', 'Backend\PublicationAdminController@index', 'auth:publications.manage'],
    ['GET', '/admin/publications/upload', 'Backend\PublicationAdminController@create', 'auth:publications.manage'],
    ['POST', '/admin/publications', 'Backend\PublicationAdminController@store', 'auth:publications.manage'],
    ['POST', '/admin/publications/{id}/delete', 'Backend\PublicationAdminController@destroy', 'auth:publications.manage'],

    // Management
    ['GET', '/admin/management', 'Backend\ManagementAdminController@index', 'auth:management.manage'],
    ['POST', '/admin/management', 'Backend\ManagementAdminController@store', 'auth:management.manage'],
    ['POST', '/admin/management/{id}', 'Backend\ManagementAdminController@update', 'auth:management.manage'],
    ['POST', '/admin/management/{id}/delete', 'Backend\ManagementAdminController@destroy', 'auth:management.manage'],

    // Auctions
    ['GET', '/admin/auctions', 'Backend\AuctionAdminController@index', 'auth:auctions.manage'],
    ['POST', '/admin/auctions', 'Backend\AuctionAdminController@store', 'auth:auctions.manage'],
    ['POST', '/admin/auctions/{id}', 'Backend\AuctionAdminController@update', 'auth:auctions.manage'],
    ['POST', '/admin/auctions/{id}/delete', 'Backend\AuctionAdminController@destroy', 'auth:auctions.manage'],

    // Careers
    ['GET', '/admin/careers', 'Backend\CareerAdminController@index', 'auth:careers.manage'],
    ['POST', '/admin/careers', 'Backend\CareerAdminController@store', 'auth:careers.manage'],
    ['POST', '/admin/careers/{id}', 'Backend\CareerAdminController@update', 'auth:careers.manage'],
    ['POST', '/admin/careers/{id}/delete', 'Backend\CareerAdminController@destroy', 'auth:careers.manage'],

    // Whistleblows
    ['GET', '/admin/whistleblows', 'Backend\WhistleblowController@index', 'auth:whistleblows.manage'],
    ['GET', '/admin/whistleblows/{id}', 'Backend\WhistleblowController@show', 'auth:whistleblows.manage'],
    ['POST', '/admin/whistleblows/{id}/status', 'Backend\WhistleblowController@updateStatus', 'auth:whistleblows.manage'],

    // Contacts
    ['GET', '/admin/contacts', 'Backend\ContactAdminController@index', 'auth:contacts.manage'],
    ['GET', '/admin/contacts/{id}', 'Backend\ContactAdminController@show', 'auth:contacts.manage'],
    ['POST', '/admin/contacts/{id}/read', 'Backend\ContactAdminController@markRead', 'auth:contacts.manage'],

    // Settings
    ['GET', '/admin/settings', 'Backend\SettingController@index', 'auth:settings.manage'],
    ['POST', '/admin/settings', 'Backend\SettingController@update', 'auth:settings.manage'],

    // Reports
    ['GET', '/admin/reports', 'Backend\DashboardController@reports', 'auth:reports.view'],
];
