<?php
$siteName   = $settings['site_name'] ?? 'BPRS Bangka Belitung';
$phone      = $settings['phone'] ?? '0717-9103567';
$email      = $settings['email'] ?? 'customercare@bprsbabel.id';
$address    = $settings['address'] ?? 'Bangka Belitung';
$facebook   = $settings['facebook_url'] ?? '#';
$instagram  = $settings['instagram_url'] ?? '#';
$youtube    = $settings['youtube_url'] ?? '#';
$footerText = $settings['footer_text'] ?? $siteName;
?>

<footer class="bg-gray-900 text-white mt-auto" role="contentinfo">
    <!-- Main Footer -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">

            <!-- Kolom 1: Info Perusahaan -->
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                        <span class="text-white font-heading font-bold text-sm">B</span>
                    </div>
                    <div>
                        <p class="font-heading font-bold text-white text-sm leading-tight"><?= e($siteName) ?></p>
                        <p class="text-xs text-gray-400"><?= e($settings['site_tagline'] ?? '') ?></p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed mb-5">
                    Bank Perekonomian Rakyat Syariah yang beroperasi berdasarkan prinsip syariah Islam untuk melayani masyarakat Bangka Belitung.
                </p>
                <!-- Sosial Media -->
                <div class="flex items-center gap-3">
                    <a href="<?= e($facebook) ?>" target="_blank" rel="noopener noreferrer"
                       class="w-9 h-9 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-colors"
                       aria-label="Facebook <?= e($siteName) ?>">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="<?= e($instagram) ?>" target="_blank" rel="noopener noreferrer"
                       class="w-9 h-9 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-colors"
                       aria-label="Instagram <?= e($siteName) ?>">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="<?= e($youtube) ?>" target="_blank" rel="noopener noreferrer"
                       class="w-9 h-9 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-colors"
                       aria-label="YouTube <?= e($siteName) ?>">
                        <i class="fab fa-youtube text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Kolom 2: Produk -->
            <div>
                <h3 class="font-heading font-semibold text-white mb-4 text-sm uppercase tracking-wide">Produk & Layanan</h3>
                <ul class="space-y-2.5" role="list">
                    <li><a href="/produk/tabungan" class="text-gray-400 hover:text-secondary text-sm transition-colors">Tabungan</a></li>
                    <li><a href="/produk/deposito" class="text-gray-400 hover:text-secondary text-sm transition-colors">Deposito</a></li>
                    <li><a href="/produk/pembiayaan" class="text-gray-400 hover:text-secondary text-sm transition-colors">Pembiayaan</a></li>
                    <li><a href="/faq" class="text-gray-400 hover:text-secondary text-sm transition-colors">FAQ</a></li>
                    <li><a href="/lelang" class="text-gray-400 hover:text-secondary text-sm transition-colors">Lelang Aset</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Perusahaan -->
            <div>
                <h3 class="font-heading font-semibold text-white mb-4 text-sm uppercase tracking-wide">Perusahaan</h3>
                <ul class="space-y-2.5" role="list">
                    <li><a href="/tentang-kami/visi-misi" class="text-gray-400 hover:text-secondary text-sm transition-colors">Visi & Misi</a></li>
                    <li><a href="/tentang-kami/sejarah" class="text-gray-400 hover:text-secondary text-sm transition-colors">Sejarah</a></li>
                    <li><a href="/manajemen/dewan-direksi" class="text-gray-400 hover:text-secondary text-sm transition-colors">Manajemen</a></li>
                    <li><a href="/publikasi" class="text-gray-400 hover:text-secondary text-sm transition-colors">Publikasi</a></li>
                    <li><a href="/berita" class="text-gray-400 hover:text-secondary text-sm transition-colors">Berita</a></li>
                    <li><a href="/karir" class="text-gray-400 hover:text-secondary text-sm transition-colors">Karir</a></li>
                </ul>
            </div>

            <!-- Kolom 4: Kontak -->
            <div>
                <h3 class="font-heading font-semibold text-white mb-4 text-sm uppercase tracking-wide">Kontak</h3>
                <ul class="space-y-3" role="list">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-secondary mt-0.5 flex-shrink-0 text-sm"></i>
                        <span class="text-gray-400 text-sm leading-relaxed"><?= e($address) ?></span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-secondary flex-shrink-0 text-sm"></i>
                        <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>"
                           class="text-gray-400 hover:text-secondary text-sm transition-colors">
                            <?= e($phone) ?>
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-secondary flex-shrink-0 text-sm"></i>
                        <a href="mailto:<?= e($email) ?>"
                           class="text-gray-400 hover:text-secondary text-sm transition-colors">
                            <?= e($email) ?>
                        </a>
                    </li>
                </ul>

                <!-- Jam Operasional -->
                <div class="mt-5 p-3 bg-gray-800 rounded-lg">
                    <p class="text-xs font-semibold text-white mb-1.5">Jam Operasional</p>
                    <p class="text-gray-400 text-xs">Senin - Jumat: 08.00 - 15.30 WIB</p>
                    <p class="text-gray-400 text-xs">Sabtu: 08.00 - 12.00 WIB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Legalitas -->
    <div class="border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <!-- OJK Badge -->
                    <div class="flex items-center gap-2 bg-gray-800 rounded-lg px-3 py-1.5">
                        <i class="fas fa-shield-alt text-green-400 text-xs"></i>
                        <span class="text-xs text-gray-300">Diawasi OJK</span>
                    </div>
                    <!-- LPS Badge -->
                    <div class="flex items-center gap-2 bg-gray-800 rounded-lg px-3 py-1.5">
                        <i class="fas fa-lock text-blue-400 text-xs"></i>
                        <span class="text-xs text-gray-300">Dijamin LPS</span>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-gray-500 text-xs">
                        &copy; <?= date('Y') ?> <?= e($footerText) ?>. All Rights Reserved.
                    </p>
                    <div class="flex items-center justify-center md:justify-end gap-3 mt-1">
                        <a href="/hubungi-kami" class="text-gray-500 hover:text-gray-300 text-xs transition-colors">Hubungi Kami</a>
                        <span class="text-gray-700 text-xs">•</span>
                        <a href="/whistleblowing" class="text-gray-500 hover:text-gray-300 text-xs transition-colors">Whistleblowing</a>
                        <span class="text-gray-700 text-xs">•</span>
                        <a href="/karir" class="text-gray-500 hover:text-gray-300 text-xs transition-colors">Karir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
