<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Hubungi Kami']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Hubungi Kami</h1>
        <p class="text-white/80">Kami siap melayani Anda</p>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>

<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Contact Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Address -->
            <div class="card p-6 text-center group hover:shadow-xl hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary transition-colors">
                    <i class="fas fa-map-marker-alt text-2xl text-primary group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-2">Alamat</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <?= e($contact['address'] ?? 'Jl. Raya Sungailiat, Bangka Belitung') ?>
                </p>
            </div>
            <!-- Phone -->
            <div class="card p-6 text-center group hover:shadow-xl hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary transition-colors">
                    <i class="fas fa-phone-alt text-2xl text-primary group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-2">Telepon</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <a href="tel:<?= e($contact['phone'] ?? '0717123456') ?>" class="hover:text-primary"><?= e($contact['phone'] ?? '(0717) 123-456') ?></a>
                </p>
            </div>
            <!-- Email -->
            <div class="card p-6 text-center group hover:shadow-xl hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary transition-colors">
                    <i class="fas fa-envelope text-2xl text-primary group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-2">Email</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <a href="mailto:<?= e($contact['email'] ?? 'info@bprsbabel.com') ?>" class="hover:text-primary"><?= e($contact['email'] ?? 'info@bprsbabel.com') ?></a>
                </p>
            </div>
            <!-- Hours -->
            <div class="card p-6 text-center group hover:shadow-xl hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary transition-colors">
                    <i class="fas fa-clock text-2xl text-primary group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-2">Jam Kerja</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <?= e($contact['hours'] ?? 'Senin - Jumat: 08:00 - 16:00') ?>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <!-- Contact Form -->
            <div class="lg:col-span-3">
                <div class="card p-6 lg:p-8">
                    <h2 class="font-heading font-semibold text-2xl text-gray-900 dark:text-white mb-2">Kirim Pesan</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Isi formulir di bawah ini, kami akan segera menghubungi Anda.</p>

                    <!-- Flash Messages -->
                    <?php if (!empty($flash_success)): ?>
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-400 rounded-lg flex items-start gap-3" data-flash>
                        <i class="fas fa-check-circle mt-0.5"></i>
                        <div><?= e($flash_success) ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($flash_error)): ?>
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-400 rounded-lg flex items-start gap-3" data-flash>
                        <i class="fas fa-exclamation-circle mt-0.5"></i>
                        <div><?= e($flash_error) ?></div>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="/hubungi-kami" data-validate>
                        <?= $csrf ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" required
                                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                                       placeholder="Nama Anda">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" required
                                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                                       placeholder="email@example.com">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nomor Telepon <span class="text-red-500">*</span></label>
                                <input type="tel" id="phone" name="phone" required
                                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                                       placeholder="08xx xxxx xxxx">
                            </div>
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Subjek <span class="text-red-500">*</span></label>
                                <input type="text" id="subject" name="subject" required
                                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                                       placeholder="Subjek pesan">
                            </div>
                        </div>
                        <div class="mb-5">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Jenis Pesan <span class="text-red-500">*</span></label>
                            <select id="type" name="type" required
                                    class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                                <option value="">-- Pilih Jenis Pesan --</option>
                                <option value="pertanyaan">Pertanyaan Umum</option>
                                <option value="pembukaan">Pembukaan Rekening</option>
                                <option value="pembiayaan">Pengajuan Pembiayaan</option>
                                <option value="keluhan">Keluhan/Saran</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Pesan <span class="text-red-500">*</span></label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 resize-none"
                                      placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full md:w-auto px-8">
                            <i class="fas fa-paper-plane mr-2"></i>Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Links Sidebar -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Whistleblowing -->
                <div class="card p-6 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 border-orange-200 dark:border-orange-700">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-bullhorn text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-1">Whistleblowing System</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Laporkan dugaan pelanggaran atau tindakan yang tidak sesuai.</p>
                            <a href="/whistleblowing" class="inline-flex items-center text-sm text-orange-600 dark:text-orange-400 hover:text-orange-700 font-medium">
                                Laporkan <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Career -->
                <div class="card p-6 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border-blue-200 dark:border-blue-700">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-briefcase text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-1">Lowongan Kerja</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Bergabunglah dengan tim BPRS Bangka Belitung.</p>
                            <a href="/karir" class="inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium">
                                Lihat Lowongan <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Map Placeholder -->
                <div class="card p-6">
                    <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-3">Lokasi Kami</h3>
                    <div class="aspect-video bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-map-marked-alt text-4xl text-gray-300 dark:text-gray-600"></i>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 text-center">
                        <a href="/tentang/lokasi" class="hover:text-primary">Lihat peta dan lokasi lengkap</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
