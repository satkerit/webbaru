<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * ContactAdminController - Baca pesan kontak + tandai sudah dibaca
 */
class ContactAdminController extends BaseController
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
        $rbac->requirePermission('contacts.manage');

        $isReadFilter = $_GET['is_read'] ?? '';

        if ($isReadFilter === '0') {
            $query  = "SELECT * FROM contacts WHERE is_read = 0 ORDER BY created_at DESC";
            $params = [];
        } elseif ($isReadFilter === '1') {
            $query  = "SELECT * FROM contacts WHERE is_read = 1 ORDER BY created_at DESC";
            $params = [];
        } else {
            $query  = "SELECT * FROM contacts ORDER BY is_read ASC, created_at DESC";
            $params = [];
            $isReadFilter = '';
        }

        $pagination = $this->paginate($query, $params, 20);

        // Hitung pesan belum dibaca
        $stmt       = $this->db->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0");
        $unreadCount = (int) $stmt->fetchColumn();

        $this->render(
            'backend.layouts.dashboard',
            'backend.contacts.index',
            [
                'title'         => 'Pesan Kontak | ' . $this->setting('site_name'),
                'contacts'      => $pagination['data'],
                'pagination'    => $pagination,
                'isReadFilter'  => $isReadFilter,
                'unreadCount'   => $unreadCount,
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
        $rbac->requirePermission('contacts.manage');

        $stmt = $this->db->prepare("SELECT * FROM contacts WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $contact = $stmt->fetch();

        if (!$contact) {
            set_flash('error', 'Pesan tidak ditemukan.');
            redirect('/admin/contacts');
        }

        // Tandai sebagai sudah dibaca jika belum
        if (!(int) $contact['is_read']) {
            try {
                $stmtUpdate = $this->db->prepare("
                    UPDATE contacts
                    SET is_read = 1, read_at = NOW(), updated_at = NOW()
                    WHERE id = ? AND is_read = 0
                ");
                $stmtUpdate->execute([$id]);
                $contact['is_read'] = 1;
                $contact['read_at'] = date('Y-m-d H:i:s');
            } catch (Exception $e) {
                // Lanjut meskipun update gagal
            }
        }

        $this->render(
            'backend.layouts.dashboard',
            'backend.contacts.show',
            [
                'title'   => 'Detail Pesan Kontak | ' . $this->setting('site_name'),
                'contact' => $contact,
                'csrf'    => $this->security->csrfField(),
                'rbac'    => $rbac,
                'user'    => $_SESSION,
            ]
        );
    }

    public function markRead(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('contacts.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT id FROM contacts WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            set_flash('error', 'Pesan tidak ditemukan.');
            redirect('/admin/contacts');
        }

        try {
            $stmt = $this->db->prepare("
                UPDATE contacts
                SET is_read = 1, read_at = NOW(), updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$id]);

            set_flash('success', 'Pesan berhasil ditandai sudah dibaca.');

        } catch (Exception $e) {
            set_flash('error', 'Gagal menandai pesan. Silakan coba lagi.');
        }

        // Redirect back ke referer atau ke list
        $referer = $_SERVER['HTTP_REFERER'] ?? '/admin/contacts';
        redirect($referer);
    }
}
