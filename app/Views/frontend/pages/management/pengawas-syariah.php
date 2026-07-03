<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Manajemen','url'=>'/manajemen'],['label'=>'Dewan Pengawas Syariah']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Dewan Pengawas Syariah</h1>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>
<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (empty($members)): ?>
        <div class="text-center py-16 text-gray-400"><i class="fas fa-users text-5xl mb-4 block text-gray-200"></i><p>Data sedang dalam proses pembaruan.</p></div>
        <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($members as $m): ?>
            <div class="card p-6 person-card text-center group" data-reveal>
                <?php if ($m['photo']): ?>
                    <img src="/uploads/management/<?= e($m['photo']) ?>" alt="<?= e($m['name']) ?>" class="avatar">
                <?php else: ?>
                    <div class="avatar-placeholder mx-auto"><?= e(mb_substr($m['name'],0,1)) ?></div>
                <?php endif; ?>
                <h3 class="font-heading font-semibold text-lg text-gray-900 dark:text-white mb-1 group-hover:text-primary transition-colors"><?= e($m['name']) ?></h3>
                <p class="text-sm text-secondary font-medium mb-3"><?= e($m['position']) ?></p>
                <?php if ($m['bio']): ?>
                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3"><?= e(make_excerpt($m['bio'],120)) ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
