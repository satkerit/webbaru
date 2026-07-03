<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Tentang Kami','url'=>'/tentang-kami'],['label'=>'Sejarah']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Sejarah Perusahaan</h1>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>
<section class="py-12 lg:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if ($page): ?>
            <div class="prose prose-lg max-w-none"><?= $page['content'] ?></div>
        <?php else: ?>
        <!-- Timeline default -->
        <div class="relative">
            <div class="absolute left-6 md:left-1/2 top-0 bottom-0 w-0.5 bg-primary/20 -translate-x-px"></div>
            <?php $milestones = [
                ['year'=>'Pendirian','desc'=>'BPRS Bangka Belitung resmi berdiri dengan izin dari Bank Indonesia, berkomitmen melayani masyarakat dengan prinsip syariah.'],
                ['year'=>'Pengembangan','desc'=>'Memperluas jaringan layanan dan memperkenalkan berbagai produk baru untuk memenuhi kebutuhan nasabah yang terus berkembang.'],
                ['year'=>'Inovasi','desc'=>'Mengadopsi teknologi terkini dalam operasional untuk meningkatkan efisiensi dan kualitas layanan kepada nasabah.'],
                ['year'=>'Pencapaian','desc'=>'Meraih berbagai penghargaan atas kinerja terbaik dan inovasi layanan perbankan syariah di Bangka Belitung.'],
                ['year'=>'Sekarang','desc'=>'Terus berkembang menjadi bank syariah terpercaya dengan komitmen memberikan layanan terbaik kepada seluruh nasabah.'],
            ]; ?>
            <?php foreach ($milestones as $i => $m): $isEven = $i % 2 === 0; ?>
            <div class="relative flex items-start gap-6 md:gap-8 mb-10 <?= $isEven ? 'md:flex-row' : 'md:flex-row-reverse' ?> pl-16 md:pl-0" data-reveal>
                <div class="hidden md:block md:w-1/2 <?= $isEven ? 'text-right pr-10' : 'text-left pl-10 md:col-start-2' ?>">
                    <?php if (!$isEven): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 inline-block text-left">
                        <h3 class="font-heading font-bold text-primary text-xl mb-2"><?= e($m['year']) ?></h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm"><?= e($m['desc']) ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- Dot -->
                <div class="absolute left-4 md:left-1/2 md:-translate-x-1/2 w-8 h-8 bg-primary rounded-full flex items-center justify-center border-4 border-white shadow z-10 flex-shrink-0">
                    <div class="w-2 h-2 bg-white rounded-full"></div>
                </div>
                <div class="md:w-1/2 <?= $isEven ? 'md:pl-10' : 'text-right md:pr-10' ?>">
                    <?php if ($isEven): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-gray-700 md:inline-block text-left">
                        <h3 class="font-heading font-bold text-primary text-xl mb-2"><?= e($m['year']) ?></h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm"><?= e($m['desc']) ?></p>
                    </div>
                    <?php endif; ?>
                    <!-- Mobile view -->
                    <div class="md:hidden bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="font-heading font-bold text-primary text-xl mb-2"><?= e($m['year']) ?></h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm"><?= e($m['desc']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
