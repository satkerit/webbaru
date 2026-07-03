<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Berita','url'=>'/berita'],['label'=>make_excerpt($article['title'],40)]]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-2xl md:text-3xl font-heading font-bold text-white mb-2 max-w-3xl"><?= e($article['title']) ?></h1>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>

<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Main Article -->
            <article class="flex-1 min-w-0">
                <!-- Featured Image -->
                <?php if ($article['image']): ?>
                <div class="rounded-2xl overflow-hidden mb-6 aspect-video bg-gray-100">
                    <img src="/uploads/articles/<?= e($article['image']) ?>" alt="<?= e($article['title']) ?>"
                         class="w-full h-full object-cover">
                </div>
                <?php endif; ?>

                <!-- Article Meta -->
                <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <?php if (!empty($article['category_name'])): ?>
                    <a href="/berita?kategori=<?= urlencode($article['category_slug'] ?? '') ?>"
                       class="inline-flex items-center gap-1.5 px-3 py-1 bg-secondary/10 text-secondary text-sm font-medium rounded-full">
                        <i class="fas fa-tag text-xs"></i>
                        <?= e($article['category_name']) ?>
                    </a>
                    <?php endif; ?>
                    <span class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-user-circle"></i>
                        <?= e($article['author_name'] ?? 'Admin') ?>
                    </span>
                    <span class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-calendar-alt"></i>
                        <?= format_date($article['published_at'] ?? $article['created_at']) ?>
                    </span>
                    <span class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-eye"></i>
                        <?= e($article['views'] ?? 0) ?> tayangan
                    </span>
                </div>

                <!-- Article Content -->
                <div class="prose dark:prose-invert prose-lg max-w-none text-gray-700 dark:text-gray-300 mb-8">
                    <?= $article['content'] ?>
                </div>

                <!-- Tags -->
                <?php if (!empty($article['tags'])): ?>
                <div class="flex flex-wrap items-center gap-2 pt-6 border-t border-gray-200 dark:border-gray-700 mb-8">
                    <span class="text-sm text-gray-500 dark:text-gray-400 mr-1">Tags:</span>
                    <?php foreach (explode(',', $article['tags']) as $tag): ?>
                    <?php if (trim($tag)): ?>
                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs rounded-full"><?= e(trim($tag)) ?></span>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Social Share -->
                <div class="card p-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3 text-sm">Bagikan Artikel Ini</h3>
                    <div class="flex flex-wrap gap-3">
                        <?php $shareUrl = urlencode('https://' . ($_SERVER['HTTP_HOST'] ?? 'bprs.id') . '/berita/' . $article['slug']); ?>
                        <?php $shareTitle = urlencode($article['title']); ?>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareUrl ?>" target="_blank" rel="noopener"
                           class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?= $shareUrl ?>&text=<?= $shareTitle ?>" target="_blank" rel="noopener"
                           class="flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm rounded-lg transition-colors">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="https://wa.me/?text=<?= $shareTitle ?>%20<?= $shareUrl ?>" target="_blank" rel="noopener"
                           class="flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm rounded-lg transition-colors">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <button onclick="navigator.clipboard.writeText(window.location.href); this.innerHTML='<i class=\'fas fa-check\'></i> Disalin!';" 
                                class="flex items-center gap-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 text-gray-700 dark:text-gray-300 text-sm rounded-lg transition-colors">
                            <i class="fas fa-link"></i> Salin Link
                        </button>
                    </div>
                </div>
            </article>

            <!-- Sidebar -->
            <aside class="w-full lg:w-72 xl:w-80 flex-shrink-0 space-y-6">
                <!-- Related Articles -->
                <?php if (!empty($related_articles)): ?>
                <div class="card p-5">
                    <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-4">Artikel Terkait</h3>
                    <div class="space-y-4">
                        <?php foreach ($related_articles as $ra): ?>
                        <a href="/berita/<?= e($ra['slug']) ?>" class="flex items-start gap-3 group">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden flex-shrink-0">
                                <?php if ($ra['image']): ?>
                                <img src="/uploads/articles/<?= e($ra['image']) ?>" alt="<?= e($ra['title']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center"><i class="fas fa-newspaper text-gray-400"></i></div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-primary line-clamp-2"><?= e($ra['title']) ?></h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?= format_date($ra['published_at'] ?? $ra['created_at']) ?></p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Categories -->
                <?php if (!empty($categories)): ?>
                <div class="card p-5">
                    <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-3">Kategori</h3>
                    <ul class="space-y-2">
                        <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="/berita?kategori=<?= urlencode($cat['slug']) ?>"
                               class="flex items-center justify-between text-sm text-gray-700 dark:text-gray-300 hover:text-primary transition-colors group py-1">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-folder text-xs text-gray-400 group-hover:text-primary transition-colors"></i>
                                    <?= e($cat['name']) ?>
                                </span>
                                <?php if (isset($cat['count'])): ?>
                                <span class="text-xs bg-gray-100 dark:bg-gray-700 rounded-full px-2 py-0.5"><?= $cat['count'] ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>
