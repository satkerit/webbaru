<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Terjadi Kesalahan</title>
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
                <div class="w-48 h-48 bg-red-100 rounded-full"></div>
            </div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-36 h-36 bg-red-200/60 rounded-full"></div>
            </div>
            <!-- 500 number -->
            <div class="relative z-10 py-12">
                <span class="font-heading font-extrabold text-8xl md:text-9xl text-red-500 leading-none">500</span>
            </div>
        </div>

        <!-- Icon -->
        <div class="w-20 h-20 bg-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
            <i class="fas fa-exclamation-triangle text-white text-3xl"></i>
        </div>

        <h1 class="font-heading font-bold text-3xl md:text-4xl text-gray-900 mb-3">Terjadi Kesalahan</h1>
        <p class="text-gray-500 text-lg mb-3">
            Maaf, terjadi kesalahan pada server kami. Tim teknis sedang bekerja untuk memperbaikinya.
        </p>
        <p class="text-gray-400 text-sm mb-8">
            Silakan coba lagi dalam beberapa saat. Jika masalah berlanjut, hubungi administrator.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/" class="inline-flex items-center gap-2 px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all">
                <i class="fas fa-home"></i>Kembali ke Beranda
            </a>
            <button onclick="location.reload()" class="inline-flex items-center gap-2 px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-xl border border-gray-200 shadow transition-all">
                <i class="fas fa-redo-alt"></i>Coba Lagi
            </button>
        </div>

        <!-- Error details for non-production -->
        <?php if (!empty($error_message) && (defined('APP_DEBUG') && APP_DEBUG)): ?>
        <div class="mt-8 text-left bg-red-50 border border-red-200 rounded-xl p-5">
            <h3 class="font-semibold text-red-700 mb-2 text-sm"><i class="fas fa-bug mr-2"></i>Debug Info</h3>
            <code class="text-xs text-red-600 break-all"><?= htmlspecialchars($error_message ?? '') ?></code>
        </div>
        <?php endif; ?>

        <p class="text-xs text-gray-400 mt-8">&copy; <?= date('Y') ?> BPRS Bangka Belitung. Berizin &amp; Diawasi OJK.</p>
    </div>
</body>
</html>
