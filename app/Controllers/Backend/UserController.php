<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * UserController - Full CRUD untuk manajemen pengguna admin
 */
class UserController extends BaseController
{
    private Security $security;

    public function __construct()
    {
        parent::__construct();
        $this->security = new Security($this->db);
    }

    public function index(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('users.manage');

        $query = "
            SELECT u.id, u.username, u.email, u.full_name, u.phone,
                   u.is_active, u.last_login, u.created_at,
                   r.name AS role_name
            FROM users u
            JOIN roles r ON u.role_id = r.id
            ORDER BY u.created_at DESC
        ";

        $pagination = $this->paginate($query, [], 20);

        $this->render(
            'backend.layouts.dashboard',
            'backend.users.index',
            [
                'title'      => 'Manajemen Pengguna | ' . $this->setting('site_name'),
                'users'      => $pagination['data'],
                'pagination' => $pagination,
                'rbac'       => $rbac,
                'user'       => $_SESSION,
                'flash_success' => flash('success'),
                'flash_error'   => flash('error'),
            ]
        );
    }

    public function create(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('users.manage');

        $stmt  = $this->db->query("SELECT id, name FROM roles ORDER BY name ASC");
        $roles = $stmt->fetchAll();

        $this->render(
            'backend.layouts.dashboard',
            'backend.users.create',
            [
                'title'  => 'Tambah Pengguna | ' . $this->setting('site_name'),
                'roles'  => $roles,
                'csrf'   => $this->security->csrfField(),
                'rbac'   => $rbac,
                'user'   => $_SESSION,
                'flash_error' => flash('error'),
            ]
        );
    }

    public function store(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('users.manage');

        $this->verifyCsrf();

        $username  = Security::sanitize($_POST['username'] ?? '', 'string');
        $email     = Security::sanitize($_POST['email'] ?? '', 'email');
        $password  = $_POST['password'] ?? '';
        $fullName  = Security::sanitize($_POST['full_name'] ?? '', 'string');
        $phone     = Security::sanitize($_POST['phone'] ?? '', 'string');
        $roleId    = (int) ($_POST['role_id'] ?? 0);
        $isActive  = isset($_POST['is_active']) ? 1 : 0;

        $errors = Security::validate($_POST, [
            'username' => 'required|min:3|max:50',
            'email'    => 'required|email',
            'password' => 'required|min:8',
            'role_id'  => 'required',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/users/create');
        }

        try {
            // Cek username & email duplikat
            $stmt = $this->db->prepare(
                "SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1"
            );
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                set_flash('error', 'Username atau email sudah digunakan.');
                redirect('/admin/users/create');
            }

            $passwordHash = Security::hashPassword($password);

            $stmt = $this->db->prepare("
                INSERT INTO users (username, email, password_hash, full_name, phone, role_id, is_active, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([$username, $email, $passwordHash, $fullName, $phone, $roleId, $isActive]);

            set_flash('success', 'Pengguna berhasil ditambahkan.');
            redirect('/admin/users');

        } catch (Exception $e) {
            set_flash('error', 'Gagal menambahkan pengguna. Silakan coba lagi.');
            redirect('/admin/users/create');
        }
    }

    public function edit(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('users.manage');

        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $userData = $stmt->fetch();

        if (!$userData) {
            set_flash('error', 'Pengguna tidak ditemukan.');
            redirect('/admin/users');
        }

        $stmt  = $this->db->query("SELECT id, name FROM roles ORDER BY name ASC");
        $roles = $stmt->fetchAll();

        $this->render(
            'backend.layouts.dashboard',
            'backend.users.edit',
            [
                'title'    => 'Edit Pengguna | ' . $this->setting('site_name'),
                'userData' => $userData,
                'roles'    => $roles,
                'csrf'     => $this->security->csrfField(),
                'rbac'     => $rbac,
                'user'     => $_SESSION,
                'flash_error' => flash('error'),
            ]
        );
    }

    public function update(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('users.manage');

        $this->verifyCsrf();

        // Cek user ada
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $existing = $stmt->fetch();

        if (!$existing) {
            set_flash('error', 'Pengguna tidak ditemukan.');
            redirect('/admin/users');
        }

        $username = Security::sanitize($_POST['username'] ?? '', 'string');
        $email    = Security::sanitize($_POST['email'] ?? '', 'email');
        $password = $_POST['password'] ?? '';
        $fullName = Security::sanitize($_POST['full_name'] ?? '', 'string');
        $phone    = Security::sanitize($_POST['phone'] ?? '', 'string');
        $roleId   = (int) ($_POST['role_id'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        $rules = [
            'username' => 'required|min:3|max:50',
            'email'    => 'required|email',
            'role_id'  => 'required',
        ];

        // Password hanya wajib jika diisi
        if ($password !== '') {
            $rules['password'] = 'min:8';
        }

        $errors = Security::validate($_POST, $rules);
        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/users/' . $id . '/edit');
        }

        try {
            // Cek duplikat username/email (kecuali milik sendiri)
            $stmt = $this->db->prepare(
                "SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ? LIMIT 1"
            );
            $stmt->execute([$username, $email, $id]);
            if ($stmt->fetch()) {
                set_flash('error', 'Username atau email sudah digunakan pengguna lain.');
                redirect('/admin/users/' . $id . '/edit');
            }

            if ($password !== '') {
                $passwordHash = Security::hashPassword($password);
                $stmt = $this->db->prepare("
                    UPDATE users
                    SET username = ?, email = ?, password_hash = ?, full_name = ?,
                        phone = ?, role_id = ?, is_active = ?, updated_at = NOW()
                    WHERE id = ?
                ");
                $stmt->execute([$username, $email, $passwordHash, $fullName, $phone, $roleId, $isActive, $id]);
            } else {
                $stmt = $this->db->prepare("
                    UPDATE users
                    SET username = ?, email = ?, full_name = ?,
                        phone = ?, role_id = ?, is_active = ?, updated_at = NOW()
                    WHERE id = ?
                ");
                $stmt->execute([$username, $email, $fullName, $phone, $roleId, $isActive, $id]);
            }

            set_flash('success', 'Pengguna berhasil diperbarui.');
            redirect('/admin/users');

        } catch (Exception $e) {
            set_flash('error', 'Gagal memperbarui pengguna. Silakan coba lagi.');
            redirect('/admin/users/' . $id . '/edit');
        }
    }

    public function destroy(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('users.manage');

        $this->verifyCsrf();

        // Cegah hapus diri sendiri
        if ($id === (int) $_SESSION['user_id']) {
            set_flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            redirect('/admin/users');
        }

        $stmt = $this->db->prepare("SELECT id FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            set_flash('error', 'Pengguna tidak ditemukan.');
            redirect('/admin/users');
        }

        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);

            set_flash('success', 'Pengguna berhasil dihapus.');
        } catch (Exception $e) {
            set_flash('error', 'Gagal menghapus pengguna. Silakan coba lagi.');
        }

        redirect('/admin/users');
    }
}
