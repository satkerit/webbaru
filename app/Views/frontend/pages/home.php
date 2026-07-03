<?php
/**
 * Homepage
 */
?>

<!-- Hero Slider -->
<?php if (!empty($sliders)): ?>
<section class="hero-slider relative h-[480px] md:h-[560px] lg:h-[640px]" data-hero-slider aria-label="Hero Banner">
    <?php foreach ($sliders as $i => $slide): ?>
        <div class="hero-slide <?= $i === 0 ? 'active' : '' ?>">
            <img src="/uploads/sliders/<?= e($slide['image']) ?>" alt="<?= e($slide['title']) ?>" class="w-full h-full object-cover">
            <div class="slide-overlay"></div>
            <div class="absolute inset-0 flex items-center">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="max-w-2xl text-white">
                        <?php if ($slide['subtitle']): ?>
                            <p class="section-label text-secondary-light animate-fade-up"><?= e($slide['subtitle']) ?></p>
                        <?php endif; ?>
                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-heading font-bold leading-tight mb-4 animate-fade-up delay-1">
                            <?= e($slide['title']) ?>
                        </h1>
                        <?php if ($slide['description']): ?>
                            <p class="text-base sm:text-lg text-gray-100 leading-relaxed mb-6 animate-fade-up delay-2">
                                <?= e($slide['description']) ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($slide['button_text'] && $slide['button_link']): ?>
                            <a href="<?= e($slide['button_link']) ?>"
                               class="btn btn-secondary inline-flex items-center gap-2 animate-fade-up delay-3">
                                <?= e($slide['button_text']) ?>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Controls (jika slider > 1) -->
    <?php if (count($sliders) > 1): ?>
        <!-- Navigation Arrows -->
        <button data-slider-prev
                class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-full flex items-center justify-center transition-all z-10"
                aria-label="Slide sebelumnya">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button data-slider-next
                class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-full flex items-center justify-center transition-all z-10"
                aria-label="Slide berikutnya">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        <!-- Dots -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-10 slider-dots" role="tablist" aria-label="Slider navigation">
            <?php foreach ($sliders as $i => $slide): ?>
                <button class="slider-dot <?= $i === 0 ? 'active' : '' ?>"
                        aria-label="Slide <?= $i + 1 ?>"
                        role="tab"
                        aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"></button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
<?php endif; ?>

<!-- Info Perusahaan -->
<section class="py-12 lg:py-16 bg-gray-50 dark:bg-gray-900" data-reveal>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <p class="section-label">Tentang Kami</p>
            <h2 class="section-title">PT. Bank Perekonomian Rakyat Syariah<br>Bangka Belitung</h2>
            <div class="section-divider mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <div>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                    BPRS Bangka Belitung adalah lembaga keuangan syariah yang berkomitmen memberikan layanan perbankan
                    sesuai prinsip syariah Islam. Kami hadir untuk mendukung perkembangan ekonomi masyarakat Bangka Belitung
                    melalui berbagai produk dan layanan yang inovatif dan terpercaya.
                </p>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                    Dengan tim profesional dan berpengalaman, kami terus berinovasi untuk memberikan solusi keuangan
                    yang sesuai dengan kebutuhan nasabah, sambil tetap menjaga nilai-nilai syariah.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="/tentang-kami/visi-misi" class="btn btn-primary">Selengkapnya</a>
                    <a href="/hubungi-kami" class="btn btn-outline">Hubungi Kami</a>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 gap-6">
                <div class="stat-item p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                    <div class="stat-number" data-counter data-target="500" data-suffix="+">0+</div>
                    <div class="stat-label">Nasabah Aktif</div>
                </div>
                <div class="stat-item p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                    <div class="stat-number" data-counter data-target="15" data-suffix="+">0+</div>
                    <div class="stat-label">Tahun Berpengalaman</div>
                </div>
                <div class="stat-item p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                    <div class="stat-number" data-counter data-target="50" data-suffix="M+">0M+</div>
                    <div class="stat-label">Total Aset</div>
                </div>
                <div class="stat-item p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                    <div class="stat-number" data-counter data-target="98" data-suffix="%">0%</div>
                    <div class="stat-label">Kepuasan Nasabah</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Produk Unggulan -->
