<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * HomeController - Halaman Beranda
 */
class HomeController extends BaseController
{
    public function index(): void
    {
        // Log visitor
        log_visitor($this->db);

        // Sliders aktif
        $stmt = $this->db->query(
            "SELECT * FROM sliders WHERE is_active = 1 ORDER BY display_order ASC LIMIT 5"
        );
        $sliders = $stmt->fetchAll();

        // Produk unggulan
        $stmt = $this->db->query(
            "SELECT * FROM products WHERE is_active = 1 AND is_featured = 1 ORDER BY display_order ASC LIMIT 6"
        );
        $featured_products = $stmt->fetchAll();

        // Berita terbaru
        $stmt = $this->db->prepare("
            SELECT a.*, c.name as category_name
            FROM articles a
            LEFT JOIN categories c ON a.category_id = c.id
            WHERE a.is_published = 1
            ORDER BY a.published_at DESC
            LIMIT 3
        ");
        $stmt->execute();
        $latest_articles = $stmt->fetchAll();

        // Stats perusahaan (dari settings)
        $settings = $this->getSettings();

        $this->render(
            'frontend.layouts.main',
            'frontend.pages.home',
            [
                'title'            => ($settings['meta_title'] ?? 'BPRS Bangka Belitung'),
                'meta_desc'        => $settings['meta_description'] ?? '',
                'meta_keywords'    => $settings['meta_keywords'] ?? '',
                'settings'         => $settings,
                'sliders'          => $sliders,
                'featured_products'=> $featured_products,
                'latest_articles'  => $latest_articles,
            ]
        );
    }
}
