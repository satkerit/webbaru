<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#1a5f4a', dark: '#0d3d2e', light: '#2d8b6f' }
                    },
                    fontFamily: {
                        heading: ['Poppins', 'sans-serif'],
                        body: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-body min-h-screen flex items-center justify-center p-6">
    <div class="text-center max-w-lg mx-auto">
        <!-- Decorative background circles -->
        <div class="relative mb-8">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-48 h-48 bg-primary/10 rounded-full"></div>
            </div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-36 h-36 bg-primary/20 rounded-full"></div>
            </div>
            <!-- 404 number -->
            <div class="relative z-10 py-12">
                <span class="font-heading font-extrabold text-8xl md:text-9xl text-primary leading-none">404</span>
            </div>
        </div>

        <!-- Icon -->
        <div class="w-20 h-20 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg rotate-12">
            <i class="fas fa-map-marker-alt text-white text-3xl -rotate-12"></i>
        </div>

        <h1 class="font-heading font-bold text-3xl md:text-4xl text-gray-900 mb-3">Halaman Tidak Ditemukan</h1>
        <p class="text-gray-500 text-lg mb-3">
            Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.
        </p>
        <p class="text-gray-400 text-sm mb-8">
            Pastikan URL yang Anda masukkan sudah benar, atau kembali ke halaman utama.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/" class="inline-flex items-center gap-2 px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all">
                <i class="fas fa-home"></i>Kembali ke Beranda
            </a>
            <button onclick="history.back()" class="inline-flex items-center gap-2 px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-xl border border-gray-200 shadow transition-all">
                <i class="fas fa-arrow-left"></i>Halaman Sebelumnya
            </button>
        </div>

        <!-- Quick links -->
        <div class="mt-10 pt-8 border-t border-gray-200">
            <p class="text-sm text-gray-500 mb-4">Atau kunjungi halaman berikut:</p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="/produk" class="text-sm text-primary hover:text-primary-dark">Produk &amp; Layanan</a>
                <span class="text-gray-300">|</span>
                <a href="/berita" class="text-sm text-primary hover:text-primary-dark">Berita</a>
                <span class="text-gray-300">|</span>
                <a href="/publikasi" class="text-sm text-primary hover:text-primary-dark">Publikasi</a>
                <span class="text-gray-300">|</span>
                <a href="/hubungi-kami" class="text-sm text-primary hover:text-primary-dark">Hubungi Kami</a>
            </div>
        </div>

        <p class="text-xs text-gray-400 mt-8">&copy; <?= date('Y') ?> BPRS Bangka Belitung. Berizin &amp; Diawasi OJK.</p>
    </div>
</body>
</html>
