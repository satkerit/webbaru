<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * ManagementAdminController - CRUD Data Pengurus / Dewan (Komisaris, Direksi, Pengawas Syariah)
 */
class ManagementAdminController extends BaseController
{
    private Security $security;

    /** Tipe manajemen valid sesuai ENUM di database */
    private const VALID_TYPES = ['komisaris', 'direksi', 'pengawas_syariah'];

    public function __construct()
    {
        parent::__construct();
        $this->security = new Security($this->db);
    }

    public function index(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('management.manage');

        $stmt       = $this->db->query("
            SELECT * FROM management
            ORDER BY FIELD(type, 'komisaris', 'direksi', 'pengawas_syariah'), display_order ASC, name ASC
        ");
        $management = $stmt->fetchAll();

        $this->render(
            'backend.layouts.dashboard',
            'backend.management.index',
            [
                'title'         => 'Manajemen Pengurus | ' . $this->setting('site_name'),
                'management'    => $management,
                'validTypes'    => self::VALID_TYPES,
                'csrf'          => $this->security->csrfField(),
                'rbac'          => $rbac,
                'user'          => $_SESSION,
                'flash_success' => flash('success'),
                'flash_error'   => flash('error'),
            ]
        );
    }

    public function store(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('management.manage');

        $this->verifyCsrf();

        $name          = Security::sanitize($_POST['name'] ?? '', 'string');
        $position      = Security::sanitize($_POST['position'] ?? '', 'string');
        $type          = Security::sanitize($_POST['type'] ?? '', 'string');
        $bio           = Security::sanitize($_POST['bio'] ?? '', 'html');
        $education     = Security::sanitize($_POST['education'] ?? '', 'string');
        $careerHistory = Security::sanitize($_POST['career_history'] ?? '', 'string');
        $displayOrder  = (int) ($_POST['display_order'] ?? 0);
        $isActive      = isset($_POST['is_active']) ? 1 : 0;

        $errors = Security::validate($_POST, [
            'name'     => 'required',
            'position' => 'required',
            'type'     => 'required|in:komisaris,direksi,pengawas_syariah',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/management');
        }

        try {
            // Upload foto jika ada
            $photo = null;
            if (!empty($_FILES['photo']['name'])) {
                $config = require APP_PATH . '/Config/app.php';
                $photo  = $this->security->uploadFile(
                    $_FILES['photo'],
                    'management',
                    $config['allowed_image_types']
                );
            }

            $stmt = $this->db->prepare("
                INSERT INTO management (name, position, type, photo, bio, education,
                                        career_history, display_order, is_active, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $name, $position, $type, $photo, $bio,
                $education, $careerHistory, $displayOrder, $isActive,
            ]);

            set_flash('success', 'Data pengurus berhasil ditambahkan.');

        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
        } catch (Exception $e) {
            set_flash('error', 'Gagal menyimpan data pengurus. Silakan coba lagi.');
        }

        redirect('/admin/management');
    }

    public function update(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('management.manage');

        $this->verifyCsrf();

        $stmt   = $this->db->prepare("SELECT * FROM management WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $member = $stmt->fetch();

        if (!$member) {
            set_flash('error', 'Data pengurus tidak ditemukan.');
            redirect('/admin/management');
        }

        $name          = Security::sanitize($_POST['name'] ?? '', 'string');
        $position      = Security::sanitize($_POST['position'] ?? '', 'string');
        $type          = Security::sanitize($_POST['type'] ?? '', 'string');
        $bio           = Security::sanitize($_POST['bio'] ?? '', 'html');
        $education     = Security::sanitize($_POST['education'] ?? '', 'string');
        $careerHistory = Security::sanitize($_POST['career_history'] ?? '', 'string');
        $displayOrder  = (int) ($_POST['display_order'] ?? 0);
        $isActive      = isset($_POST['is_active']) ? 1 : 0;

        $errors = Security::validate($_POST, [
            'name'     => 'required',
            'position' => 'required',
            'type'     => 'required|in:komisaris,direksi,pengawas_syariah',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/management');
        }

        try {
            $photo = $member['photo'];

            // Upload foto baru jika ada
            if (!empty($_FILES['photo']['name'])) {
                $config   = require APP_PATH . '/Config/app.php';
                $newPhoto = $this->security->uploadFile(
                    $_FILES['photo'],
                    'management',
                    $config['allowed_image_types']
                );

                // Hapus foto lama
                if ($photo) {
                    $oldPath = $config['upload_path'] . '/management/' . $photo;
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $photo = $newPhoto;
            }

            $stmt = $this->db->prepare("
                UPDATE management
                SET name = ?, position = ?, type = ?, photo = ?, bio = ?,
                    education = ?, career_history = ?, display_order = ?,
                    is_active = ?, updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([
                $name, $position, $type, $photo, $bio,
                $education, $careerHistory, $displayOrder, $isActive, $id,
            ]);

            set_flash('success', 'Data pengurus berhasil diperbarui.');

        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
        } catch (Exception $e) {
            set_flash('error', 'Gagal memperbarui data pengurus. Silakan coba lagi.');
        }

        redirect('/admin/management');
    }

    public function destroy(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('management.manage');

        $this->verifyCsrf();

        $stmt   = $this->db->prepare("SELECT * FROM management WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $member = $stmt->fetch();

        if (!$member) {
            set_flash('error', 'Data pengurus tidak ditemukan.');
            redirect('/admin/management');
        }

        try {
            // Hapus foto
            if ($member['photo']) {
                $config   = require APP_PATH . '/Config/app.php';
                $photoPath = $config['upload_path'] . '/management/' . $member['photo'];
                if (file_exists($photoPath)) {
                    @unlink($photoPath);
                }
            }

            $stmt = $this->db->prepare("DELETE FROM management WHERE id = ?");
            $stmt->execute([$id]);

            set_flash('success', 'Data pengurus berhasil dihapus.');

        } catch (Exception $e) {
            set_flash('error', 'Gagal menghapus data pengurus. Silakan coba lagi.');
        }

        redirect('/admin/management');
    }
}
