<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * ArticleAdminController - CRUD Artikel
 */
class ArticleAdminController extends BaseController
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
        $rbac->requirePermission('articles.manage');

        $query = "
            SELECT a.id, a.title, a.slug, a.is_published, a.published_at, a.views, a.created_at,
                   c.name AS category_name,
                   u.full_name AS author_name
            FROM articles a
            LEFT JOIN categories c ON a.category_id = c.id
            LEFT JOIN users u ON a.author_id = u.id
            ORDER BY a.created_at DESC
        ";

        $pagination = $this->paginate($query, [], 15);

        $this->render(
            'backend.layouts.dashboard',
            'backend.articles.index',
            [
                'title'         => 'Manajemen Artikel | ' . $this->setting('site_name'),
                'articles'      => $pagination['data'],
                'pagination'    => $pagination,
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
        $rbac->requirePermission('articles.manage');

        $stmt       = $this->db->query("SELECT id, name FROM categories WHERE type = 'article' ORDER BY name ASC");
        $categories = $stmt->fetchAll();

        $this->render(
            'backend.layouts.dashboard',
            'backend.articles.create',
            [
                'title'      => 'Tambah Artikel | ' . $this->setting('site_name'),
                'categories' => $categories,
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
        $rbac->requirePermission('articles.manage');

        $this->verifyCsrf();

        $title        = Security::sanitize($_POST['title'] ?? '', 'string');
        $content      = Security::sanitize($_POST['content'] ?? '', 'html');
        $excerpt      = Security::sanitize($_POST['excerpt'] ?? '', 'string');
        $categoryId   = (int) ($_POST['category_id'] ?? 0);
        $isPublished  = isset($_POST['is_published']) ? 1 : 0;
        $metaTitle    = Security::sanitize($_POST['meta_title'] ?? '', 'string');
        $metaDesc     = Security::sanitize($_POST['meta_description'] ?? '', 'string');
        $metaKeywords = Security::sanitize($_POST['meta_keywords'] ?? '', 'string');

        $errors = Security::validate($_POST, [
            'title'       => 'required|min:3|max:255',
            'content'     => 'required|min:10',
            'category_id' => 'required',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/articles/create');
        }

        try {
            // Generate slug unik
            $baseSlug = str_slug($title);
            $slug     = $baseSlug;
            $counter  = 2;

            while (true) {
                $stmt = $this->db->prepare("SELECT id FROM articles WHERE slug = ? LIMIT 1");
                $stmt->execute([$slug]);
                if (!$stmt->fetch()) break;
                $slug = $baseSlug . '-' . $counter++;
            }

            // Upload featured image jika ada
            $featuredImage = null;
            if (!empty($_FILES['featured_image']['name'])) {
                $config        = require APP_PATH . '/Config/app.php';
                $featuredImage = $this->security->uploadFile(
                    $_FILES['featured_image'],
                    'articles',
                    $config['allowed_image_types']
                );
            }

            $authorId    = (int) $_SESSION['user_id'];
            $publishedAt = $isPublished ? date('Y-m-d H:i:s') : null;

            $stmt = $this->db->prepare("
                INSERT INTO articles (title, slug, content, excerpt, featured_image, category_id,
                                      author_id, is_published, published_at, meta_title,
                                      meta_description, meta_keywords, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([
                $title, $slug, $content, $excerpt, $featuredImage, $categoryId,
                $authorId, $isPublished, $publishedAt, $metaTitle, $metaDesc, $metaKeywords,
            ]);

            set_flash('success', 'Artikel berhasil ditambahkan.');
            redirect('/admin/articles');

        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
            redirect('/admin/articles/create');
        } catch (Exception $e) {
            set_flash('error', 'Gagal menyimpan artikel. Silakan coba lagi.');
            redirect('/admin/articles/create');
        }
    }

    public function edit(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('articles.manage');

        $stmt = $this->db->prepare("SELECT * FROM articles WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            set_flash('error', 'Artikel tidak ditemukan.');
            redirect('/admin/articles');
        }

        $stmt       = $this->db->query("SELECT id, name FROM categories WHERE type = 'article' ORDER BY name ASC");
        $categories = $stmt->fetchAll();

        $this->render(
            'backend.layouts.dashboard',
            'backend.articles.edit',
            [
                'title'      => 'Edit Artikel | ' . $this->setting('site_name'),
                'article'    => $article,
                'categories' => $categories,
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
        $rbac->requirePermission('articles.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT * FROM articles WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            set_flash('error', 'Artikel tidak ditemukan.');
            redirect('/admin/articles');
        }

        $title        = Security::sanitize($_POST['title'] ?? '', 'string');
        $content      = Security::sanitize($_POST['content'] ?? '', 'html');
        $excerpt      = Security::sanitize($_POST['excerpt'] ?? '', 'string');
        $categoryId   = (int) ($_POST['category_id'] ?? 0);
        $isPublished  = isset($_POST['is_published']) ? 1 : 0;
        $metaTitle    = Security::sanitize($_POST['meta_title'] ?? '', 'string');
        $metaDesc     = Security::sanitize($_POST['meta_description'] ?? '', 'string');
        $metaKeywords = Security::sanitize($_POST['meta_keywords'] ?? '', 'string');

        $errors = Security::validate($_POST, [
            'title'       => 'required|min:3|max:255',
            'content'     => 'required|min:10',
            'category_id' => 'required',
        ]);

        if ($errors !== true) {
            set_flash('error', implode(' ', array_merge(...array_values($errors))));
            redirect('/admin/articles/' . $id . '/edit');
        }

        try {
            // Generate slug unik jika title berubah
            $slug = $article['slug'];
            if ($title !== $article['title']) {
                $baseSlug = str_slug($title);
                $slug     = $baseSlug;
                $counter  = 2;

                while (true) {
                    $stmt = $this->db->prepare("SELECT id FROM articles WHERE slug = ? AND id != ? LIMIT 1");
                    $stmt->execute([$slug, $id]);
                    if (!$stmt->fetch()) break;
                    $slug = $baseSlug . '-' . $counter++;
                }
            }

            // Upload featured image baru jika ada
            $featuredImage = $article['featured_image'];
            if (!empty($_FILES['featured_image']['name'])) {
                $config = require APP_PATH . '/Config/app.php';
                $newImg = $this->security->uploadFile(
                    $_FILES['featured_image'],
                    'articles',
                    $config['allowed_image_types']
                );

                // Hapus gambar lama
                if ($featuredImage) {
                    $oldPath = $config['upload_path'] . '/articles/' . $featuredImage;
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $featuredImage = $newImg;
            }

            // Set published_at jika artikel dipublish pertama kali
            $publishedAt = $article['published_at'];
            if ($isPublished && !$publishedAt) {
                $publishedAt = date('Y-m-d H:i:s');
            }

            $stmt = $this->db->prepare("
                UPDATE articles
                SET title = ?, slug = ?, content = ?, excerpt = ?, featured_image = ?,
                    category_id = ?, is_published = ?, published_at = ?, meta_title = ?,
                    meta_description = ?, meta_keywords = ?, updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([
                $title, $slug, $content, $excerpt, $featuredImage, $categoryId,
                $isPublished, $publishedAt, $metaTitle, $metaDesc, $metaKeywords, $id,
            ]);

            set_flash('success', 'Artikel berhasil diperbarui.');
            redirect('/admin/articles');

        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
            redirect('/admin/articles/' . $id . '/edit');
        } catch (Exception $e) {
            set_flash('error', 'Gagal memperbarui artikel. Silakan coba lagi.');
            redirect('/admin/articles/' . $id . '/edit');
        }
    }

    public function destroy(int $id): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('articles.manage');

        $this->verifyCsrf();

        $stmt = $this->db->prepare("SELECT * FROM articles WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            set_flash('error', 'Artikel tidak ditemukan.');
            redirect('/admin/articles');
        }

        try {
            // Hapus featured image
            if ($article['featured_image']) {
                $config  = require APP_PATH . '/Config/app.php';
                $imgPath = $config['upload_path'] . '/articles/' . $article['featured_image'];
                if (file_exists($imgPath)) {
                    @unlink($imgPath);
                }
            }

            $stmt = $this->db->prepare("DELETE FROM articles WHERE id = ?");
            $stmt->execute([$id]);

            set_flash('success', 'Artikel berhasil dihapus.');

        } catch (Exception $e) {
            set_flash('error', 'Gagal menghapus artikel. Silakan coba lagi.');
        }

        redirect('/admin/articles');
    }
}
