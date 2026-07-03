<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * AboutController - Halaman Tentang Kami
 */
class AboutController extends BaseController
{
    public function index(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $this->render('frontend.layouts.main', 'frontend.pages.about.index', [
            'title'    => 'Tentang Kami | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'active'   => 'tentang',
        ]);
    }

    public function visiMisi(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare("SELECT * FROM pages WHERE page_type = 'vision_mission' AND is_active = 1 LIMIT 1");
        $stmt->execute();
        $page = $stmt->fetch();

        $this->render('frontend.layouts.main', 'frontend.pages.about.visi-misi', [
            'title'    => 'Visi & Misi | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'page'     => $page,
            'active'   => 'tentang',
        ]);
    }

    public function sejarah(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare("SELECT * FROM pages WHERE page_type = 'history' AND is_active = 1 LIMIT 1");
        $stmt->execute();
        $page = $stmt->fetch();

        $this->render('frontend.layouts.main', 'frontend.pages.about.sejarah', [
            'title'    => 'Sejarah | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'page'     => $page,
            'active'   => 'tentang',
        ]);
    }

    public function struktur(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare("SELECT * FROM pages WHERE page_type = 'structure' AND is_active = 1 LIMIT 1");
        $stmt->execute();
        $page = $stmt->fetch();

        $this->render('frontend.layouts.main', 'frontend.pages.about.struktur', [
            'title'    => 'Struktur Organisasi | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'page'     => $page,
            'active'   => 'tentang',
        ]);
    }

    public function lokasi(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $this->render('frontend.layouts.main', 'frontend.pages.about.lokasi', [
            'title'    => 'Lokasi Kantor | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'active'   => 'tentang',
        ]);
    }
}
