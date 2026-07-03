<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * ProductAdminController - CRUD Produk (Tabungan, Deposito, Pembiayaan)
 */
class ProductAdminController extends BaseController
{
    private Security $security;

    /** Tipe produk valid sesuai ENUM di database */
    private const VALID_TYPES = ['tabungan', 'deposito', 'pembiayaan'];

    public function __construct()
    {
        parent::__construct();
        $this->security = new Security($this->db);
    }

    public function index(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('products.manage');

        $typeFilter = Security::sanitize($_GET['type'] ?? '', 'string');

        if ($typeFilter !== '' && in_array($typeFilter, self::VALID_TYPES, true)) {
            $query  = "SELECT * FROM products WHERE type = ? ORDER BY display_order ASC, name ASC";
            $params = [$typeFilter];
        } else {
            $query  = "SELECT * FROM products ORDER BY type ASC, display_order ASC, name ASC";
            $params = [];
            $typeFilter = '';
        }

        $pagination = $this->paginate($query, $params, 20);

        $this->render(
            'backend.layouts.dashboard',
            'backend.products.index',
            [
                'title'         => 'Manajemen Produk | ' . $this->setting('site_name'),
                'products'      => $pagination['data'],
                'pagination'    => $pagination,
                'typeFilter'    => $typeFilter,
                'validTypes'    => self::VALID_TYPES,
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
        $rbac->requirePermission('products.manage');

        $this->render(
            'backend.layouts.dashboard',
            'backend.products.create',
            [
                'title'      => 'Tambah Produk | ' . $this->setting('site_name'),
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
        $rbac->requirePermission('products.manage');

        $this->verifyCsrf();

        $name         = Security::sanitize($_POST['name'] ?? '', 'string');
        $type         = Security::sanitize($_POST['type'] ?? '', 'string');
        $description  = Security::sanitize($_POST['description'] ?? '', 'html');
        $features     = Security::sanitize($_POST['features'] ?? '', 'html');
        $requirements = Security::sanitize($_POST['requirements'] ?? '', 'html');
        $benefits     = Security::sanitize($_POST['benefits'] ?? '', 'html');
        $displayOrder = (int) ($_POST['display_order'] ?? 0);
        $isFeatured   = isset($_POST['is_featured']) ? 1 : 0;
        $isActive     = isset($_POST['is_active']) ? 1 : 0;

        $errors = Security::validate($_POST, [
            'name'        => 'required',
            'type'        => 'required|in:tabungan,deposito,pembiayaan',
            'description' => 'required',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/products/create');
        }

        try {
            // Generate slug unik
            $baseSlug = str_slug($name);
            $slug     = $baseSlug;
            $counter  = 2;

            while (true) {
                $stmt = $this->db->prepare("SELECT id FROM products WHERE slug = ? LIMIT 1");
                $stmt->execute([$slug]);
                if (!$stmt->fetch()) break;
                $slug = $baseSlug . '-' . $counter++;
            }

            // Upload gambar produk jika ada
            $image = null;
            if (!empty($_FILES['image']['name'])) {
                $config = require APP_PATH . '/Config/app.php';
                $image  = $this->security->uploadFile(
                    $_FILES['image'],
                    'products',
                    $config['allowed_image_types']
                );
            }

            $stmt = $this->db->prepare("
                INSERT INTO products (name, slug, type, description, features, requirements, benefits,
                                      image, is_featured, is_active, display_order, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $name, $slug, $type, $description, $features, $requirements, $benefits,
                $image, $isFeatured, $isActive, $displayOrder,
            ]);

            set_flash('success', 'Produk berhasil ditambahkan.');
            redirect('/admin/products');

        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
            redirect('/admin/products/create');
        } catch (Exception $e) {
            set_flash('error', 'Gagal menyimpan produk. Silakan coba lagi.');
            redirect('/admin/products/create');
        }
    }

    public function edit(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('products.manage');

        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if (!$product) {
            set_flash('error', 'Produk tidak ditemukan.');
            redirect('/admin/products');
        }

        $this->render(
            'backend.layouts.dashboard',
            'backend.products.edit',
            [
                'title'      => 'Edit Produk | ' . $this->setting('site_name'),
                'product'    => $product,
                'validTypes' => self::VALID_TYPES,
                'csrf'       => $this->security->csrfField(),
                'rbac'       => $rbac,
                'user'       => $_SESSION,
                'flash_error' => flash('error'),
            ]
        );
    }

    public function update(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('products.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if (!$product) {
            set_flash('error', 'Produk tidak ditemukan.');
            redirect('/admin/products');
        }

        $name         = Security::sanitize($_POST['name'] ?? '', 'string');
        $type         = Security::sanitize($_POST['type'] ?? '', 'string');
        $description  = Security::sanitize($_POST['description'] ?? '', 'html');
        $features     = Security::sanitize($_POST['features'] ?? '', 'html');
        $requirements = Security::sanitize($_POST['requirements'] ?? '', 'html');
        $benefits     = Security::sanitize($_POST['benefits'] ?? '', 'html');
        $displayOrder = (int) ($_POST['display_order'] ?? 0);
        $isFeatured   = isset($_POST['is_featured']) ? 1 : 0;
        $isActive     = isset($_POST['is_active']) ? 1 : 0;

        $errors = Security::validate($_POST, [
            'name'        => 'required',
            'type'        => 'required|in:tabungan,deposito,pembiayaan',
            'description' => 'required',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/products/' . $id . '/edit');
        }

        try {
            // Generate slug unik jika nama berubah
            $slug = $product['slug'];
            if ($name !== $product['name']) {
                $baseSlug = str_slug($name);
                $slug     = $baseSlug;
                $counter  = 2;

                while (true) {
                    $stmt = $this->db->prepare("SELECT id FROM products WHERE slug = ? AND id != ? LIMIT 1");
                    $stmt->execute([$slug, $id]);
                    if (!$stmt->fetch()) break;
                    $slug = $baseSlug . '-' . $counter++;
                }
            }

            // Upload gambar baru jika ada
            $image = $product['image'];
            if (!empty($_FILES['image']['name'])) {
                $config  = require APP_PATH . '/Config/app.php';
                $newImg  = $this->security->uploadFile(
                    $_FILES['image'],
                    'products',
                    $config['allowed_image_types']
                );

                if ($image) {
                    $oldPath = $config['upload_path'] . '/products/' . $image;
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $image = $newImg;
            }

            $stmt = $this->db->prepare("
                UPDATE products
                SET name = ?, slug = ?, type = ?, description = ?, features = ?,
                    requirements = ?, benefits = ?, image = ?, is_featured = ?,
                    is_active = ?, display_order = ?, updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([
                $name, $slug, $type, $description, $features, $requirements, $benefits,
                $image, $isFeatured, $isActive, $displayOrder, $id,
            ]);

            set_flash('success', 'Produk berhasil diperbarui.');
            redirect('/admin/products');

        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
            redirect('/admin/products/' . $id . '/edit');
        } catch (Exception $e) {
            set_flash('error', 'Gagal memperbarui produk. Silakan coba lagi.');
            redirect('/admin/products/' . $id . '/edit');
        }
    }

    public function destroy(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('products.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if (!$product) {
            set_flash('error', 'Produk tidak ditemukan.');
            redirect('/admin/products');
        }

        try {
            // Hapus gambar produk
            if ($product['image']) {
                $config  = require APP_PATH . '/Config/app.php';
                $imgPath = $config['upload_path'] . '/products/' . $product['image'];
                if (file_exists($imgPath)) {
                    @unlink($imgPath);
                }
            }

            $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$id]);

            set_flash('success', 'Produk berhasil dihapus.');

        } catch (Exception $e) {
            set_flash('error', 'Gagal menghapus produk. Silakan coba lagi.');
        }

        redirect('/admin/products');
    }
}
