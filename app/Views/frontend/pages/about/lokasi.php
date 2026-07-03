<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Tentang Kami','url'=>'/tentang-kami'],['label'=>'Lokasi Kantor']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Lokasi Kantor</h1>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>
<section class="py-12 lg:py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-xl font-heading font-bold text-gray-900 dark:text-white mb-5">Kantor Pusat</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-map-marker-alt text-primary"></i></div>
                        <div><p class="font-medium text-gray-900 dark:text-white">Alamat</p><p class="text-gray-600 dark:text-gray-300 text-sm mt-0.5"><?= e($settings['address'] ?? 'Pangkalpinang, Bangka Belitung') ?></p></div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-phone text-primary"></i></div>
                        <div><p class="font-medium text-gray-900 dark:text-white">Telepon</p><a href="tel:<?= e(preg_replace('/\D/','',$settings['phone']??'')) ?>" class="text-gray-600 dark:text-gray-300 text-sm mt-0.5 hover:text-primary"><?= e($settings['phone'] ?? '-') ?></a></div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-envelope text-primary"></i></div>
                        <div><p class="font-medium text-gray-900 dark:text-white">Email</p><a href="mailto:<?= e($settings['email']??'') ?>" class="text-gray-600 dark:text-gray-300 text-sm mt-0.5 hover:text-primary"><?= e($settings['email'] ?? '-') ?></a></div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-clock text-primary"></i></div>
                        <div><p class="font-medium text-gray-900 dark:text-white">Jam Operasional</p><p class="text-gray-600 dark:text-gray-300 text-sm mt-0.5">Senin – Jumat: 08.00 – 15.30 WIB</p><p class="text-gray-600 dark:text-gray-300 text-sm">Sabtu: 08.00 – 12.00 WIB</p></div>
                    </div>
                </div>
            </div>
            <!-- Map placeholder -->
            <div class="bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden h-72 flex items-center justify-center border border-gray-200 dark:border-gray-700">
                <div class="text-center text-gray-400">
                    <i class="fas fa-map-marked-alt text-4xl mb-3"></i>
                    <p class="text-sm">Peta Lokasi</p>
                    <a href="https://maps.google.com?q=Pangkalpinang+Bangka+Belitung" target="_blank" rel="noopener noreferrer" class="btn btn-primary mt-3 text-xs">Buka di Google Maps</a>
                </div>
            </div>
        </div>
    </div>
</section>
