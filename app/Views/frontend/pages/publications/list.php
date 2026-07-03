<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Publikasi','url'=>'/publikasi'],['label'=>e($type_label ?? 'Daftar Publikasi')]]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2"><?= e($type_label ?? 'Daftar Publikasi') ?></h1>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>

<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Filter Bar -->
        <div class="flex flex-wrap items-center gap-3 mb-6">
            <span class="text-sm text-gray-500 dark:text-gray-400">Filter:</span>
            <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
            <a href="?year=<?= $y ?>" class="px-3 py-1.5 text-sm rounded-lg transition-colors <?= ($year_filter ?? '') == $y ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50' ?>">
                <?= $y ?>
            </a>
            <?php endfor; ?>
            <?php if (!empty($year_filter)): ?>
            <a href="?" class="px-3 py-1.5 text-sm rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors">
                <i class="fas fa-times mr-1"></i>Reset
            </a>
            <?php endif; ?>
        </div>

        <!-- Table -->
        <?php if (empty($publications)): ?>
        <div class="text-center py-16 text-gray-400">
            <i class="fas fa-folder-open text-5xl mb-4 block text-gray-200"></i>
            <h3 class="font-medium text-gray-500 mb-1">Belum Ada Publikasi</h3>
            <p class="text-sm">Data publikasi untuk kategori ini belum tersedia.</p>
        </div>
        <?php else: ?>
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <th class="px-5 py-4 text-left font-semibold text-gray-700 dark:text-gray-300 w-8">#</th>
                            <th class="px-5 py-4 text-left font-semibold text-gray-700 dark:text-gray-300">Judul</th>
                            <th class="px-5 py-4 text-left font-semibold text-gray-700 dark:text-gray-300">Tahun</th>
                            <th class="px-5 py-4 text-left font-semibold text-gray-700 dark:text-gray-300">Kuartal</th>
                            <th class="px-5 py-4 text-left font-semibold text-gray-700 dark:text-gray-300">Ukuran</th>
                            <th class="px-5 py-4 text-center font-semibold text-gray-700 dark:text-gray-300">Unduh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        <?php foreach ($publications as $i => $pub): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-5 py-4 text-gray-500 dark:text-gray-400"><?= $i + 1 ?></td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-file-pdf text-red-500 text-lg flex-shrink-0"></i>
                                    <span class="font-medium text-gray-900 dark:text-white"><?= e($pub['title']) ?></span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-gray-600 dark:text-gray-400"><?= e($pub['year']) ?></td>
                            <td class="px-5 py-4 text-gray-600 dark:text-gray-400">
                                <?= $pub['quarter'] ? 'Q' . e($pub['quarter']) : '-' ?>
                            </td>
                            <td class="px-5 py-4 text-gray-600 dark:text-gray-400">
                                <?= $pub['file_size'] ? e($pub['file_size']) : '-' ?>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <a href="/publikasi/download/<?= e($pub['id']) ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary-dark text-white text-xs font-medium rounded-lg transition-colors">
                                    <i class="fas fa-download"></i>Unduh
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>
