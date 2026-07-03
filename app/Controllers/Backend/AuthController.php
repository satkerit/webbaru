<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * AuthController - Login & Logout Admin
 */
class AuthController extends BaseController
{
    private Security $security;

    public function __construct()
    {
        parent::__construct();
        $this->security = new Security($this->db);
    }

    public function showLogin(): void
    {
        // Jika sudah login, redirect ke dashboard
        if (!empty($_SESSION['user_id'])) {
            redirect('/admin/dashboard');
        }

        $this->render(
            'backend.layouts.auth',
            'backend.auth.login',
            [
                'title'       => 'Login Admin | ' . $this->setting('site_name'),
                'csrf'        => $this->security->csrfField(),
                'flash_error' => flash('error'),
            ]
        );
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/admin/login');
        }

        // Validasi CSRF
        try {
            $this->verifyCsrf();
        } catch (RuntimeException) {
            set_flash('error', 'Request tidak valid. Silakan coba lagi.');
            redirect('/admin/login');
        }

        $username = Security::sanitize($_POST['username'] ?? '', 'string');
        $password = $_POST['password'] ?? '';
        $ip       = get_client_ip();

        try {
            // Cek rate limit
            $this->security->checkLoginAttempts($username);

            // Cari user
            $stmt = $this->db->prepare(
                "SELECT u.*, r.name as role_name
                 FROM users u
                 JOIN roles r ON u.role_id = r.id
                 WHERE (u.username = ? OR u.email = ?) AND u.is_active = 1
                 LIMIT 1"
            );
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();

            if (!$user || !Security::verifyPassword($password, $user['password_hash'])) {
                $this->security->recordFailedLogin($username, $ip);
                set_flash('error', 'Username atau password salah.');
                redirect('/admin/login');
            }

            // Login sukses
            $this->security->resetLoginAttempts((int) $user['id']);
            $this->security->recordSuccessLogin((int) $user['id'], $ip);

            // Set session
            session_regenerate_id(true);
            $_SESSION['user_id']       = $user['id'];
            $_SESSION['username']      = $user['username'];
            $_SESSION['full_name']     = $user['full_name'];
            $_SESSION['role_id']       = $user['role_id'];
            $_SESSION['role_name']     = $user['role_name'];
            $_SESSION['avatar']        = $user['avatar'];
            $_SESSION['_last_activity']= time();

            redirect('/admin/dashboard');

        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
            redirect('/admin/login');
        }
    }

    public function logout(): void
    {
        // Verifikasi CSRF untuk POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->verifyCsrf();
            } catch (RuntimeException) {
                // Tetap logout walau CSRF gagal
            }
        }

        session_unset();
        session_destroy();

        set_flash('success', 'Anda berhasil logout.');
        redirect('/admin/login');
    }
}
