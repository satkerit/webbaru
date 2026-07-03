<?php
/**
 * Admin Sidebar
 * Requires: $rbac (RBAC instance), $auth_user (current user array)
 * Uses: current URL from $_SERVER['REQUEST_URI'] for active state detection
 */
$currentUrl = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
$isActive = fn(string $prefix): bool => str_starts_with($currentUrl, $prefix);
?>

<!-- Sidebar Header: Logo -->
<div class="flex items-center gap-3 px-5 py-4 border-b border-white/10 flex-shrink-0" :class="sidebarOpen ? '' : 'justify-center'">
    <div class="w-9 h-9 bg-secondary rounded-xl flex items-center justify-center flex-shrink-0 shadow">
        <i class="fas fa-mosque text-primary text-lg"></i>
    </div>
    <div class="overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">
        <p class="font-heading font-bold text-white text-sm leading-tight">BPRS Babel</p>
        <p class="text-white/50 text-xs">Admin Panel</p>
    </div>
</div>

<!-- Navigation -->
<nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1" x-data="{}">

    <!-- Dashboard -->
    <a href="/admin/dashboard"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/dashboard') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Dashboard'">
        <i class="fas fa-tachometer-alt w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Dashboard</span>
    </a>

    <!-- Konten Section -->
    <?php if ($rbac->hasAnyPermission(['articles.view', 'sliders.view', 'pages.view'])): ?>
    <div class="pt-3 pb-1 overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 h-0'">
        <p class="text-white/30 text-xs font-semibold uppercase tracking-wider px-3">Konten</p>
    </div>

    <?php if ($rbac->hasPermission('articles.view')): ?>
    <a href="/admin/artikel"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/artikel') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Artikel'">
        <i class="fas fa-newspaper w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Artikel & Berita</span>
    </a>
    <?php endif; ?>

    <?php if ($rbac->hasPermission('sliders.view')): ?>
    <a href="/admin/slider"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/slider') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Slider'">
        <i class="fas fa-images w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Slider / Banner</span>
    </a>
    <?php endif; ?>

    <?php if ($rbac->hasPermission('pages.view')): ?>
    <a href="/admin/halaman"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/halaman') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Halaman'">
        <i class="fas fa-file-alt w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Halaman Statis</span>
    </a>
    <?php endif; ?>
    <?php endif; ?>

    <!-- Produk & Layanan Section -->
    <?php if ($rbac->hasPermission('products.view')): ?>
    <div class="pt-3 pb-1 overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 h-0'">
        <p class="text-white/30 text-xs font-semibold uppercase tracking-wider px-3">Produk</p>
    </div>
    <a href="/admin/produk"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/produk') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Produk'">
        <i class="fas fa-boxes w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Produk & Layanan</span>
    </a>
    <?php endif; ?>

    <!-- Manajemen Section -->
    <?php if ($rbac->hasPermission('management.view')): ?>
    <a href="/admin/manajemen"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/manajemen') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Manajemen'">
        <i class="fas fa-users-cog w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Data Manajemen</span>
    </a>
    <?php endif; ?>

    <!-- Publikasi Section -->
    <?php if ($rbac->hasPermission('publications.view')): ?>
    <div class="pt-3 pb-1 overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 h-0'">
        <p class="text-white/30 text-xs font-semibold uppercase tracking-wider px-3">Publikasi</p>
    </div>
    <a href="/admin/publikasi"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/publikasi') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Publikasi'">
        <i class="fas fa-file-download w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Publikasi</span>
    </a>
    <?php endif; ?>

    <!-- Lelang & Karir Section -->
    <?php if ($rbac->hasAnyPermission(['auctions.view', 'careers.view'])): ?>
    <div class="pt-3 pb-1 overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 h-0'">
        <p class="text-white/30 text-xs font-semibold uppercase tracking-wider px-3">Layanan</p>
    </div>

    <?php if ($rbac->hasPermission('auctions.view')): ?>
    <a href="/admin/lelang"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/lelang') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Lelang'">
        <i class="fas fa-gavel w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Lelang Aset</span>
    </a>
    <?php endif; ?>

    <?php if ($rbac->hasPermission('careers.view')): ?>
    <a href="/admin/karir"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/karir') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Karir'">
        <i class="fas fa-briefcase w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Lowongan Karir</span>
    </a>
    <?php endif; ?>
    <?php endif; ?>

    <!-- Pesan & Laporan Section -->
    <?php if ($rbac->hasAnyPermission(['contacts.view', 'whistleblows.view'])): ?>
    <div class="pt-3 pb-1 overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 h-0'">
        <p class="text-white/30 text-xs font-semibold uppercase tracking-wider px-3">Pesan & Laporan</p>
    </div>

    <?php if ($rbac->hasPermission('contacts.view')): ?>
    <a href="/admin/pesan"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/pesan') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Pesan'">
        <i class="fas fa-envelope w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Pesan Masuk</span>
        <?php if (!empty($unread_messages) && $unread_messages > 0): ?>
        <span class="ml-auto flex-shrink-0 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center transition-all" :class="sidebarOpen ? '' : 'hidden'"><?= $unread_messages ?></span>
        <?php endif; ?>
    </a>
    <?php endif; ?>

    <?php if ($rbac->hasPermission('whistleblows.view')): ?>
    <a href="/admin/whistleblow"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/whistleblow') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Whistleblow'">
        <i class="fas fa-bullhorn w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Whistleblowing</span>
    </a>
    <?php endif; ?>
    <?php endif; ?>

    <!-- Administrasi Section -->
    <?php if ($rbac->hasAnyPermission(['users.view', 'roles.view', 'settings.view'])): ?>
    <div class="pt-3 pb-1 overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 h-0'">
        <p class="text-white/30 text-xs font-semibold uppercase tracking-wider px-3">Administrasi</p>
    </div>

    <?php if ($rbac->hasPermission('users.view')): ?>
    <a href="/admin/pengguna"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/pengguna') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Pengguna'">
        <i class="fas fa-users w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Pengguna</span>
    </a>
    <?php endif; ?>

    <?php if ($rbac->hasPermission('roles.view')): ?>
    <a href="/admin/role"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/role') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Role'">
        <i class="fas fa-shield-alt w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Role & Akses</span>
    </a>
    <?php endif; ?>

    <?php if ($rbac->hasPermission('settings.view')): ?>
    <a href="/admin/pengaturan"
       class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group <?= $isActive('/admin/pengaturan') ? 'active' : '' ?>"
       :title="sidebarOpen ? '' : 'Pengaturan'">
        <i class="fas fa-cog w-5 text-center text-sm flex-shrink-0"></i>
        <span class="text-sm font-medium overflow-hidden transition-all" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">Pengaturan</span>
    </a>
    <?php endif; ?>
    <?php endif; ?>

