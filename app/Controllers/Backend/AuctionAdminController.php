<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * AuctionAdminController - CRUD Lelang Agunan
 */
class AuctionAdminController extends BaseController
{
    private Security $security;

    /** Status valid sesuai ENUM di database */
    private const VALID_STATUSES = ['upcoming', 'active', 'completed', 'cancelled'];

    /** Tipe aset valid sesuai ENUM di database */
    private const VALID_ASSET_TYPES = ['rumah', 'tanah', 'ruko', 'kendaraan', 'lainnya'];

    public function __construct()
    {
        parent::__construct();
        $this->security = new Security($this->db);
    }

    public function index(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('auctions.manage');

        $statusFilter = Security::sanitize($_GET['status'] ?? '', 'string');

        if ($statusFilter !== '' && in_array($statusFilter, self::VALID_STATUSES, true)) {
            $query  = "SELECT * FROM auctions WHERE status = ? ORDER BY start_date DESC";
            $params = [$statusFilter];
        } else {
            $query  = "SELECT * FROM auctions ORDER BY start_date DESC";
            $params = [];
            $statusFilter = '';
        }

        $pagination = $this->paginate($query, $params, 15);

        $this->render(
            'backend.layouts.dashboard',
            'backend.auctions.index',
            [
                'title'         => 'Manajemen Lelang | ' . $this->setting('site_name'),
                'auctions'      => $pagination['data'],
                'pagination'    => $pagination,
                'statusFilter'  => $statusFilter,
                'validStatuses' => self::VALID_STATUSES,
                'validAssetTypes' => self::VALID_ASSET_TYPES,
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
        $rbac->requirePermission('auctions.manage');

        $this->verifyCsrf();

        $title          = Security::sanitize($_POST['title'] ?? '', 'string');
        $description    = Security::sanitize($_POST['description'] ?? '', 'html');
        $assetType      = Security::sanitize($_POST['asset_type'] ?? '', 'string');
        $location       = Security::sanitize($_POST['location'] ?? '', 'string');
        $startingPrice  = $_POST['starting_price'] ?? '';
        $startDate      = Security::sanitize($_POST['start_date'] ?? '', 'string');
        $endDate        = Security::sanitize($_POST['end_date'] ?? '', 'string');
        $status         = Security::sanitize($_POST['status'] ?? 'upcoming', 'string');
        $contactPerson  = Security::sanitize($_POST['contact_person'] ?? '', 'string');
        $contactPhone   = Security::sanitize($_POST['contact_phone'] ?? '', 'string');
        $isActive       = isset($_POST['is_active']) ? 1 : 0;

        $errors = Security::validate($_POST, [
            'title'         => 'required',
            'asset_type'    => 'required|in:rumah,tanah,ruko,kendaraan,lainnya',
            'starting_price'=> 'required|numeric',
            'start_date'    => 'required',
            'end_date'      => 'required',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/auctions');
        }

        if (!in_array($status, self::VALID_STATUSES, true)) {
            $status = 'upcoming';
        }

        try {
            // Upload gambar jika ada
            $image = null;
            if (!empty($_FILES['image']['name'])) {
                $config = require APP_PATH . '/Config/app.php';
                $image  = $this->security->uploadFile(
                    $_FILES['image'],
                    'auctions',
                    $config['allowed_image_types']
                );
            }

            $stmt = $this->db->prepare("
                INSERT INTO auctions (title, description, asset_type, location, starting_price,
                                      start_date, end_date, status, image, contact_person,
                                      contact_phone, is_active, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $title, $description, $assetType, $location, (float) $startingPrice,
                $startDate, $endDate, $status, $image,
                $contactPerson, $contactPhone, $isActive,
            ]);

            set_flash('success', 'Lelang berhasil ditambahkan.');

        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
        } catch (Exception $e) {
            set_flash('error', 'Gagal menyimpan lelang. Silakan coba lagi.');
        }

        redirect('/admin/auctions');
    }

    public function update(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('auctions.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT * FROM auctions WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $auction = $stmt->fetch();

        if (!$auction) {
            set_flash('error', 'Data lelang tidak ditemukan.');
            redirect('/admin/auctions');
        }

        $title         = Security::sanitize($_POST['title'] ?? '', 'string');
        $description   = Security::sanitize($_POST['description'] ?? '', 'html');
        $assetType     = Security::sanitize($_POST['asset_type'] ?? '', 'string');
        $location      = Security::sanitize($_POST['location'] ?? '', 'string');
        $startingPrice = $_POST['starting_price'] ?? '';
        $startDate     = Security::sanitize($_POST['start_date'] ?? '', 'string');
        $endDate       = Security::sanitize($_POST['end_date'] ?? '', 'string');
        $status        = Security::sanitize($_POST['status'] ?? 'upcoming', 'string');
        $contactPerson = Security::sanitize($_POST['contact_person'] ?? '', 'string');
        $contactPhone  = Security::sanitize($_POST['contact_phone'] ?? '', 'string');
        $isActive      = isset($_POST['is_active']) ? 1 : 0;

        $errors = Security::validate($_POST, [
            'title'          => 'required',
            'asset_type'     => 'required|in:rumah,tanah,ruko,kendaraan,lainnya',
            'starting_price' => 'required|numeric',
            'start_date'     => 'required',
            'end_date'       => 'required',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/auctions');
        }

        if (!in_array($status, self::VALID_STATUSES, true)) {
            $status = 'upcoming';
        }

        try {
            $image = $auction['image'];

            // Upload gambar baru jika ada
            if (!empty($_FILES['image']['name'])) {
                $config  = require APP_PATH . '/Config/app.php';
                $newImg  = $this->security->uploadFile(
                    $_FILES['image'],
                    'auctions',
                    $config['allowed_image_types']
                );

                if ($image) {
                    $oldPath = $config['upload_path'] . '/auctions/' . $image;
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $image = $newImg;
            }

            $stmt = $this->db->prepare("
                UPDATE auctions
                SET title = ?, description = ?, asset_type = ?, location = ?,
                    starting_price = ?, start_date = ?, end_date = ?, status = ?,
                    image = ?, contact_person = ?, contact_phone = ?,
                    is_active = ?, updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([
                $title, $description, $assetType, $location, (float) $startingPrice,
                $startDate, $endDate, $status, $image,
                $contactPerson, $contactPhone, $isActive, $id,
            ]);

            set_flash('success', 'Lelang berhasil diperbarui.');

        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
        } catch (Exception $e) {
            set_flash('error', 'Gagal memperbarui lelang. Silakan coba lagi.');
        }

        redirect('/admin/auctions');
    }

    public function destroy(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('auctions.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT * FROM auctions WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $auction = $stmt->fetch();

        if (!$auction) {
            set_flash('error', 'Data lelang tidak ditemukan.');
            redirect('/admin/auctions');
        }

        try {
            // Hapus gambar
            if ($auction['image']) {
                $config  = require APP_PATH . '/Config/app.php';
                $imgPath = $config['upload_path'] . '/auctions/' . $auction['image'];
                if (file_exists($imgPath)) {
                    @unlink($imgPath);
                }
            }

            $stmt = $this->db->prepare("DELETE FROM auctions WHERE id = ?");
            $stmt->execute([$id]);

            set_flash('success', 'Data lelang berhasil dihapus.');

        } catch (Exception $e) {
            set_flash('error', 'Gagal menghapus lelang. Silakan coba lagi.');
        }

        redirect('/admin/auctions');
    }
}
