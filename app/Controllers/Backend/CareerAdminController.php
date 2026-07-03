<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * CareerAdminController - CRUD Lowongan Pekerjaan
 */
class CareerAdminController extends BaseController
{
    private Security $security;

    /** Tipe employment valid sesuai ENUM di database */
    private const VALID_EMPLOYMENT_TYPES = ['full_time', 'part_time', 'contract', 'internship'];

    public function __construct()
    {
        parent::__construct();
        $this->security = new Security($this->db);
    }

    public function index(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('careers.manage');

        $query = "SELECT * FROM careers ORDER BY created_at DESC";

        $pagination = $this->paginate($query, [], 15);

        $this->render(
            'backend.layouts.dashboard',
            'backend.careers.index',
            [
                'title'         => 'Manajemen Lowongan Kerja | ' . $this->setting('site_name'),
                'careers'       => $pagination['data'],
                'pagination'    => $pagination,
                'validEmploymentTypes' => self::VALID_EMPLOYMENT_TYPES,
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
        $rbac->requirePermission('careers.manage');

        $this->verifyCsrf();

        $title            = Security::sanitize($_POST['title'] ?? '', 'string');
        $department       = Security::sanitize($_POST['department'] ?? '', 'string');
        $location         = Security::sanitize($_POST['location'] ?? '', 'string');
        $employmentType   = Security::sanitize($_POST['employment_type'] ?? 'full_time', 'string');
        $requirements     = Security::sanitize($_POST['requirements'] ?? '', 'html');
        $responsibilities = Security::sanitize($_POST['responsibilities'] ?? '', 'html');
        $description      = Security::sanitize($_POST['description'] ?? '', 'html');
        $deadline         = Security::sanitize($_POST['deadline'] ?? '', 'string');
        $isActive         = isset($_POST['is_active']) ? 1 : 0;

        $errors = Security::validate($_POST, [
            'title'           => 'required',
            'employment_type' => 'required|in:full_time,part_time,contract,internship',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/careers');
        }

        try {
            // Pastikan deadline berformat valid atau NULL
            if ($deadline === '' || !strtotime($deadline)) {
                $deadline = null;
            }

            $stmt = $this->db->prepare("
                INSERT INTO careers (title, department, location, employment_type, requirements,
                                     responsibilities, description, deadline, is_active, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $title, $department, $location, $employmentType, $requirements,
                $responsibilities, $description, $deadline, $isActive,
            ]);

            set_flash('success', 'Lowongan kerja berhasil ditambahkan.');

        } catch (Exception $e) {
            set_flash('error', 'Gagal menyimpan lowongan kerja. Silakan coba lagi.');
        }

        redirect('/admin/careers');
    }

    public function update(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('careers.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT * FROM careers WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $career = $stmt->fetch();

        if (!$career) {
            set_flash('error', 'Lowongan kerja tidak ditemukan.');
            redirect('/admin/careers');
        }

        $title            = Security::sanitize($_POST['title'] ?? '', 'string');
        $department       = Security::sanitize($_POST['department'] ?? '', 'string');
        $location         = Security::sanitize($_POST['location'] ?? '', 'string');
        $employmentType   = Security::sanitize($_POST['employment_type'] ?? 'full_time', 'string');
        $requirements     = Security::sanitize($_POST['requirements'] ?? '', 'html');
        $responsibilities = Security::sanitize($_POST['responsibilities'] ?? '', 'html');
        $description      = Security::sanitize($_POST['description'] ?? '', 'html');
        $deadline         = Security::sanitize($_POST['deadline'] ?? '', 'string');
        $isActive         = isset($_POST['is_active']) ? 1 : 0;

        $errors = Security::validate($_POST, [
            'title'           => 'required',
            'employment_type' => 'required|in:full_time,part_time,contract,internship',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/careers');
        }

        try {
            if ($deadline === '' || !strtotime($deadline)) {
                $deadline = null;
            }

            $stmt = $this->db->prepare("
                UPDATE careers
                SET title = ?, department = ?, location = ?, employment_type = ?,
                    requirements = ?, responsibilities = ?, description = ?,
                    deadline = ?, is_active = ?, updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([
                $title, $department, $location, $employmentType, $requirements,
                $responsibilities, $description, $deadline, $isActive, $id,
            ]);

            set_flash('success', 'Lowongan kerja berhasil diperbarui.');

        } catch (Exception $e) {
            set_flash('error', 'Gagal memperbarui lowongan kerja. Silakan coba lagi.');
        }

        redirect('/admin/careers');
    }

    public function destroy(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('careers.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT id FROM careers WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            set_flash('error', 'Lowongan kerja tidak ditemukan.');
            redirect('/admin/careers');
        }

        try {
            $stmt = $this->db->prepare("DELETE FROM careers WHERE id = ?");
            $stmt->execute([$id]);

            set_flash('success', 'Lowongan kerja berhasil dihapus.');

        } catch (Exception $e) {
            set_flash('error', 'Gagal menghapus lowongan kerja. Silakan coba lagi.');
        }

        redirect('/admin/careers');
    }
}
