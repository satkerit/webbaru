<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'BPRS Bangka Belitung') ?></title>

    <!-- SEO Meta -->
    <meta name="description" content="<?= e($meta_desc ?? $settings['meta_description'] ?? '') ?>">
    <meta name="keywords" content="<?= e($meta_keywords ?? $settings['meta_keywords'] ?? '') ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= e(($_ENV['APP_URL'] ?? '') . $_SERVER['REQUEST_URI']) ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= e($title ?? '') ?>">
    <meta property="og:description" content="<?= e($meta_desc ?? $settings['meta_description'] ?? '') ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e(($_ENV['APP_URL'] ?? '') . $_SERVER['REQUEST_URI']) ?>">
    <meta property="og:site_name" content="<?= e($settings['site_name'] ?? 'BPRS Bangka Belitung') ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#1a5f4a',
                            light: '#2d8b6f',
                            dark: '#0d3d2e',
                        },
                        secondary: {
                            DEFAULT: '#c9a84c',
                            light: '#e0c06e',
                            dark: '#a0853a',
                        },
                        accent: '#0ea5e9',
                    },
                    fontFamily: {
                        heading: ['Poppins', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body class="bg-white text-gray-800 font-body antialiased" x-data="{ darkMode: false, mobileMenu: false }" :class="darkMode ? 'dark' : ''">

    <!-- Skip Navigation (Aksesibilitas) -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 bg-primary text-white px-4 py-2 rounded z-50">
        Skip to main content
    </a>

    <!-- Navbar -->
    <?php require APP_PATH . '/Views/frontend/layouts/navbar.php'; ?>

    <!-- Main Content -->
    <main id="main-content">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <?php require APP_PATH . '/Views/frontend/layouts/footer.php'; ?>

    <!-- Back to Top -->
    <button id="backToTop"
        onclick="window.scrollTo({top:0,behavior:'smooth'})"
        class="hidden fixed bottom-6 right-6 z-50 bg-primary text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center hover:bg-primary-light transition-all duration-300"
        aria-label="Kembali ke atas">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Custom JS -->
    <script src="/assets/js/main.js"></script>
</body>
</html>
