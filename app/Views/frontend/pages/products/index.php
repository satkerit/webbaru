<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Produk & Layanan']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Produk & Layanan</h1>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>
<section class="py-12 lg:py-16" x-data="{ activeTab: 'semua' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Tab Navigation -->
        <div class="flex flex-wrap gap-3 mb-8 justify-center">
            <button @click="activeTab='semua'" :class="activeTab==='semua' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300'" class="px-6 py-2.5 rounded-lg font-medium transition-all hover:shadow-md">
                <i class="fas fa-th-large mr-2"></i>Semua Produk
            </button>
            <button @click="activeTab='tabungan'" :class="activeTab==='tabungan' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300'" class="px-6 py-2.5 rounded-lg font-medium transition-all hover:shadow-md">
                <i class="fas fa-piggy-bank mr-2"></i>Tabungan
            </button>
            <button @click="activeTab='deposito'" :class="activeTab==='deposito' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300'" class="px-6 py-2.5 rounded-lg font-medium transition-all hover:shadow-md">
                <i class="fas fa-coins mr-2"></i>Deposito
            </button>
            <button @click="activeTab='pembiayaan'" :class="activeTab==='pembiayaan' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300'" class="px-6 py-2.5 rounded-lg font-medium transition-all hover:shadow-md">
                <i class="fas fa-hand-holding-usd mr-2"></i>Pembiayaan
            </button>
        </div>

        <!-- Product Grid -->
        <?php if (empty($products)): ?>
        <div class="text-center py-16 text-gray-400">
            <i class="fas fa-box-open text-5xl mb-4 block text-gray-200"></i>
            <p>Produk sedang dalam proses pembaruan.</p>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($products as $p): ?>
            <div class="card p-6 group hover:shadow-xl transition-shadow" data-reveal 
                 x-show="activeTab==='semua' || activeTab==='<?= e($p['type']) ?>'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100">
                
                <!-- Icon -->
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-primary-dark rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <?php 
                    $icon = 'fa-box';
                    if ($p['type'] === 'tabungan') $icon = 'fa-piggy-bank';
                    elseif ($p['type'] === 'deposito') $icon = 'fa-coins';
                    elseif ($p['type'] === 'pembiayaan') $icon = 'fa-hand-holding-usd';
                    ?>
                    <i class="fas <?= $icon ?> text-2xl text-white"></i>
                </div>

                <!-- Type Badge -->
                <span class="inline-block px-3 py-1 text-xs font-medium bg-secondary/10 text-secondary rounded-full mb-3">
                    <?= e(ucfirst($p['type'])) ?>
                </span>

                <!-- Name -->
                <h3 class="font-heading font-semibold text-xl text-gray-900 dark:text-white mb-2 group-hover:text-primary transition-colors">
                    <?= e($p['name']) ?>
                </h3>

                <!-- Description Excerpt -->
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                    <?= e(make_excerpt($p['description'], 120)) ?>
                </p>

                <!-- Link -->
                <a href="/produk/<?= e($p['slug']) ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm group-hover:gap-2 transition-all">
                    Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
