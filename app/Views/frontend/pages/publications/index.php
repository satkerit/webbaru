<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Publikasi']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Publikasi</h1>
        <p class="text-white/80">Laporan keuangan dan informasi publik BPRS Bangka Belitung</p>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>

<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Category Cards -->
        <div class="mb-12">
            <h2 class="font-heading font-semibold text-2xl text-gray-900 dark:text-white mb-6 text-center">Kategori Laporan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Laporan Keuangan -->
                <a href="/publikasi/laporan-keuangan" class="card p-6 text-center group hover:shadow-xl hover:border-primary hover:-translate-y-1 transition-all">
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/40 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary group-hover:scale-110 transition-all">
                        <i class="fas fa-chart-line text-2xl text-blue-600 dark:text-blue-400 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-gray-900 dark:text-white group-hover:text-primary">Laporan Keuangan</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Laporan keuangan tahunan dan interim</p>
                </a>
                <!-- Laporan Tahunan -->
                <a href="/publikasi/laporan-tahunan" class="card p-6 text-center group hover:shadow-xl hover:border-primary hover:-translate-y-1 transition-all">
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900/40 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary group-hover:scale-110 transition-all">
                        <i class="fas fa-book text-2xl text-green-600 dark:text-green-400 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-gray-900 dark:text-white group-hover:text-primary">Laporan Tahunan</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Annual report & GCG</p>
                </a>
                <!-- Pengumuman -->
                <a href="/publikasi/pengumuman" class="card p-6 text-center group hover:shadow-xl hover:border-primary hover:-translate-y-1 transition-all">
                    <div class="w-14 h-14 bg-yellow-100 dark:bg-yellow-900/40 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary group-hover:scale-110 transition-all">
                        <i class="fas fa-bullhorn text-2xl text-yellow-600 dark:text-yellow-400 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-gray-900 dark:text-white group-hover:text-primary">Pengumuman</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Pengumuman resmi perusahaan</p>
                </a>
                <!-- Produk Hukum -->
                <a href="/publikasi/produk-hukum" class="card p-6 text-center group hover:shadow-xl hover:border-primary hover:-translate-y-1 transition-all">
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/40 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary group-hover:scale-110 transition-all">
                        <i class="fas fa-gavel text-2xl text-red-600 dark:text-red-400 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-gray-900 dark:text-white group-hover:text-primary">Produk Hukum</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Peraturan dan kebijakan internal</p>
                </a>
            </div>
        </div>

        <!-- Recent Publications -->
        <?php if (!empty($publications)): ?>
        <div>
            <h2 class="font-heading font-semibold text-2xl text-gray-900 dark:text-white mb-6">Publikasi Terbaru</h2>
            <div class="card overflow-hidden">
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    <?php foreach ($publications as $pub): ?>
                    <div class="flex items-center justify-between p-5 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-file-pdf text-primary"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white text-sm"><?= e($pub['title']) ?></h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    <span class="capitalize"><?= e($pub['type']) ?></span> &middot; <?= e($pub['year']) ?>
                                    <?php if ($pub['quarter']): ?> &middot; Kuartal <?= e($pub['quarter']) ?><?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <a href="/publikasi/download/<?= e($pub['id']) ?>" class="flex-shrink-0 inline-flex items-center gap-2 text-sm text-primary hover:text-primary-dark font-medium">
                            <i class="fas fa-download"></i>
                            <span class="hidden sm:inline">Unduh</span>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>
