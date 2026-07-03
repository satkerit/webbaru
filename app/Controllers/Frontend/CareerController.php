<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * CareerController - Lowongan Kerja
 */
class CareerController extends BaseController
{
    public function index(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->query(
            "SELECT * FROM careers WHERE is_active = 1 AND (deadline IS NULL OR deadline >= CURDATE()) ORDER BY created_at DESC"
        );
        $careers = $stmt->fetchAll();

        $this->render('frontend.layouts.main', 'frontend.pages.career', [
            'title'    => 'Lowongan Kerja | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'careers'  => $careers,
            'active'   => 'karir',
        ]);
    }

    public function detail(?string $id = null): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare("SELECT * FROM careers WHERE id = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([(int) $id]);
        $career = $stmt->fetch();

        if (!$career) {
            http_response_code(404);
            $this->render('frontend.layouts.main', 'errors.404', ['settings' => $settings, 'title' => '404']);
            return;
        }

        $this->render('frontend.layouts.main', 'frontend.pages.career-detail', [
            'title'    => $career['title'] . ' | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'career'   => $career,
            'active'   => 'karir',
        ]);
    }
}
