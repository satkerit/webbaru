<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Tentang Kami','url'=>'/tentang-kami'],['label'=>'Struktur Organisasi']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Struktur Organisasi</h1>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>
<section class="py-12 lg:py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if ($page): ?>
            <div class="prose prose-lg max-w-none"><?= $page['content'] ?></div>
        <?php else: ?>
        <div class="text-center text-gray-500 py-12">
            <i class="fas fa-sitemap text-5xl text-gray-200 mb-4"></i>
            <p>Bagan struktur organisasi sedang dalam proses pembaruan.</p>
            <p class="text-sm mt-1">Silakan kunjungi kantor kami untuk informasi lebih lanjut.</p>
        </div>
        <?php endif; ?>
    </div>
</section>
