<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * AuctionController - Lelang Aset
 */
class AuctionController extends BaseController
{
    public function index(): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->query(
            "SELECT * FROM auctions WHERE is_active = 1 ORDER BY status ASC, end_date ASC"
        );
        $auctions = $stmt->fetchAll();

        $this->render('frontend.layouts.main', 'frontend.pages.auction', [
            'title'    => 'Lelang Aset | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'auctions' => $auctions,
            'active'   => 'lelang',
        ]);
    }

    public function detail(?string $id = null): void
    {
        log_visitor($this->db);
        $settings = $this->getSettings();

        $stmt = $this->db->prepare("SELECT * FROM auctions WHERE id = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([(int) $id]);
        $auction = $stmt->fetch();

        if (!$auction) {
            http_response_code(404);
            $this->render('frontend.layouts.main', 'errors.404', ['settings' => $settings, 'title' => '404']);
            return;
        }

        $this->render('frontend.layouts.main', 'frontend.pages.auction-detail', [
            'title'    => $auction['title'] . ' | ' . ($settings['site_name'] ?? ''),
            'settings' => $settings,
            'auction'  => $auction,
            'active'   => 'lelang',
        ]);
    }
}
