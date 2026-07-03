<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * ManagementController - Halaman Manajemen / Dewan
 */
class ManagementController extends BaseController
{
    public function index(): void
    {
        log_visitor($this->db);
        redirect('/manajemen/dewan-komisaris');
    }

    public function komisaris(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare(
            "SELECT * FROM management WHERE type = 'komisaris' AND is_active = 1 ORDER BY display_order ASC"
        );
        $stmt->execute();
        $members = $stmt->fetchAll();

        $this->render('frontend.layouts.main', 'frontend.pages.management.komisaris', [
            'title'    => 'Dewan Komisaris | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'members'  => $members,
            'active'   => 'manajemen',
        ]);
    }

    public function direksi(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare(
            "SELECT * FROM management WHERE type = 'direksi' AND is_active = 1 ORDER BY display_order ASC"
        );
        $stmt->execute();
        $members = $stmt->fetchAll();

        $this->render('frontend.layouts.main', 'frontend.pages.management.direksi', [
            'title'    => 'Dewan Direksi | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'members'  => $members,
            'active'   => 'manajemen',
        ]);
    }

    public function pengawasSyariah(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare(
            "SELECT * FROM management WHERE type = 'pengawas_syariah' AND is_active = 1 ORDER BY display_order ASC"
        );
        $stmt->execute();
        $members = $stmt->fetchAll();

        $this->render('frontend.layouts.main', 'frontend.pages.management.pengawas-syariah', [
            'title'    => 'Dewan Pengawas Syariah | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'members'  => $members,
            'active'   => 'manajemen',
        ]);
    }
}
