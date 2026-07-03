<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Produk','url'=>'/produk'],['label'=>e($product['name'])]]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2"><?= e($product['name']) ?></h1>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>

<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Product Image/Icon -->
                <div class="card p-8 text-center">
                    <?php if ($product['image']): ?>
                        <img src="/uploads/products/<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>" class="max-w-md mx-auto rounded-lg shadow-lg">
                    <?php else: ?>
                        <?php 
                        $icon = 'fa-box';
                        if ($product['type'] === 'tabungan') $icon = 'fa-piggy-bank';
                        elseif ($product['type'] === 'deposito') $icon = 'fa-coins';
                        elseif ($product['type'] === 'pembiayaan') $icon = 'fa-hand-holding-usd';
                        ?>
                        <div class="w-32 h-32 bg-gradient-to-br from-primary to-primary-dark rounded-3xl flex items-center justify-center mx-auto">
                            <i class="fas <?= $icon ?> text-5xl text-white"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <div class="card p-6">
                    <h2 class="font-heading font-semibold text-2xl text-gray-900 dark:text-white mb-4">Deskripsi Produk</h2>
                    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                        <?= nl2br(e($product['description'])) ?>
                    </div>
                </div>

                <!-- Features -->
                <?php if (!empty($product['features'])): ?>
                <div class="card p-6" x-data="{ open: true }">
                    <button @click="open=!open" class="w-full flex items-center justify-between text-left">
                        <h2 class="font-heading font-semibold text-xl text-gray-900 dark:text-white">
                            <i class="fas fa-star text-secondary mr-2"></i>Keunggulan
                        </h2>
                        <i class="fas fa-chevron-down transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="mt-4">
                        <ul class="space-y-2">
                            <?php foreach (explode("\n", $product['features']) as $feature): ?>
                                <?php if (trim($feature)): ?>
                                <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-check-circle text-primary mt-1"></i>
                                    <span><?= e(trim($feature)) ?></span>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Requirements -->
                <?php if (!empty($product['requirements'])): ?>
                <div class="card p-6" x-data="{ open: false }">
                    <button @click="open=!open" class="w-full flex items-center justify-between text-left">
                        <h2 class="font-heading font-semibold text-xl text-gray-900 dark:text-white">
                            <i class="fas fa-file-alt text-secondary mr-2"></i>Persyaratan
                        </h2>
                        <i class="fas fa-chevron-down transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="mt-4">
                        <ul class="space-y-2">
                            <?php foreach (explode("\n", $product['requirements']) as $req): ?>
                                <?php if (trim($req)): ?>
                                <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-arrow-right text-primary mt-1"></i>
                                    <span><?= e(trim($req)) ?></span>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Benefits -->
                <?php if (!empty($product['benefits'])): ?>
                <div class="card p-6" x-data="{ open: false }">
                    <button @click="open=!open" class="w-full flex items-center justify-between text-left">
                        <h2 class="font-heading font-semibold text-xl text-gray-900 dark:text-white">
                            <i class="fas fa-gift text-secondary mr-2"></i>Manfaat
                        </h2>
                        <i class="fas fa-chevron-down transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="mt-4">
                        <ul class="space-y-2">
                            <?php foreach (explode("\n", $product['benefits']) as $benefit): ?>
                                <?php if (trim($benefit)): ?>
                                <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-thumbs-up text-primary mt-1"></i>
                                    <span><?= e(trim($benefit)) ?></span>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Product Type -->
                <div class="card p-6">
                    <div class="text-center">
                        <span class="inline-block px-4 py-2 bg-secondary/10 text-secondary font-semibold rounded-lg text-sm mb-3">
                            <?= e(ucfirst($product['type'])) ?>
                        </span>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Kategori Produk</p>
                    </div>
                </div>

                <!-- CTA Card -->
                <div class="card p-6 bg-gradient-to-br from-primary to-primary-dark text-white">
                    <i class="fas fa-rocket text-4xl mb-4 block text-white/80"></i>
                    <h3 class="font-heading font-semibold text-xl mb-2">Tertarik dengan Produk Ini?</h3>
                    <p class="text-sm text-white/90 mb-4">Hubungi kami untuk informasi lebih lanjut atau membuka rekening.</p>
                    <a href="/hubungi-kami" class="block w-full bg-white text-primary hover:bg-gray-50 text-center font-semibold py-3 rounded-lg transition-colors">
                        <i class="fas fa-phone-alt mr-2"></i>Hubungi Kami
                    </a>
                </div>

                <!-- Related Products -->
                <?php if (!empty($related_products)): ?>
                <div class="card p-6">
                    <h3 class="font-heading font-semibold text-lg text-gray-900 dark:text-white mb-4">Produk Lainnya</h3>
                    <div class="space-y-3">
                        <?php foreach ($related_products as $rp): ?>
                        <a href="/produk/<?= e($rp['slug']) ?>" class="block p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:shadow-md transition-shadow group">
                            <h4 class="font-medium text-gray-900 dark:text-white group-hover:text-primary text-sm mb-1"><?= e($rp['name']) ?></h4>
                            <span class="text-xs text-secondary"><?= e(ucfirst($rp['type'])) ?></span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