<?php if (!empty($featured_products)): ?>
<section class="py-12 lg:py-16 bg-white dark:bg-gray-800" data-reveal>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <p class="section-label">Produk & Layanan</p>
            <h2 class="section-title">Produk Unggulan Kami</h2>
            <div class="section-divider mx-auto"></div>
            <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mt-4">
                Beragam produk dan layanan syariah yang dirancang untuk memenuhi kebutuhan finansial Anda
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach (array_slice($featured_products, 0, 6) as $product): ?>
                <div class="product-card group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 flex-shrink-0 bg-primary/10 group-hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
                            <svg class="w-6 h-6 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <?php if ($product['type'] === 'tabungan'): ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                <?php elseif ($product['type'] === 'deposito'): ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                <?php else: ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                <?php endif; ?>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-heading font-semibold text-lg text-gray-900 dark:text-white mb-2 group-hover:text-primary transition-colors">
                                <?= e($product['name']) ?>
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                                <?= e(make_excerpt($product['description'] ?? '', 100)) ?>
                            </p>
                            <a href="/produk/<?= e($product['slug']) ?>" class="text-sm font-medium text-primary hover:text-primary-dark inline-flex items-center gap-1 transition-colors">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-10">
            <a href="/produk" class="btn btn-primary">Lihat Semua Produk</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Berita Terbaru -->
<?php if (!empty($latest_articles)): ?>
<section class="py-12 lg:py-16 bg-gray-50 dark:bg-gray-900" data-reveal>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="section-label">Berita & Informasi</p>
                <h2 class="section-title">Berita Terbaru</h2>
                <div class="section-divider"></div>
            </div>
            <a href="/berita" class="hidden sm:inline-flex btn btn-ghost">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($latest_articles as $article): ?>
                <article class="card group">
                    <div class="card-image">
                        <img src="<?= $article['featured_image'] ? '/uploads/articles/' . e($article['featured_image']) : '/assets/images/placeholder-article.jpg' ?>"
                             alt="<?= e($article['title']) ?>"
                             class="lazy"
                             loading="lazy">
                    </div>
                    <div class="p-5">
                        <?php if ($article['category_name']): ?>
                            <span class="badge badge-primary mb-3"><?= e($article['category_name']) ?></span>
                        <?php endif; ?>
                        <h3 class="font-heading font-semibold text-lg text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                            <a href="/berita/<?= e($article['slug']) ?>"><?= e($article['title']) ?></a>
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                            <?= e($article['excerpt'] ?: make_excerpt($article['content'], 120)) ?>
                        </p>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <time datetime="<?= e($article['published_at']) ?>">
                                <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <?= format_date($article['published_at'], 'd M Y') ?>
                            </time>
                            <span>
                                <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <?= number_format($article['views']) ?> views
                            </span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-8 sm:hidden">
            <a href="/berita" class="btn btn-ghost">Lihat Semua Berita</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="py-16 lg:py-20 bg-gradient-to-br from-primary via-primary-dark to-primary-dark text-white relative overflow-hidden" data-reveal>
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-accent rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-3xl sm:text-4xl font-heading font-bold mb-4">
            Siap Bergabung dengan BPRS Bangka Belitung?
        </h2>
        <p class="text-lg text-gray-100 mb-8 max-w-2xl mx-auto">
            Mulai kelola keuangan Anda sesuai prinsip syariah bersama kami. Tim kami siap membantu Anda.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="/hubungi-kami" class="btn bg-white text-primary hover:bg-gray-100 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Hubungi Kami
            </a>
            <a href="/produk" class="btn btn-outline text-white border-white hover:bg-white hover:text-primary">
                Lihat Produk
            </a>
        </div>
    </div>
</section>
