<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * ProductController - Halaman Produk & Layanan
 */
class ProductController extends BaseController
{
    public function index(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->query("SELECT * FROM products WHERE is_active = 1 ORDER BY display_order ASC");
        $products = $stmt->fetchAll();

        $this->render('frontend.layouts.main', 'frontend.pages.products.index', [
            'title'    => 'Produk & Layanan | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'products' => $products,
            'active'   => 'produk',
        ]);
    }

    public function detail(?string $slug = null): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare("SELECT * FROM products WHERE slug = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$slug]);
        $product = $stmt->fetch();

        if (!$product) {
            http_response_code(404);
            $this->render('frontend.layouts.main', 'errors.404', ['settings' => $settings, 'title' => '404']);
            return;
        }

        // Produk terkait
        $stmt = $this->db->prepare(
            "SELECT * FROM products WHERE type = ? AND is_active = 1 AND id != ? ORDER BY display_order ASC LIMIT 3"
        );
        $stmt->execute([$product['type'], $product['id']]);
        $related = $stmt->fetchAll();

        $this->render('frontend.layouts.main', 'frontend.pages.products.detail', [
            'title'    => $product['name'] . ' | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'product'  => $product,
            'related'  => $related,
            'active'   => 'produk',
        ]);
    }

    public function tabungan(): void
    {
        $this->byType('tabungan', 'Tabungan');
    }

    public function deposito(): void
    {
        $this->byType('deposito', 'Deposito');
    }

    public function pembiayaan(): void
    {
        $this->byType('pembiayaan', 'Pembiayaan');
    }

    private function byType(string $type, string $label): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare("SELECT * FROM products WHERE type = ? AND is_active = 1 ORDER BY display_order ASC");
        $stmt->execute([$type]);
        $products = $stmt->fetchAll();

        $this->render('frontend.layouts.main', 'frontend.pages.products.index', [
            'title'        => $label . ' | ' . ($settings['site_name'] ?? ''),
            'settings'     => $settings,
            'products'     => $products,
            'current_type' => $type,
            'type_label'   => $label,
            'active'       => 'produk',
        ]);
    }

    public function faq(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        // FAQ dari pages atau hard-coded
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE page_type = 'faq' AND is_active = 1 LIMIT 1");
        $stmt->execute();
        $faqPage = $stmt->fetch();

        $this->render('frontend.layouts.main', 'frontend.pages.products.faq', [
            'title'    => 'FAQ | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'faqPage'  => $faqPage,
            'active'   => 'produk',
        ]);
    }
}
