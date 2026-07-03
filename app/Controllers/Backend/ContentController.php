<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * ContentController - Manajemen Slider / Konten Homepage
 */
class ContentController extends BaseController
{
    private Security $security;

    public function __construct()
    {
        parent::__construct();
        $this->security = new Security($this->db);
    }

    // ----------------------------------------------------------------
    // SLIDERS
    // ----------------------------------------------------------------

    public function sliders(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('content.manage');

        $stmt    = $this->db->query("SELECT * FROM sliders ORDER BY display_order ASC, id ASC");
        $sliders = $stmt->fetchAll();

        $this->render(
            'backend.layouts.dashboard',
            'backend.content.sliders',
            [
                'title'         => 'Manajemen Slider | ' . $this->setting('site_name'),
                'sliders'       => $sliders,
                'csrf'          => $this->security->csrfField(),
                'rbac'          => $rbac,
                'user'          => $_SESSION,
                'flash_success' => flash('success'),
                'flash_error'   => flash('error'),
            ]
        );
    }

    public function storeSlider(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('content.manage');

        $this->verifyCsrf();

        $title        = Security::sanitize($_POST['title'] ?? '', 'string');
        $subtitle     = Security::sanitize($_POST['subtitle'] ?? '', 'string');
        $description  = Security::sanitize($_POST['description'] ?? '', 'string');
        $buttonText   = Security::sanitize($_POST['button_text'] ?? '', 'string');
        $buttonLink   = Security::sanitize($_POST['button_link'] ?? '', 'string');
        $displayOrder = (int) ($_POST['display_order'] ?? 0);
        $isActive     = isset($_POST['is_active']) ? 1 : 0;

        $errors = Security::validate($_POST, [
            'title' => 'required',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/content/sliders');
        }

        // Upload gambar (wajib untuk slider baru)
        if (empty($_FILES['image']['name'])) {
            set_flash('error', 'Gambar slider wajib diunggah.');
            redirect('/admin/content/sliders');
        }

        try {
            $config    = require APP_PATH . '/Config/app.php';
            $filename  = $this->security->uploadFile(
                $_FILES['image'],
                'sliders',
                $config['allowed_image_types']
            );

            $stmt = $this->db->prepare("
                INSERT INTO sliders (title, subtitle, image, description, button_text, button_link,
                                     display_order, is_active, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $title, $subtitle, $filename, $description,
                $buttonText, $buttonLink, $displayOrder, $isActive,
            ]);

            set_flash('success', 'Slider berhasil ditambahkan.');

        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
        } catch (Exception $e) {
            set_flash('error', 'Gagal menyimpan slider. Silakan coba lagi.');
        }

        redirect('/admin/content/sliders');
    }

    public function updateSlider(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('content.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT * FROM sliders WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $slider = $stmt->fetch();

        if (!$slider) {
            set_flash('error', 'Slider tidak ditemukan.');
            redirect('/admin/content/sliders');
        }

        $title        = Security::sanitize($_POST['title'] ?? '', 'string');
        $subtitle     = Security::sanitize($_POST['subtitle'] ?? '', 'string');
        $description  = Security::sanitize($_POST['description'] ?? '', 'string');
        $buttonText   = Security::sanitize($_POST['button_text'] ?? '', 'string');
        $buttonLink   = Security::sanitize($_POST['button_link'] ?? '', 'string');
        $displayOrder = (int) ($_POST['display_order'] ?? 0);
        $isActive     = isset($_POST['is_active']) ? 1 : 0;

        $errors = Security::validate($_POST, [
            'title' => 'required',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/content/sliders');
        }

        try {
            $imageName = $slider['image'];

            // Upload gambar baru jika ada
            if (!empty($_FILES['image']['name'])) {
                $config   = require APP_PATH . '/Config/app.php';
                $newImage = $this->security->uploadFile(
                    $_FILES['image'],
                    'sliders',
                    $config['allowed_image_types']
                );

                // Hapus gambar lama
                if ($imageName) {
                    $oldPath = $config['upload_path'] . '/sliders/' . $imageName;
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $imageName = $newImage;
            }

            $stmt = $this->db->prepare("
                UPDATE sliders
                SET title = ?, subtitle = ?, image = ?, description = ?, button_text = ?,
                    button_link = ?, display_order = ?, is_active = ?, updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([
                $title, $subtitle, $imageName, $description,
                $buttonText, $buttonLink, $displayOrder, $isActive, $id,
            ]);

            set_flash('success', 'Slider berhasil diperbarui.');

        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
        } catch (Exception $e) {
            set_flash('error', 'Gagal memperbarui slider. Silakan coba lagi.');
        }

        redirect('/admin/content/sliders');
    }

    public function deleteSlider(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('content.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT * FROM sliders WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $slider = $stmt->fetch();

        if (!$slider) {
            set_flash('error', 'Slider tidak ditemukan.');
            redirect('/admin/content/sliders');
        }

        try {
            // Hapus file gambar
            if ($slider['image']) {
                $config  = require APP_PATH . '/Config/app.php';
                $imgPath = $config['upload_path'] . '/sliders/' . $slider['image'];
                if (file_exists($imgPath)) {
                    @unlink($imgPath);
                }
            }

            $stmt = $this->db->prepare("DELETE FROM sliders WHERE id = ?");
            $stmt->execute([$id]);

            set_flash('success', 'Slider berhasil dihapus.');

        } catch (Exception $e) {
            set_flash('error', 'Gagal menghapus slider. Silakan coba lagi.');
        }

        redirect('/admin/content/sliders');
    }
}
