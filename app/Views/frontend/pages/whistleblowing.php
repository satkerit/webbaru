<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'Whistleblowing System']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">Whistleblowing System</h1>
        <p class="text-white/80">Sistem Pelaporan Pelanggaran</p>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>

<section class="py-12 lg:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Information Section -->
        <div class="card p-6 md:p-8 mb-8">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-14 h-14 bg-orange-100 dark:bg-orange-900/40 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shield-alt text-2xl text-orange-600 dark:text-orange-400"></i>
                </div>
                <div>
                    <h2 class="font-heading font-semibold text-xl text-gray-900 dark:text-white mb-2">Tentang Program Ini</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Whistleblowing System BPRS Bangka Belitung adalah sarana bagi siapa saja untuk melaporkan dugaan pelanggaran, tindakan kecurangan, 
                        atau praktik yang tidak sesuai dengan peraturan dan kode etik yang berlaku di lingkungan perusahaan kami.
                    </p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <i class="fas fa-user-secret text-2xl text-primary"></i>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white text-sm">Kerahasiaan Terjamin</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Identitas pelapor dilindungi</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-lock text-2xl text-primary"></i>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white text-sm">Data Aman</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Informasi tersimpan terenkripsi</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas fa-gavel text-2xl text-primary"></i>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white text-sm">Tindak Lanjut</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Laporan akan diproses</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="card p-6 md:p-8">
            <h2 class="font-heading font-semibold text-2xl text-gray-900 dark:text-white mb-6">Formulir Laporan</h2>

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

            <form method="POST" action="/whistleblowing" enctype="multipart/form-data" data-validate x-data="{ anonymous: false }">
                <?= $csrf ?>

                <div class="mb-5">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_anonymous" value="1" x-model="anonymous"
                               class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Kirim sebagai anonim (identitas tidak dicatat)</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5" x-show="!anonymous" x-collapse>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap</label>
                        <input type="text" id="name" name="name" :required="!anonymous"
                               class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                               placeholder="Nama Anda (opsional jika anonim)">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
                        <input type="email" id="email" name="email"
                               class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                               placeholder="email@example.com (opsional)">
                    </div>
                </div>

                <div class="mb-5" x-show="!anonymous" x-collapse>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone"
                           class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                           placeholder="08xx xxxx xxxx (opsional)">
                </div>

                <div class="mb-5">
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kategori Pelanggaran <span class="text-red-500">*</span></label>
                    <select id="category" name="category" required
                            class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="korupsi">Korupsi</option>
                        <option value="penipuan">Penipuan (Fraud)</option>
                        <option value="pelanggaran">Pelanggaran Etika/Kode Etik</option>
                        <option value="benturan_kepentingan">Benturan Kepentingan</option>
                        <option value="penyalahgunaan_wewenang">Penyalahgunaan Wewenang</option>
                        <option value="gratifikasi">Gratifikasi</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kronologi/Deskripsi Pelanggaran <span class="text-red-500">*</span></label>
                    <textarea id="description" name="description" rows="7" required
                              class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 resize-none"
                              placeholder="Jelaskan secara rinci kronologi kejadian, siapa yang terlibat, kapan terjadi, di mana, dan bukti-bukti yang Anda miliki..."></textarea>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Semakin detail informasi yang Anda berikan, semakin mudah bagi kami untuk menindaklanjuti laporan.</p>
                </div>

                <div class="mb-6">
                    <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Lampiran (Opsional)</label>
                    <input type="file" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                           class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white focus:outline-none focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary file:text-white file:text-sm hover:file:bg-primary-dark">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Format: PDF, DOC, JPG, PNG (Max 5MB)</p>
                </div>

                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-amber-600 dark:text-amber-400 mt-0.5"></i>
                        <p class="text-sm text-amber-800 dark:text-amber-300">
                            <strong>Perhatian:</strong> Laporan yang Anda sampaikan akan dijaga kerahasiaannya dan ditindaklanjuti sesuai prosedur yang berlaku. 
                            Laporan palsu atau fitnah dapat dikenakan sanksi hukum.
                        </p>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full md:w-auto px-8">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Laporan
                </button>
            </form>
        </div>
    </div>
</section>
