<?php $breadcrumbs = [['label'=>'Beranda','url'=>'/'],['label'=>'FAQ']]; ?>
<div class="page-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 page-header-content">
        <h1 class="text-3xl md:text-4xl font-heading font-bold text-white mb-2">FAQ</h1>
        <p class="text-white/80">Pertanyaan yang Sering Diajukan</p>
        <?php require APP_PATH . '/Views/frontend/components/breadcrumb.php'; ?>
    </div>
</div>

<section class="py-12 lg:py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($faqPage)): ?>
            <!-- FAQ from database/controller -->
            <?php if (!empty($faqPage['intro'])): ?>
            <div class="card p-6 mb-8 text-center">
                <p class="text-gray-600 dark:text-gray-400"><?= e($faqPage['intro']) ?></p>
            </div>
            <?php endif; ?>
            <?php if (!empty($faqPage['items'])): ?>
            <div class="space-y-3">
                <?php foreach ($faqPage['items'] as $i => $faq): ?>
                <div class="accordion-item card" data-index="<?= $i ?>">
                    <button class="accordion-header w-full flex items-center justify-between p-5 text-left font-medium text-gray-900 dark:text-white hover:text-primary transition-colors">
                        <span><?= e($faq['question']) ?></span>
                        <i class="fas fa-chevron-down ml-3 flex-shrink-0 transition-transform"></i>
                    </button>
                    <div class="accordion-body px-5 pb-5 text-gray-600 dark:text-gray-400 hidden">
                        <?= nl2br(e($faq['answer'])) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <!-- Default FAQ content -->
            <p class="text-center text-gray-500 dark:text-gray-400 mb-8">Berikut adalah jawaban atas pertanyaan yang sering diajukan seputar BPRS Bangka Belitung.</p>
            <div class="space-y-3">
                <?php 
                $defaultFaqs = [
                    [
                        'question' => 'Apa itu BPRS Bangka Belitung?',
                        'answer'   => 'BPRS Bangka Belitung adalah Bank Perekonomian Rakyat Syariah yang beroperasi berdasarkan prinsip-prinsip syariah Islam, melayani masyarakat Bangka Belitung dengan produk-produk perbankan yang halal dan berkah. BPRS kami berizin dan diawasi oleh Otoritas Jasa Keuangan (OJK).',
                    ],
                    [
                        'question' => 'Bagaimana cara membuka rekening di BPRS Bangka Belitung?',
                        'answer'   => 'Kunjungi kantor kami dengan membawa KTP/identitas diri yang masih berlaku, mengisi formulir pembukaan rekening, dan menyetor setoran awal sesuai ketentuan produk yang dipilih. Tim kami siap membantu Anda memilih produk yang sesuai kebutuhan.',
                    ],
                    [
                        'question' => 'Produk apa saja yang tersedia di BPRS Bangka Belitung?',
                        'answer'   => 'Kami menyediakan berbagai produk perbankan syariah, antara lain: Tabungan (wadiah/mudharabah), Deposito Mudharabah, dan Pembiayaan (Murabahah, Mudharabah, Musyarakah, dan lain-lain) untuk kebutuhan produktif maupun konsumtif.',
                    ],
                    [
                        'question' => 'Apakah simpanan saya dijamin?',
                        'answer'   => 'Ya, simpanan nasabah di BPRS Bangka Belitung dijamin oleh Lembaga Penjamin Simpanan (LPS) sesuai dengan ketentuan yang berlaku, hingga batas maksimal yang ditetapkan LPS. Ini memberikan keamanan dan ketenangan pikiran bagi seluruh nasabah kami.',
                    ],
                    [
                        'question' => 'Apa bedanya BPRS dengan bank konvensional?',
                        'answer'   => 'BPRS beroperasi berdasarkan prinsip syariah Islam, sehingga tidak menerapkan sistem bunga (riba). Sebagai gantinya, kami menggunakan akad-akad syariah seperti bagi hasil (mudharabah/musyarakah), jual beli (murabahah), dan sewa (ijarah). Setiap produk dan layanan kami diawasi oleh Dewan Pengawas Syariah.',
                    ],
                    [
                        'question' => 'Bagaimana cara mengajukan pembiayaan?',
                        'answer'   => 'Anda dapat mengajukan pembiayaan dengan datang langsung ke kantor kami, mengisi formulir permohonan pembiayaan, melampirkan dokumen persyaratan, dan menunggu proses analisis kredit. Tim kami akan menghubungi Anda untuk memberitahukan hasil analisis.',
                    ],
                ];
                foreach ($defaultFaqs as $i => $faq): 
                ?>
                <div class="accordion-item card" data-index="<?= $i ?>">
                    <button class="accordion-header w-full flex items-center justify-between p-5 text-left font-medium text-gray-900 dark:text-white hover:text-primary transition-colors">
                        <span><?= e($faq['question']) ?></span>
                        <i class="fas fa-chevron-down ml-3 flex-shrink-0 transition-transform"></i>
                    </button>
                    <div class="accordion-body px-5 pb-5 text-gray-600 dark:text-gray-400 hidden">
                        <?= nl2br(e($faq['answer'])) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Still have questions CTA -->
        <div class="mt-10 p-6 bg-primary/5 dark:bg-primary/10 rounded-2xl text-center">
            <i class="fas fa-headset text-3xl text-primary mb-3 block"></i>
            <h3 class="font-heading font-semibold text-gray-900 dark:text-white mb-2">Masih Ada Pertanyaan?</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Tim kami siap membantu Anda menjawab setiap pertanyaan.</p>
            <a href="/hubungi-kami" class="btn-primary inline-flex items-center gap-2">
                <i class="fas fa-envelope"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>
