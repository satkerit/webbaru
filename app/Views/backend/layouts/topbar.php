<?php
/**
 * Admin Topbar
 * Requires: $auth_user, $page_title (optional)
 */
?>
<header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 md:px-6 flex-shrink-0 z-10">
    <!-- Left: Sidebar toggle + Page title -->
    <div class="flex items-center gap-4">
        <!-- Desktop sidebar toggle -->
        <button @click="sidebarOpen = !sidebarOpen"
                class="hidden lg:flex items-center justify-center w-9 h-9 text-gray-500 hover:bg-gray-100 hover:text-gray-700 rounded-lg transition-colors">
            <i class="fas fa-bars text-sm"></i>
        </button>
        <!-- Mobile sidebar toggle -->
        <button @click="mobileSidebar = !mobileSidebar"
                class="flex lg:hidden items-center justify-center w-9 h-9 text-gray-500 hover:bg-gray-100 hover:text-gray-700 rounded-lg transition-colors">
            <i class="fas fa-bars text-sm"></i>
        </button>

        <!-- Breadcrumb / Page title -->
        <div>
            <h2 class="font-heading font-semibold text-gray-900 text-sm md:text-base">
                <?= e($page_title ?? 'Dashboard') ?>
            </h2>
        </div>
    </div>

    <!-- Right: Notifications + User dropdown -->
    <div class="flex items-center gap-2">
        <!-- Notification Bell -->
        <div class="relative" x-data="{ notifOpen: false }">
            <button @click="notifOpen = !notifOpen"
                    class="relative flex items-center justify-center w-9 h-9 text-gray-500 hover:bg-gray-100 hover:text-gray-700 rounded-lg transition-colors"
                    aria-label="Notifikasi">
                <i class="fas fa-bell text-sm"></i>
                <?php if (!empty($notification_count) && $notification_count > 0): ?>
                <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center leading-none"><?= min($notification_count, 9) ?><?= $notification_count > 9 ? '+' : '' ?></span>
                <?php endif; ?>
            </button>

            <!-- Notifications Dropdown -->
            <div x-show="notifOpen" @click.outside="notifOpen=false" x-transition
                 class="absolute right-0 top-12 w-80 bg-white rounded-xl shadow-xl border border-gray-200 z-50 overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 text-sm">Notifikasi</h3>
                    <?php if (!empty($notification_count) && $notification_count > 0): ?>
                    <span class="text-xs text-white bg-red-500 px-2 py-0.5 rounded-full"><?= $notification_count ?> baru</span>
                    <?php endif; ?>
                </div>
                <div class="max-h-72 overflow-y-auto">
                    <?php if (!empty($notifications)): ?>
                        <?php foreach ($notifications as $notif): ?>
                        <a href="<?= e($notif['url'] ?? '#') ?>" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50 transition-colors <?= !$notif['is_read'] ? 'bg-primary/5' : '' ?>">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-<?= e($notif['icon'] ?? 'bell') ?> text-primary text-xs"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-800 font-medium truncate"><?= e($notif['title']) ?></p>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= e($notif['time'] ?? '') ?></p>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <div class="px-4 py-8 text-center text-gray-400 text-sm">
                        <i class="fas fa-bell-slash text-2xl mb-2 block text-gray-200"></i>
                        Tidak ada notifikasi baru
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- View Site -->
        <a href="/" target="_blank"
           class="hidden sm:flex items-center justify-center w-9 h-9 text-gray-500 hover:bg-gray-100 hover:text-gray-700 rounded-lg transition-colors"
           title="Lihat Website">
            <i class="fas fa-external-link-alt text-sm"></i>
        </a>

        <!-- User Dropdown -->
        <div class="relative" x-data="{ userOpen: false }">
            <button @click="userOpen = !userOpen"
                    class="flex items-center gap-2 pl-2 pr-3 py-1.5 hover:bg-gray-100 rounded-lg transition-colors">
                <div class="w-7 h-7 bg-primary rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                    <?= e(mb_strtoupper(mb_substr($auth_user['name'] ?? 'A', 0, 1))) ?>
                </div>
                <span class="hidden sm:block text-sm font-medium text-gray-700 max-w-24 truncate"><?= e($auth_user['name'] ?? 'Admin') ?></span>
                <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform" :class="userOpen ? 'rotate-180' : ''"></i>
            </button>

            <!-- User Dropdown Menu -->
            <div x-show="userOpen" @click.outside="userOpen=false" x-transition
                 class="absolute right-0 top-12 w-52 bg-white rounded-xl shadow-xl border border-gray-200 z-50 overflow-hidden py-1">
                <!-- User info -->
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="font-semibold text-gray-900 text-sm"><?= e($auth_user['name'] ?? 'Admin') ?></p>
                    <p class="text-xs text-gray-500"><?= e($auth_user['email'] ?? '') ?></p>
                    <p class="text-xs text-primary mt-0.5"><?= e($auth_user['role_name'] ?? '') ?></p>
                </div>
                <!-- Links -->
                <a href="/admin/profil" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-user-cog w-4 text-gray-400"></i>Profil Saya
                </a>
                <a href="/admin/ganti-password" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-key w-4 text-gray-400"></i>Ganti Password
                </a>
                <div class="border-t border-gray-100 mt-1 pt-1">
                    <a href="/admin/logout"
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors"
                       onclick="return confirm('Yakin ingin keluar?')">
                        <i class="fas fa-sign-out-alt w-4"></i>Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Sidebar Overlay -->
<div x-show="mobileSidebar" @click="mobileSidebar=false"
     class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-transition:enter="transition ease-in-out duration-200"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in-out duration-200"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
