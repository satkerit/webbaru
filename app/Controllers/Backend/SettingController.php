<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * SettingController - Manajemen pengaturan website
 */
class SettingController extends BaseController
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
        $rbac->requirePermission('settings.manage');

        // Ambil semua settings dikelompokkan per setting_group
        $stmt     = $this->db->query("SELECT * FROM settings ORDER BY setting_group, id ASC");
        $rawSettings = $stmt->fetchAll();

        $grouped = [];
        foreach ($rawSettings as $row) {
            $grouped[$row['setting_group']][] = $row;
        }

        $this->render(
            'backend.layouts.dashboard',
            'backend.settings.index',
            [
                'title'         => 'Pengaturan Website | ' . $this->setting('site_name'),
                'grouped'       => $grouped,
                'csrf'          => $this->security->csrfField(),
                'rbac'          => $rbac,
                'user'          => $_SESSION,
                'flash_success' => flash('success'),
                'flash_error'   => flash('error'),
            ]
        );
    }

    public function update(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('settings.manage');

        $this->verifyCsrf();

        // Ambil semua kunci setting yang valid dari database agar tidak bisa inject kunci sembarangan
        $stmt       = $this->db->query("SELECT setting_key FROM settings");
        $validKeys  = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $validKeys  = array_flip($validKeys); // untuk lookup O(1)

        $successCount = 0;
        $errorCount   = 0;

        try {
            $stmtUpdate = $this->db->prepare("
                UPDATE settings
                SET setting_value = ?, updated_at = NOW()
                WHERE setting_key = ?
            ");

            foreach ($_POST as $key => $value) {
                // Lewati field sistem
                if ($key === 'csrf_token') {
                    continue;
                }

                // Hanya proses kunci yang ada di database
                if (!isset($validKeys[$key])) {
                    continue;
                }

                $sanitizedValue = Security::sanitize((string) $value, 'string');

                $stmtUpdate->execute([$sanitizedValue, $key]);
                $successCount++;
            }

            if ($successCount > 0) {
                set_flash('success', 'Pengaturan berhasil disimpan (' . $successCount . ' item diperbarui).');
            } else {
                set_flash('error', 'Tidak ada pengaturan yang diperbarui.');
            }

        } catch (Exception $e) {
            set_flash('error', 'Gagal menyimpan pengaturan. Silakan coba lagi.');
        }

        redirect('/admin/settings');
    }
}
