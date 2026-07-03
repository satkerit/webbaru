<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Berita & Artikel']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Berita & Artikel</h1>
        <p class="text-white/80">Informasi terkini seputar BPRS Bangka Belitung</p>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>

<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Category Filter Tabs -->
                <?php if (!empty($categories)): ?>
                <div class="flex flex-wrap gap-2 mb-8">
                    <a href="/berita" class="px-4 py-2 rounded-full text-sm font-medium transition-colors <?= empty($current_category) ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100' ?>">
                        Semua
                    </a>
                    <?php foreach ($categories as $cat): ?>
                    <a href="/berita?kategori=<?= urlencode($cat['slug']) ?>" 
                       class="px-4 py-2 rounded-full text-sm font-medium transition-colors <?= ($current_category ?? '') === $cat['slug'] ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100' ?>">
                        <?= e($cat['name']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Articles Grid -->
                <?php if (empty($articles)): ?>
                <div class="text-center py-16 text-gray-400">
                    <i class="fas fa-newspaper text-5xl mb-4 block text-gray-200"></i>
                    <h3 class="font-medium text-gray-500 mb-1">Belum Ada Artikel</h3>
                    <p class="text-sm">Artikel untuk kategori ini belum tersedia.</p>
                </div>
                <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <?php foreach ($articles as $article): ?>
                    <article class="card group overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all" data-reveal>
                        <!-- Featured Image -->
                        <a href="/berita/<?= e($article['slug']) ?>" class="block overflow-hidden aspect-video bg-gray-100 dark:bg-gray-700">
                            <?php if ($article['image']): ?>
                            <img src="/uploads/articles/<?= e($article['image']) ?>" alt="<?= e($article['title']) ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/20 to-primary/5">
                                <i class="fas fa-newspaper text-4xl text-primary/30"></i>
                            </div>
                            <?php endif; ?>
                        </a>

                        <div class="p-5">
                            <!-- Category Badge -->
                            <?php if (!empty($article['category_name'])): ?>
                            <a href="/berita?kategori=<?= urlencode($article['category_slug'] ?? '') ?>"
                               class="inline-block px-3 py-1 bg-secondary/10 text-secondary text-xs font-medium rounded-full mb-3">
                                <?= e($article['category_name']) ?>
                            </a>
                            <?php endif; ?>

                            <!-- Title -->
                            <h2 class="font-heading font-semibold text-gray-900 dark:text-white mb-2 leading-snug group-hover:text-primary transition-colors line-clamp-2">
                                <a href="/berita/<?= e($article['slug']) ?>"><?= e($article['title']) ?></a>
                            </h2>

                            <!-- Excerpt -->
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                <?= e(make_excerpt($article['excerpt'] ?? $article['content'] ?? '', 120)) ?>
                            </p>

                            <!-- Meta -->
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700 pt-3">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-calendar-alt"></i>
                                        <?= format_date($article['published_at'] ?? $article['created_at']) ?>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-eye"></i>
                                        <?= e($article['views'] ?? 0) ?>
                                    </span>
                                </div>
                                <a href="/berita/<?= e($article['slug']) ?>" class="text-primary hover:text-primary-dark font-medium">
                                    Baca <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if (!empty($pagination)): ?>
                <div class="mt-10">
                    <?php require APP_PATH . '/Views/frontend/components/pagination.php'; ?>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <aside class="w-full lg:w-72 xl:w-80 space-y-6 flex-shrink-0">
                <!-- Search -->
                <div class="card p-5">
                    <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-3">Cari Artikel</h3>
                    <form action="/berita" method="GET">
                        <div class="relative">
                            <input type="text" name="q" value="<?= e($_GET['q'] ?? '') ?>" placeholder="Kata kunci..."
                                   class="w-full pl-4 pr-10 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary">
                                <i class="fas fa-search text-sm"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Categories -->
                <?php if (!empty($categories)): ?>
                <div class="card p-5">
                    <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-3">Kategori</h3>
                    <ul class="space-y-2">
                        <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="/berita?kategori=<?= urlencode($cat['slug']) ?>" 
                               class="flex items-center justify-between text-sm text-gray-700 dark:text-gray-300 hover:text-primary transition-colors group">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-tag text-xs text-gray-400 group-hover:text-primary"></i>
                                    <?= e($cat['name']) ?>
                                </span>
                                <?php if (isset($cat['count'])): ?>
                                <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-500 rounded-full px-2 py-0.5"><?= $cat['count'] ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Popular Articles -->
                <?php if (!empty($popular_articles)): ?>
                <div class="card p-5">
                    <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-3">Artikel Populer</h3>
                    <div class="space-y-3">
                        <?php foreach ($popular_articles as $i => $pa): ?>
                        <div class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-7 h-7 bg-primary/10 text-primary text-xs font-bold rounded-lg flex items-center justify-center"><?= $i+1 ?></span>
                            <a href="/berita/<?= e($pa['slug']) ?>" class="text-sm text-gray-700 dark:text-gray-300 hover:text-primary line-clamp-2"><?= e($pa['title']) ?></a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>
