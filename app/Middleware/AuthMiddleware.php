<?php

/**
 * Authentication & Authorization Middleware
 */
class AuthMiddleware
{
    public function handle(?string $permission = null): void
    {
        // Cek session login
        if (empty($_SESSION['user_id'])) {
            set_flash('error', 'Silakan login terlebih dahulu.');
            redirect('/admin/login');
        }

        // Cek session timeout
        $lifetime = (int) ($_ENV['SESSION_LIFETIME'] ?? 3600);
        if (isset($_SESSION['_last_activity']) && (time() - $_SESSION['_last_activity']) > $lifetime) {
            session_unset();
            session_destroy();
            set_flash('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
            redirect('/admin/login');
        }

        $_SESSION['_last_activity'] = time();

        // Cek RBAC permission jika ditentukan
        if ($permission !== null) {
            require_once APP_PATH . '/Helpers/RBAC.php';
            $db   = Database::getInstance();
            $rbac = new RBAC($db, (int) $_SESSION['user_id']);
            $rbac->requirePermission($permission);
        }
    }
}
