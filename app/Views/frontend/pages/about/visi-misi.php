<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Tentang Kami','url'=>'/tentang-kami'],['label'=>'Visi & Misi']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Visi & Misi</h1>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>

<section class="py-12 lg:py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if ($page): ?>
            <div class="prose prose-lg max-w-none"><?= $page['content'] ?></div>
        <?php else: ?>
        <!-- Default content -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="bg-gradient-to-br from-primary to-primary-light rounded-2xl p-8 text-white" data-reveal>
                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mb-5">
                    <i class="fas fa-eye text-2xl text-white"></i>
                </div>
                <h2 class="text-2xl font-heading font-bold mb-4">Visi</h2>
                <p class="text-green-50 leading-relaxed text-lg">
                    Menjadi Bank Perekonomian Rakyat Syariah yang terpercaya, profesional, dan terdepan dalam memberikan
                    layanan keuangan syariah yang berkualitas di Bangka Belitung.
                </p>
            </div>
            <div class="bg-gradient-to-br from-secondary to-secondary-dark rounded-2xl p-8 text-white" data-reveal>
                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mb-5">
                    <i class="fas fa-rocket text-2xl text-white"></i>
                </div>
                <h2 class="text-2xl font-heading font-bold mb-4">Misi</h2>
                <ul class="text-yellow-50 space-y-3">
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg><span>Memberikan layanan perbankan syariah yang berkualitas tinggi</span></li>
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg><span>Mendukung pertumbuhan ekonomi masyarakat Bangka Belitung</span></li>
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg><span>Menjalankan prinsip-prinsip syariah secara konsisten</span></li>
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg><span>Mengembangkan sumber daya manusia yang profesional</span></li>
                </ul>
            </div>
        </div>

        <!-- Nilai-Nilai -->
        <div data-reveal>
            <h2 class="section-title text-center mb-2">Nilai-Nilai Perusahaan</h2>
            <div class="section-divider mx-auto mb-8"></div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <?php foreach ([
                    ['icon'=>'fa-handshake','label'=>'Amanah','desc'=>'Jujur dan dapat dipercaya'],
                    ['icon'=>'fa-star','label'=>'Profesional','desc'=>'Kompeten dan berdedikasi'],
                    ['icon'=>'fa-heart','label'=>'Peduli','desc'=>'Melayani dengan sepenuh hati'],
                    ['icon'=>'fa-leaf','label'=>'Islami','desc'=>'Berlandaskan nilai syariah'],
                ] as $v): ?>
                <div class="text-center p-5 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas <?= e($v['icon']) ?> text-2xl text-primary"></i>
                    </div>
                    <h4 class="font-heading font-semibold text-gray-900 dark:text-white mb-1"><?= e($v['label']) ?></h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400"><?= e($v['desc']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
