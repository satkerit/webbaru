<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Lowongan Kerja']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Lowongan Kerja</h1>
        <p class="text-white/80">Bergabunglah bersama tim kami</p>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>

<section class="py-12 lg:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Why Join Us -->
        <div class="card p-6 md:p-8 mb-10">
            <h2 class="font-heading font-semibold text-2xl text-gray-900 dark:text-white mb-4">Mengapa Bergabung dengan Kami?</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="flex items-start gap-3 p-4 bg-primary/5 dark:bg-primary/10 rounded-xl">
                    <i class="fas fa-graduation-cap text-xl text-primary flex-shrink-0 mt-1"></i>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white text-sm mb-1">Pengembangan Karir</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Program pelatihan & pengembangan berkelanjutan</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-4 bg-primary/5 dark:bg-primary/10 rounded-xl">
                    <i class="fas fa-hand-holding-heart text-xl text-primary flex-shrink-0 mt-1"></i>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white text-sm mb-1">Lingkungan Syariah</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Bekerja sesuai nilai-nilai syariah Islam</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-4 bg-primary/5 dark:bg-primary/10 rounded-xl">
                    <i class="fas fa-star text-xl text-primary flex-shrink-0 mt-1"></i>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white text-sm mb-1">Benefit Kompetitif</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Gaji & tunjangan yang kompetitif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Listings -->
        <h2 class="font-heading font-semibold text-2xl text-gray-900 dark:text-white mb-6">Posisi yang Tersedia</h2>

        <?php if (empty($careers)): ?>
        <div class="text-center py-16 text-gray-400">
            <i class="fas fa-briefcase text-5xl mb-4 block text-gray-200"></i>
            <h3 class="font-medium text-gray-500 mb-1">Tidak Ada Lowongan Saat Ini</h3>
            <p class="text-sm">Saat ini tidak ada lowongan yang tersedia. Silakan pantau halaman ini secara berkala.</p>
            <a href="/hubungi-kami" class="inline-flex items-center gap-2 mt-4 text-sm text-primary hover:text-primary-dark">
                <i class="fas fa-envelope"></i>Kirim CV Anda ke kami
            </a>
        </div>
        <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($careers as $c): ?>
            <div class="card p-5 md:p-6 group hover:shadow-lg hover:border-primary/30 transition-all" data-reveal>
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <!-- Employment Type Badge -->
                            <?php 
                            $typeClass = 'bg-primary/10 text-primary';
                            $typeLabel = ucfirst($c['employment_type'] ?? 'full-time');
                            if (($c['employment_type'] ?? '') === 'part-time') $typeClass = 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400';
                            elseif (($c['employment_type'] ?? '') === 'kontrak') $typeClass = 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400';
                            elseif (($c['employment_type'] ?? '') === 'magang') $typeClass = 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400';
                            ?>
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full <?= $typeClass ?>">
                                <?= e($typeLabel) ?>
                            </span>
                        </div>
                        <h3 class="font-heading font-semibold text-lg text-gray-900 dark:text-white group-hover:text-primary transition-colors mb-1">
                            <?= e($c['title']) ?>
                        </h3>
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                            <?php if (!empty($c['department'])): ?>
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-building text-xs text-primary"></i>
                                <?= e($c['department']) ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($c['location'])): ?>
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-map-marker-alt text-xs text-primary"></i>
                                <?= e($c['location']) ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($c['deadline'])): ?>
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-calendar-alt text-xs text-primary"></i>
                                Batas: <?= format_date($c['deadline']) ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($c['description'])): ?>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
                            <?= e(make_excerpt($c['description'], 150)) ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="/karir/<?= e($c['id']) ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-lg transition-colors">
                            Lamar Sekarang <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Contact CTA -->
        <div class="mt-10 p-6 bg-primary/5 dark:bg-primary/10 rounded-2xl text-center">
            <p class="text-gray-600 dark:text-gray-400 mb-3">Tidak menemukan posisi yang sesuai?</p>
            <a href="mailto:<?= e($contact_email ?? 'hrd@bprsbabel.com') ?>" class="inline-flex items-center gap-2 text-sm text-primary hover:text-primary-dark font-medium">
                <i class="fas fa-envelope"></i>Kirim CV Spontan ke <?= e($contact_email ?? 'hrd@bprsbabel.com') ?>
            </a>
        </div>
    </div>
</section>
