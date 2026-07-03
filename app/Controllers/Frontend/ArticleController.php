<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * ArticleController - Blog & Berita
 */
class ArticleController extends BaseController
{
    public function index(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $result = $this->paginate(
            "SELECT a.*, c.name as category_name, c.slug as category_slug
             FROM articles a
             LEFT JOIN categories c ON a.category_id = c.id
             WHERE a.is_published = 1
             ORDER BY a.published_at DESC",
            [],
            9
        );

        $stmt = $this->db->query("SELECT * FROM categories WHERE type = 'article'");
        $categories = $stmt->fetchAll();

        $this->render('frontend.layouts.main', 'frontend.pages.articles.index', [
            'title'      => 'Berita & Informasi | ' . ($settings['site_name'] ?? ''),
            'settings'   => $settings,
            'articles'   => $result['data'],
            'pagination' => $result,
            'categories' => $categories,
            'active'     => 'berita',
        ]);
    }

    public function detail(?string $slug = null): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare("
            SELECT a.*, c.name as category_name, c.slug as category_slug,
                   u.full_name as author_name
            FROM articles a
            LEFT JOIN categories c ON a.category_id = c.id
            LEFT JOIN users u ON a.author_id = u.id
            WHERE a.slug = ? AND a.is_published = 1
            LIMIT 1
        ");
        $stmt->execute([$slug]);
        $article = $stmt->fetch();

        if (!$article) {
            http_response_code(404);
            $this->render('frontend.layouts.main', 'errors.404', ['settings' => $settings, 'title' => '404']);
            return;
        }

        // Tambah view count
        $this->db->prepare("UPDATE articles SET views = views + 1 WHERE id = ?")->execute([$article['id']]);

        // Artikel terkait
        $stmt = $this->db->prepare("
            SELECT * FROM articles
            WHERE is_published = 1 AND id != ? AND category_id = ?
            ORDER BY published_at DESC LIMIT 3
        ");
        $stmt->execute([$article['id'], $article['category_id']]);
        $related = $stmt->fetchAll();

        $this->render('frontend.layouts.main', 'frontend.pages.articles.detail', [
            'title'    => $article['meta_title'] ?: ($article['title'] . ' | ' . ($settings['site_name'] ?? '')),
            'meta_desc'=> $article['meta_description'] ?: make_excerpt($article['content'], 160),
            'settings' => $settings,
            'article'  => $article,
            'related'  => $related,
            'active'   => 'berita',
        ]);
    }

    public function kategori(?string $slug = null): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare("SELECT * FROM categories WHERE slug = ? AND type = 'article' LIMIT 1");
        $stmt->execute([$slug]);
        $category = $stmt->fetch();

        if (!$category) {
            redirect('/berita');
        }

        $result = $this->paginate(
            "SELECT a.*, c.name as category_name, c.slug as category_slug
             FROM articles a
             LEFT JOIN categories c ON a.category_id = c.id
             WHERE a.is_published = 1 AND a.category_id = ?
             ORDER BY a.published_at DESC",
            [(int) $category['id']],
            9
        );

        $stmt = $this->db->query("SELECT * FROM categories WHERE type = 'article'");
        $categories = $stmt->fetchAll();

        $this->render('frontend.layouts.main', 'frontend.pages.articles.index', [
            'title'      => 'Kategori: ' . $category['name'] . ' | ' . ($settings['site_name'] ?? ''),
            'settings'   => $settings,
            'articles'   => $result['data'],
            'pagination' => $result,
            'categories' => $categories,
            'current_cat'=> $category,
            'active'     => 'berita',
        ]);
    }
}
