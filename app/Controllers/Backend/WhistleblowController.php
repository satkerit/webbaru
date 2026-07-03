<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * WhistleblowController - Read-only + manajemen status laporan Whistleblowing
 */
class WhistleblowController extends BaseController
{
    private Security $security;

    /** Status valid sesuai ENUM di database */
    private const VALID_STATUSES = ['new', 'in_review', 'investigating', 'resolved', 'rejected'];

    public function __construct()
    {
        parent::__construct();
        $this->security = new Security($this->db);
    }

    public function index(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('whistleblows.manage');

        $statusFilter = Security::sanitize($_GET['status'] ?? '', 'string');

        if ($statusFilter !== '' && in_array($statusFilter, self::VALID_STATUSES, true)) {
            $query  = "SELECT * FROM whistleblows WHERE status = ? ORDER BY created_at DESC";
            $params = [$statusFilter];
        } else {
            $query  = "SELECT * FROM whistleblows ORDER BY created_at DESC";
            $params = [];
            $statusFilter = '';
        }

        $pagination = $this->paginate($query, $params, 15);

        // Hitung per status untuk badge
        $stmt = $this->db->query("
            SELECT status, COUNT(*) as total
            FROM whistleblows
            GROUP BY status
        ");
        $statusCounts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $this->render(
            'backend.layouts.dashboard',
            'backend.whistleblows.index',
            [
                'title'         => 'Laporan Whistleblowing | ' . $this->setting('site_name'),
                'whistleblows'  => $pagination['data'],
                'pagination'    => $pagination,
                'statusFilter'  => $statusFilter,
                'validStatuses' => self::VALID_STATUSES,
                'statusCounts'  => $statusCounts,
                'csrf'          => $this->security->csrfField(),
                'rbac'          => $rbac,
                'user'          => $_SESSION,
                'flash_success' => flash('success'),
                'flash_error'   => flash('error'),
            ]
        );
    }

    public function show(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('whistleblows.manage');

        $stmt = $this->db->prepare("SELECT * FROM whistleblows WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $whistleblow = $stmt->fetch();

        if (!$whistleblow) {
            set_flash('error', 'Laporan tidak ditemukan.');
            redirect('/admin/whistleblows');
        }

        // Ubah status ke in_review jika masih new
        if ($whistleblow['status'] === 'new') {
            try {
                $stmtUpdate = $this->db->prepare("
                    UPDATE whistleblows SET status = 'in_review', updated_at = NOW()
                    WHERE id = ? AND status = 'new'
                ");
                $stmtUpdate->execute([$id]);
                $whistleblow['status'] = 'in_review';
            } catch (Exception $e) {
                // Lanjut meskipun update gagal
            }
        }

        $this->render(
            'backend.layouts.dashboard',
            'backend.whistleblows.show',
            [
                'title'        => 'Detail Laporan Whistleblowing | ' . $this->setting('site_name'),
                'whistleblow'  => $whistleblow,
                'validStatuses'=> self::VALID_STATUSES,
                'csrf'         => $this->security->csrfField(),
                'rbac'         => $rbac,
                'user'         => $_SESSION,
                'flash_success' => flash('success'),
                'flash_error'   => flash('error'),
            ]
        );
    }

    public function updateStatus(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('whistleblows.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT id FROM whistleblows WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            set_flash('error', 'Laporan tidak ditemukan.');
            redirect('/admin/whistleblows');
        }

        $status     = Security::sanitize($_POST['status'] ?? '', 'string');
        $adminNotes = Security::sanitize($_POST['admin_notes'] ?? '', 'string');

        $errors = Security::validate($_POST, [
            'status' => 'required|in:new,in_review,investigating,resolved,rejected',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/whistleblows/' . $id);
        }

        try {
            $stmt = $this->db->prepare("
                UPDATE whistleblows
                SET status = ?, admin_notes = ?, updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$status, $adminNotes, $id]);

            set_flash('success', 'Status laporan berhasil diperbarui.');

        } catch (Exception $e) {
            set_flash('error', 'Gagal memperbarui status laporan. Silakan coba lagi.');
        }

        redirect('/admin/whistleblows/' . $id);
    }
}
