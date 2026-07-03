<?php

require_once APP_PATH . '/Controllers/BaseController.php';

/**
 * DashboardController - Admin Dashboard
 */
class DashboardController extends BaseController
{
    public function index(): void
    {
        // Statistik ringkasan
        $stats = $this->getStats();

        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);

        $this->render(
            'backend.layouts.dashboard',
            'backend.dashboard.index',
            [
                'title'  => 'Dashboard | ' . $this->setting('site_name'),
                'stats'  => $stats,
                'rbac'   => $rbac,
                'user'   => $_SESSION,
            ]
        );
    }

    public function reports(): void
    {
        $rbac = new RBAC($this->db, (int) $_SESSION['user_id']);
        $rbac->requirePermission('reports.view');

        // Statistik pengunjung 30 hari terakhir
        $stmt = $this->db->prepare("
            SELECT visit_date, COUNT(*) as visits
            FROM visitor_logs
            WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            GROUP BY visit_date
            ORDER BY visit_date ASC
        ");
        $stmt->execute();
        $visitorData = $stmt->fetchAll();

        // Top pages
        $stmt = $this->db->prepare("
            SELECT page_url, COUNT(*) as hits
            FROM visitor_logs
            WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            GROUP BY page_url
            ORDER BY hits DESC
            LIMIT 10
        ");
        $stmt->execute();
        $topPages = $stmt->fetchAll();

        $this->render(
            'backend.layouts.dashboard',
            'backend.reports.index',
            [
                'title'       => 'Laporan | ' . $this->setting('site_name'),
                'visitorData' => $visitorData,
                'topPages'    => $topPages,
                'rbac'        => $rbac,
                'user'        => $_SESSION,
            ]
        );
    }

    private function getStats(): array
    {
        $stats = [];

        $tables = [
            'articles'     => "SELECT COUNT(*) FROM articles WHERE is_published = 1",
            'products'     => "SELECT COUNT(*) FROM products WHERE is_active = 1",
            'publications' => "SELECT COUNT(*) FROM publications WHERE is_active = 1",
            'contacts'     => "SELECT COUNT(*) FROM contacts WHERE is_read = 0",
            'whistleblows' => "SELECT COUNT(*) FROM whistleblows WHERE status = 'new'",
            'auctions'     => "SELECT COUNT(*) FROM auctions WHERE status = 'active'",
            'careers'      => "SELECT COUNT(*) FROM careers WHERE is_active = 1",
            'visitors_today'=> "SELECT COUNT(*) FROM visitor_logs WHERE visit_date = CURDATE()",
            'visitors_month'=> "SELECT COUNT(*) FROM visitor_logs WHERE visit_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')",
        ];

        foreach ($tables as $key => $query) {
            try {
                $stmt       = $this->db->query($query);
                $stats[$key]= (int) $stmt->fetchColumn();
            } catch (Exception) {
                $stats[$key]= 0;
            }
        }

        return $stats;
    }
}
