<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * PublicationAdminController - Manajemen Publikasi dengan upload PDF
 */
class PublicationAdminController extends BaseController
{
    private Security $security;

    /** Tipe publikasi valid sesuai ENUM di database */
    private const VALID_TYPES = [
        'laporan_keuangan',
        'laporan_tata_kelola',
        'laporan_tahunan',
        'laporan_berkelanjutan',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->security = new Security($this->db);
    }

    public function index(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('publications.manage');

        $typeFilter = Security::sanitize($_GET['type'] ?? '', 'string');
        $yearFilter = Security::sanitize($_GET['year'] ?? '', 'string');

        $conditions = [];
        $params     = [];

        if ($typeFilter !== '' && in_array($typeFilter, self::VALID_TYPES, true)) {
            $conditions[] = "type = ?";
            $params[]     = $typeFilter;
        } else {
            $typeFilter = '';
        }

        if ($yearFilter !== '' && is_numeric($yearFilter)) {
            $conditions[] = "year = ?";
            $params[]     = (int) $yearFilter;
        } else {
            $yearFilter = '';
        }

        $where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $query = "SELECT * FROM publications {$where} ORDER BY year DESC, created_at DESC";

        $pagination = $this->paginate($query, $params, 15);

        // Daftar tahun untuk filter
        $stmt  = $this->db->query("SELECT DISTINCT year FROM publications ORDER BY year DESC");
        $years = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $this->render(
            'backend.layouts.dashboard',
            'backend.publications.index',
            [
                'title'         => 'Manajemen Publikasi | ' . $this->setting('site_name'),
                'publications'  => $pagination['data'],
                'pagination'    => $pagination,
                'typeFilter'    => $typeFilter,
                'yearFilter'    => $yearFilter,
                'validTypes'    => self::VALID_TYPES,
                'years'         => $years,
                'csrf'          => $this->security->csrfField(),
                'rbac'          => $rbac,
                'user'          => $_SESSION,
                'flash_success' => flash('success'),
                'flash_error'   => flash('error'),
            ]
        );
    }

    public function create(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('publications.manage');

        $this->render(
            'backend.layouts.dashboard',
            'backend.publications.upload',
            [
                'title'      => 'Upload Publikasi | ' . $this->setting('site_name'),
                'validTypes' => self::VALID_TYPES,
                'csrf'       => $this->security->csrfField(),
                'rbac'       => $rbac,
                'user'       => $_SESSION,
                'flash_error' => flash('error'),
            ]
        );
    }

    public function store(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('publications.manage');

        $this->verifyCsrf();

        $title       = Security::sanitize($_POST['title'] ?? '', 'string');
        $type        = Security::sanitize($_POST['type'] ?? '', 'string');
        $year        = Security::sanitize($_POST['year'] ?? '', 'string');
        $quarter     = Security::sanitize($_POST['quarter'] ?? 'Full', 'string');
        $description = Security::sanitize($_POST['description'] ?? '', 'string');
        $isActive    = isset($_POST['is_active']) ? 1 : 0;

        $errors = Security::validate($_POST, [
            'title' => 'required',
            'type'  => 'required',
            'year'  => 'required|numeric',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/publications/create');
        }

        if (!in_array($type, self::VALID_TYPES, true)) {
            set_flash('error', 'Tipe publikasi tidak valid.');
            redirect('/admin/publications/create');
        }

        if (empty($_FILES['file']['name'])) {
            set_flash('error', 'File PDF wajib diunggah.');
            redirect('/admin/publications/create');
        }

        // Validasi quarter
        $validQuarters = ['Q1', 'Q2', 'Q3', 'Q4', 'Full'];
        if (!in_array($quarter, $validQuarters, true)) {
            $quarter = 'Full';
        }

        try {
            $filename = $this->security->uploadFile(
                $_FILES['file'],
                'publications',
                ['application/pdf']
            );

            // Ambil ukuran file
            $config   = require APP_PATH . '/Config/app.php';
            $filePath = $config['upload_path'] . '/publications/' . $filename;
            $fileSize = file_exists($filePath) ? filesize($filePath) : 0;

            $stmt = $this->db->prepare("
                INSERT INTO publications (title, type, file_path, file_size, file_type, year,
                                          quarter, description, is_active, created_at)
                VALUES (?, ?, ?, ?, 'application/pdf', ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $title, $type, $filename, $fileSize,
                (int) $year, $quarter, $description, $isActive,
            ]);

            set_flash('success', 'Publikasi berhasil diunggah.');
            redirect('/admin/publications');

        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
            redirect('/admin/publications/create');
        } catch (Exception $e) {
            set_flash('error', 'Gagal menyimpan publikasi. Silakan coba lagi.');
            redirect('/admin/publications/create');
        }
    }

    public function destroy(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('publications.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT * FROM publications WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $publication = $stmt->fetch();

        if (!$publication) {
            set_flash('error', 'Publikasi tidak ditemukan.');
            redirect('/admin/publications');
        }

        try {
            // Hapus file PDF
            if ($publication['file_path']) {
                $config   = require APP_PATH . '/Config/app.php';
                $pdfPath  = $config['upload_path'] . '/publications/' . $publication['file_path'];
                if (file_exists($pdfPath)) {
                    @unlink($pdfPath);
                }
            }

            $stmt = $this->db->prepare("DELETE FROM publications WHERE id = ?");
            $stmt->execute([$id]);

            set_flash('success', 'Publikasi berhasil dihapus.');

        } catch (Exception $e) {
            set_flash('error', 'Gagal menghapus publikasi. Silakan coba lagi.');
        }

        redirect('/admin/publications');
    }
}
