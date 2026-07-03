<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Dashboard') ?> &mdash; Admin BPRS Bangka Belitung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#1a5f4a', light: '#2d8b6f', dark: '#0d3d2e' },
                        secondary: { DEFAULT: '#c9a84c' }
                    },
                    fontFamily: {
                        heading: ['Poppins', 'sans-serif'],
                        body: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-body" x-data="{ sidebarOpen: true, mobileSidebar: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- ====== SIDEBAR ====== -->
        <!-- Desktop Sidebar -->
        <aside class="admin-sidebar hidden lg:flex flex-col bg-primary text-white transition-all duration-300 flex-shrink-0 z-30"
               :class="sidebarOpen ? 'w-64' : 'w-16'">
            <?php require APP_PATH . '/Views/backend/layouts/sidebar.php'; ?>
        </aside>

        <!-- Mobile Sidebar -->
        <aside class="admin-sidebar fixed top-0 left-0 h-full w-64 flex flex-col bg-primary text-white z-50 lg:hidden transition-transform duration-300"
               :class="mobileSidebar ? 'translate-x-0' : '-translate-x-full'">
            <?php require APP_PATH . '/Views/backend/layouts/sidebar.php'; ?>
        </aside>

        <!-- ====== MAIN AREA ====== -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <?php require APP_PATH . '/Views/backend/layouts/topbar.php'; ?>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6">

                <!-- Flash Messages -->
                <?php if (!empty($flash_success)): ?>
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3" data-auto-dismiss="4000">
                    <i class="fas fa-check-circle text-green-500 flex-shrink-0"></i>
                    <span><?= e($flash_success) ?></span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
                <?php endif; ?>

                <?php if (!empty($flash_error)): ?>
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3" data-auto-dismiss="5000">
                    <i class="fas fa-exclamation-circle text-red-500 flex-shrink-0"></i>
                    <span><?= e($flash_error) ?></span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-700">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
                <?php endif; ?>

                <?= $content ?>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-6 py-3 text-xs text-gray-400 flex items-center justify-between flex-shrink-0">
                <span>&copy; <?= date('Y') ?> BPRS Bangka Belitung</span>
                <span>Berizin &amp; Diawasi OJK</span>
            </footer>
        </div>

    </div>

    <script src="/assets/js/admin.js"></script>
</body>
</html>