</nav>

<!-- Bottom: User Info & Logout -->
<div class="border-t border-white/10 p-3 flex-shrink-0">
    <div class="flex items-center gap-3 px-2 py-2 rounded-lg overflow-hidden">
        <!-- Avatar -->
        <div class="w-8 h-8 bg-secondary/80 rounded-full flex items-center justify-center flex-shrink-0 text-primary font-bold text-sm">
            <?= e(mb_strtoupper(mb_substr($auth_user['name'] ?? 'A', 0, 1))) ?>
        </div>
        <div class="overflow-hidden transition-all flex-1 min-w-0" :class="sidebarOpen ? 'opacity-100 w-auto' : 'opacity-0 w-0'">
            <p class="text-white text-sm font-medium truncate"><?= e($auth_user['name'] ?? 'Admin') ?></p>
            <p class="text-white/40 text-xs truncate"><?= e($auth_user['role_name'] ?? 'Administrator') ?></p>
        </div>
        <!-- Logout -->
        <a href="/admin/logout"
           class="flex-shrink-0 w-8 h-8 bg-white/10 hover:bg-red-500 text-white/60 hover:text-white rounded-lg flex items-center justify-center transition-colors"
           :class="sidebarOpen ? '' : 'mx-auto'"
           title="Keluar"
           onclick="return confirm('Yakin ingin keluar?')">
            <i class="fas fa-sign-out-alt text-sm"></i>
        </a>
    </div>
</div>
