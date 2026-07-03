<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * PublicationController - Laporan & Publikasi
 */
class PublicationController extends BaseController
{
    public function index(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->query("SELECT * FROM publications WHERE is_active = 1 ORDER BY year DESC, created_at DESC");
        $publications = $stmt->fetchAll();

        $grouped = [];
        foreach ($publications as $pub) {
            $grouped[$pub['type']][] = $pub;
        }

        $this->render('frontend.layouts.main', 'frontend.pages.publications.index', [
            'title'       => 'Publikasi | ' . ($settings['site_name'] ?? ''),
            'settings'    => $settings,
            'publications'=> $grouped,
            'active'      => 'publikasi',
        ]);
    }

    public function keuangan(): void
    {
        $this->byType('laporan_keuangan', 'Laporan Keuangan Publikasi');
    }

    public function tataKelola(): void
    {
        $this->byType('laporan_tata_kelola', 'Laporan Tata Kelola');
    }

    public function tahunan(): void
    {
        $this->byType('laporan_tahunan', 'Laporan Tahunan');
    }

    public function berkelanjutan(): void
    {
        $this->byType('laporan_berkelanjutan', 'Laporan Berkelanjutan');
    }

    private function byType(string $type, string $label): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare(
            "SELECT * FROM publications WHERE type = ? AND is_active = 1 ORDER BY year DESC, created_at DESC"
        );
        $stmt->execute([$type]);
        $publications = $stmt->fetchAll();

        $this->render('frontend.layouts.main', 'frontend.pages.publications.list', [
            'title'       => $label . ' | ' . ($settings['site_name'] ?? ''),
            'settings'    => $settings,
            'publications'=> $publications,
            'type_label'  => $label,
            'active'      => 'publikasi',
        ]);
    }

    public function download(?string $id = null): void
    {
        $stmt = $this->db->prepare("SELECT * FROM publications WHERE id = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([(int) $id]);
        $pub = $stmt->fetch();

        if (!$pub) {
            http_response_code(404);
            echo '404 - File tidak ditemukan.';
            return;
        }

        // Tambah download count
        $this->db->prepare("UPDATE publications SET download_count = download_count + 1 WHERE id = ?")
                 ->execute([$pub['id']]);

        $filePath = BASE_PATH . '/public/uploads/publications/' . $pub['file_path'];

        if (!file_exists($filePath)) {
            http_response_code(404);
            echo 'File tidak ditemukan di server.';
            return;
        }

        // Sanitasi nama file untuk header
        $filename = basename($pub['file_path']);
        $safeTitle = preg_replace('/[^a-zA-Z0-9_\-.]/', '_', $pub['title']);

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $safeTitle . '.pdf"');
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: no-cache, no-store, must-revalidate');

        readfile($filePath);
        exit;
    }
}
