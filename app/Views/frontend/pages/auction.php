<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Lelang Aset']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Lelang Aset</h1>
        <p class="text-white/80">Informasi lelang aset BPRS Bangka Belitung</p>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>

<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Info Notice -->
        <div class="bg-primary/5 dark:bg-primary/10 border border-primary/20 rounded-xl p-5 mb-8 flex items-start gap-4">
            <i class="fas fa-info-circle text-primary text-xl mt-0.5 flex-shrink-0"></i>
            <div>
                <h3 class="font-medium text-gray-900 dark:text-white mb-1">Informasi Lelang</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Untuk informasi lebih lanjut mengenai proses dan syarat lelang, silakan hubungi kami di 
                    <a href="/hubungi-kami" class="text-primary hover:underline">halaman kontak</a> 
                    atau datang langsung ke kantor BPRS Bangka Belitung.
                </p>
            </div>
        </div>

        <!-- Auctions Grid -->
        <?php if (empty($auctions)): ?>
        <div class="text-center py-16 text-gray-400">
            <i class="fas fa-gavel text-5xl mb-4 block text-gray-200"></i>
            <h3 class="font-medium text-gray-500 mb-1">Tidak Ada Lelang Aktif</h3>
            <p class="text-sm">Saat ini tidak ada aset yang sedang dilelang. Silakan cek kembali berkala.</p>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($auctions as $a): ?>
            <div class="card group overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all" data-reveal>
                <!-- Image -->
                <div class="aspect-video bg-gray-100 dark:bg-gray-700 overflow-hidden relative">
                    <?php if ($a['image']): ?>
                        <img src="/uploads/auctions/<?= e($a['image']) ?>" alt="<?= e($a['title']) ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600">
                            <i class="fas fa-home text-5xl text-gray-300 dark:text-gray-500"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Status Badge -->
                    <?php 
                    $statusClass = 'bg-green-500';
                    $statusLabel = 'Aktif';
                    if (($a['status'] ?? 'active') === 'closed') {
                        $statusClass = 'bg-red-500';
                        $statusLabel = 'Tutup';
                    } elseif (($a['status'] ?? 'active') === 'upcoming') {
                        $statusClass = 'bg-blue-500';
                        $statusLabel = 'Akan Datang';
                    }
                    ?>
                    <span class="absolute top-3 right-3 px-2.5 py-1 <?= $statusClass ?> text-white text-xs font-semibold rounded-full shadow">
                        <?= $statusLabel ?>
                    </span>
                </div>

                <div class="p-5">
                    <!-- Asset Type Badge -->
                    <span class="inline-block px-3 py-1 bg-secondary/10 text-secondary text-xs font-medium rounded-full mb-2">
                        <?= e($a['asset_type'] ?? 'Aset') ?>
                    </span>

                    <!-- Title -->
                    <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary transition-colors line-clamp-2">
                        <?= e($a['title']) ?>
                    </h3>

                    <!-- Location -->
                    <?php if (!empty($a['location'])): ?>
                    <p class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 mb-3">
                        <i class="fas fa-map-marker-alt text-xs text-primary"></i>
                        <?= e($a['location']) ?>
                    </p>
                    <?php endif; ?>

                    <!-- Starting Price -->
                    <div class="mb-3 p-3 bg-primary/5 dark:bg-primary/10 rounded-lg">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Harga Limit</p>
                        <p class="font-heading font-bold text-xl text-primary"><?= format_rupiah($a['starting_price']) ?></p>
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-2 gap-2 mb-4 text-xs text-gray-500 dark:text-gray-400">
                        <?php if (!empty($a['start_date'])): ?>
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Mulai</p>
                            <p><?= format_date($a['start_date']) ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($a['end_date'])): ?>
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Berakhir</p>
                            <p><?= format_date($a['end_date']) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Detail Link -->
                    <?php if (!empty($a['id'])): ?>
                    <a href="/lelang/<?= e($a['id']) ?>" class="flex items-center justify-center gap-2 w-full py-2.5 border border-primary text-primary hover:bg-primary hover:text-white rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-info-circle"></i>Detail Informasi
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
