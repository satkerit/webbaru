<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$siteName    = $settings['site_name'] ?? 'BPRS Bangka Belitung';
$siteLogo    = $settings['site_logo'] ?? '';

$navLinks = [
    ['href' => '/',                     'label' => 'Beranda',      'key' => 'beranda'],
    ['href' => '/tentang-kami',         'label' => 'Tentang Kami', 'key' => 'tentang',
     'children' => [
         ['href' => '/tentang-kami/visi-misi',             'label' => 'Visi & Misi'],
         ['href' => '/tentang-kami/sejarah',               'label' => 'Sejarah'],
         ['href' => '/tentang-kami/struktur-organisasi',   'label' => 'Struktur Organisasi'],
         ['href' => '/tentang-kami/lokasi',                'label' => 'Lokasi Kantor'],
     ]],
    ['href' => '/manajemen',            'label' => 'Manajemen',    'key' => 'manajemen',
     'children' => [
         ['href' => '/manajemen/dewan-komisaris',          'label' => 'Dewan Komisaris'],
         ['href' => '/manajemen/dewan-direksi',            'label' => 'Dewan Direksi'],
         ['href' => '/manajemen/dewan-pengawas-syariah',   'label' => 'Dewan Pengawas Syariah'],
     ]],
    ['href' => '/produk',               'label' => 'Produk',       'key' => 'produk',
     'children' => [
         ['href' => '/produk/tabungan',    'label' => 'Tabungan'],
         ['href' => '/produk/deposito',    'label' => 'Deposito'],
         ['href' => '/produk/pembiayaan',  'label' => 'Pembiayaan'],
         ['href' => '/faq',               'label' => 'FAQ'],
     ]],
    ['href' => '/publikasi',            'label' => 'Publikasi',    'key' => 'publikasi',
     'children' => [
         ['href' => '/publikasi/laporan-keuangan',         'label' => 'Laporan Keuangan'],
         ['href' => '/publikasi/laporan-tata-kelola',      'label' => 'Laporan Tata Kelola'],
         ['href' => '/publikasi/laporan-tahunan',          'label' => 'Laporan Tahunan'],
         ['href' => '/publikasi/laporan-berkelanjutan',    'label' => 'Laporan Berkelanjutan'],
     ]],
    ['href' => '/berita',               'label' => 'Berita',       'key' => 'berita'],
    ['href' => '/lelang',               'label' => 'Lelang',       'key' => 'lelang'],
];
?>

<header class="sticky top-0 z-40 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-sm border-b border-gray-100 dark:border-gray-800" x-data="{ mobileMenu: false }">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-label="Navigasi utama">
        <div class="flex items-center justify-between h-16 lg:h-20">

            <!-- Logo -->
            <a href="/" class="flex items-center gap-3 flex-shrink-0" aria-label="<?= e($siteName) ?> - Halaman Utama">
                <?php if ($siteLogo): ?>
                    <img src="/uploads/<?= e($siteLogo) ?>" alt="Logo <?= e($siteName) ?>" class="h-10 w-auto">
                <?php else: ?>
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                        <span class="text-white font-heading font-bold text-sm">B</span>
                    </div>
                <?php endif; ?>
                <div class="hidden sm:block">
                    <p class="font-heading font-bold text-primary dark:text-primary-light text-sm leading-tight"><?= e($siteName) ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= e($settings['site_tagline'] ?? 'Bank Syariah') ?></p>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-1">
                <?php foreach ($navLinks as $link): ?>
                    <?php $isActive = ($active ?? '') === $link['key']; ?>

                    <?php if (!empty($link['children'])): ?>
                        <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button
                                @click="open = !open"
                                class="flex items-center gap-1 px-3 py-2 rounded-lg text-sm font-medium transition-colors <?= $isActive ? 'text-primary bg-primary/10' : 'text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-primary/5' ?>"
                                :aria-expanded="open.toString()"
                                aria-haspopup="true">
                                <?= e($link['label']) ?>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            <div
                                x-show="open"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="absolute top-full left-0 mt-1 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 py-2 z-50"
                                role="menu">
                                <?php foreach ($link['children'] as $child): ?>
                                    <a href="<?= e($child['href']) ?>"
                                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-primary/5 dark:hover:bg-primary/20 transition-colors"
                                       role="menuitem">
                                        <?= e($child['label']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= e($link['href']) ?>"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition-colors <?= $isActive ? 'text-primary bg-primary/10' : 'text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-primary/5' ?>">
                            <?= e($link['label']) ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-2">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode"
                    class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                    :aria-label="darkMode ? 'Mode terang' : 'Mode gelap'">
                    <i class="fas fa-sun text-sm" x-show="darkMode"></i>
                    <i class="fas fa-moon text-sm" x-show="!darkMode"></i>
                </button>

                <!-- CTA Button -->
                <a href="/hubungi-kami"
                   class="hidden sm:inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-phone-alt text-xs"></i>
                    Hubungi Kami
                </a>

                <!-- Mobile Menu Toggle -->
                <button @click="mobileMenu = !mobileMenu"
                    class="lg:hidden w-9 h-9 rounded-lg flex items-center justify-center text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                    :aria-expanded="mobileMenu.toString()"
                    aria-label="Toggle menu">
                    <i class="fas fa-bars text-sm" x-show="!mobileMenu"></i>
                    <i class="fas fa-times text-sm" x-show="mobileMenu"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="lg:hidden border-t border-gray-100 dark:border-gray-800 py-3 space-y-1"
            id="mobile-menu"
            role="navigation"
            aria-label="Navigasi mobile">

            <?php foreach ($navLinks as $link): ?>
                <?php $isActive = ($active ?? '') === $link['key']; ?>

                <?php if (!empty($link['children'])): ?>
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium <?= $isActive ? 'text-primary bg-primary/10' : 'text-gray-700 dark:text-gray-200' ?>">
                            <?= e($link['label']) ?>
                            <i class="fas fa-chevron-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" class="pl-4 mt-1 space-y-1">
                            <?php foreach ($link['children'] as $child): ?>
                                <a href="<?= e($child['href']) ?>"
                                   class="block px-4 py-2 rounded-lg text-sm text-gray-600 dark:text-gray-300 hover:text-primary hover:bg-primary/5">
                                    <?= e($child['label']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= e($link['href']) ?>"
                       class="block px-4 py-2.5 rounded-lg text-sm font-medium <?= $isActive ? 'text-primary bg-primary/10' : 'text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-primary/5' ?>">
                        <?= e($link['label']) ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>

            <div class="pt-2 px-4">
                <a href="/hubungi-kami"
                   class="block text-center bg-primary text-white px-4 py-2.5 rounded-lg text-sm font-medium">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </nav>
</header>
