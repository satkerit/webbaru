<?php
$breadcrumbs = [['label'=>'Beranda','url'=>'/'], ['label'=>'Tentang Kami']];
?>
<!-- Page Header -->
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Tentang Kami</h1>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>

<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php $cards = [
                ['icon'=>'fa-bullseye','href'=>'/tentang-kami/visi-misi','label'=>'Visi & Misi','desc'=>'Visi, misi, dan nilai-nilai perusahaan'],
                ['icon'=>'fa-history','href'=>'/tentang-kami/sejarah','label'=>'Sejarah Perusahaan','desc'=>'Perjalanan dan pencapaian kami'],
                ['icon'=>'fa-sitemap','href'=>'/tentang-kami/struktur-organisasi','label'=>'Struktur Organisasi','desc'=>'Bagan organisasi dan tata kelola'],
                ['icon'=>'fa-map-marker-alt','href'=>'/tentang-kami/lokasi','label'=>'Lokasi Kantor','desc'=>'Temukan kantor kami di Bangka Belitung'],
            ]; ?>
            <?php foreach ($cards as $card): ?>
            <a href="<?= e($card['href']) ?>" class="card p-6 hover:border-primary group">
                <div class="w-12 h-12 bg-primary/10 group-hover:bg-primary rounded-xl flex items-center justify-center mb-4 transition-colors">
                    <i class="fas <?= e($card['icon']) ?> text-primary group-hover:text-white transition-colors text-xl"></i>
                </div>
                <h3 class="font-heading font-semibold text-lg text-gray-900 dark:text-white mb-1 group-hover:text-primary transition-colors"><?= e($card['label']) ?></h3>
                <p class="text-sm text-gray-500 dark:text-gray-400"><?= e($card['desc']) ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
