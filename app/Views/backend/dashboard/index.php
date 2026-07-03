<?php
/**
 * Dashboard Overview
 * Requires: $auth_user, $stats (array), $recent_articles, $recent_messages, $quick_links
 */
?>

<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-primary to-primary-light rounded-2xl p-6 mb-6 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-heading font-bold text-2xl mb-1">
                Selamat datang, <?= e($auth_user['name'] ?? 'Admin') ?>!
            </h1>
            <p class="text-white/80 text-sm">
                <?= date('l, d F Y') ?> &middot; <?= e($auth_user['role_name'] ?? 'Administrator') ?>
            </p>
        </div>
        <div class="hidden md:block w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
            <i class="fas fa-mosque text-white text-2xl"></i>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
    <!-- Pengunjung Hari Ini -->
    <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-eye text-xl text-blue-600"></i>
            </div>
            <?php if (isset($stats['visitors_change'])): ?>
            <span class="text-xs font-medium px-2 py-1 rounded-full <?= $stats['visitors_change'] >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' ?>">
                <?= $stats['visitors_change'] >= 0 ? '+' : '' ?><?= $stats['visitors_change'] ?>%
            </span>
            <?php endif; ?>
        </div>
        <p class="font-heading font-bold text-3xl text-gray-900 mb-1"><?= number_format($stats['visitors_today'] ?? 0) ?></p>
        <p class="text-sm text-gray-500">Pengunjung Hari Ini</p>
    </div>

    <!-- Total Artikel -->
    <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                <i class="fas fa-newspaper text-xl text-primary"></i>
            </div>
            <?php if (!empty($stats['articles_draft'])): ?>
            <span class="text-xs font-medium px-2 py-1 rounded-full bg-yellow-100 text-yellow-700">
                <?= $stats['articles_draft'] ?> draft
            </span>
            <?php endif; ?>
        </div>
        <p class="font-heading font-bold text-3xl text-gray-900 mb-1"><?= number_format($stats['articles_published'] ?? 0) ?></p>
        <p class="text-sm text-gray-500">Artikel Terbit</p>
    </div>

    <!-- Pesan Belum Dibaca -->
    <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-envelope text-xl text-orange-600"></i>
            </div>
            <?php if (!empty($stats['messages_unread'])): ?>
            <span class="text-xs font-medium px-2 py-1 rounded-full bg-red-100 text-red-700 animate-pulse">
                Baru!
            </span>
            <?php endif; ?>
        </div>
        <p class="font-heading font-bold text-3xl text-gray-900 mb-1"><?= number_format($stats['messages_unread'] ?? 0) ?></p>
        <p class="text-sm text-gray-500">Pesan Belum Dibaca</p>
    </div>

    <!-- Laporan Whistleblow -->
    <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-bullhorn text-xl text-red-600"></i>
            </div>
            <?php if (!empty($stats['whistleblows_new'])): ?>
            <span class="text-xs font-medium px-2 py-1 rounded-full bg-red-100 text-red-700">
                <?= $stats['whistleblows_new'] ?> baru
            </span>
            <?php endif; ?>
        </div>
        <p class="font-heading font-bold text-3xl text-gray-900 mb-1"><?= number_format($stats['whistleblows_total'] ?? 0) ?></p>
        <p class="text-sm text-gray-500">Laporan Whistleblow</p>
    </div>
</div>

<!-- Recent Articles + Quick Links -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <!-- Recent Articles Table (2/3 width) -->
    <div class="xl:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-heading font-semibold text-gray-900">Artikel Terbaru</h3>
                <a href="/admin/artikel" class="text-sm text-primary hover:text-primary-dark font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php if (empty($recent_articles)): ?>
            <div class="px-6 py-10 text-center text-gray-400">
                <i class="fas fa-newspaper text-3xl mb-2 block text-gray-200"></i>
                <p class="text-sm">Belum ada artikel</p>
            </div>
            <?php else: ?>
            <div class="overflow-x-auto">
                <table class="admin-table w-full">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th class="hidden md:table-cell">Kategori</th>
                            <th class="hidden sm:table-cell">Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_articles as $art): ?>
                        <tr>
                            <td>
                                <a href="/admin/artikel/<?= e($art['id']) ?>/edit" class="font-medium text-gray-900 hover:text-primary line-clamp-1"><?= e($art['title']) ?></a>
                            </td>
                            <td class="hidden md:table-cell text-gray-500 text-sm"><?= e($art['category_name'] ?? '-') ?></td>
                            <td class="hidden sm:table-cell text-gray-500 text-sm"><?= format_date($art['created_at']) ?></td>
                            <td>
                                <?php 
                                $statusClass = $art['status'] === 'published' ? 'badge-success' : 'badge-warning';
                                $statusLabel = $art['status'] === 'published' ? 'Terbit' : 'Draft';
                                ?>
                                <span class="<?= $statusClass ?>"><?= $statusLabel ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Links (1/3 width) -->
    <div class="space-y-4">
        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-heading font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-3">
                <?php
                $quickLinks = [
                    ['href' => '/admin/artikel/tambah', 'icon' => 'fa-plus', 'label' => 'Tulis Artikel', 'color' => 'primary'],
                    ['href' => '/admin/produk/tambah', 'icon' => 'fa-box', 'label' => 'Tambah Produk', 'color' => 'blue'],
                    ['href' => '/admin/pesan', 'icon' => 'fa-envelope', 'label' => 'Baca Pesan', 'color' => 'orange'],
                    ['href' => '/admin/publikasi/tambah', 'icon' => 'fa-file-upload', 'label' => 'Upload Laporan', 'color' => 'green'],
                ];
                foreach ($quickLinks as $ql):
                $colorMap = ['primary' => 'bg-primary/10 text-primary hover:bg-primary hover:text-white', 'blue' => 'bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white', 'orange' => 'bg-orange-100 text-orange-600 hover:bg-orange-500 hover:text-white', 'green' => 'bg-green-100 text-green-600 hover:bg-green-500 hover:text-white'];
                $cc = $colorMap[$ql['color']] ?? 'bg-gray-100 text-gray-600';
                ?>
                <a href="<?= $ql['href'] ?>" class="flex flex-col items-center justify-center p-4 rounded-xl transition-all gap-2 group <?= $cc ?>">
                    <i class="fas <?= $ql['icon'] ?> text-xl"></i>
                    <span class="text-xs font-medium text-center leading-tight"><?= $ql['label'] ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- System Info -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-heading font-semibold text-gray-900 mb-3">Info Sistem</h3>
            <div class="space-y-2.5 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">PHP Version</span>
                    <span class="font-medium text-gray-900"><?= phpversion() ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Last Login</span>
                    <span class="font-medium text-gray-900"><?= e($auth_user['last_login'] ? format_date($auth_user['last_login']) : 'Sekarang') ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Server Time</span>
                    <span class="font-medium text-gray-900"><?= date('H:i') ?></span>
                </div>
            </div>
        </div>
    </div>

</div>
