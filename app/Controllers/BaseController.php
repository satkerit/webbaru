<?php

/**
 * Base Controller
 * Semua controller mewarisi class ini
 */
abstract class BaseController
{
    protected PDO $db;
    protected array $config;

    public function __construct()
    {
        $this->db     = Database::getInstance();
        $this->config = require APP_PATH . '/Config/app.php';
    }

    /**
     * Render view file dengan data
     */
    protected function view(string $viewPath, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        $file = APP_PATH . '/Views/' . str_replace('.', '/', $viewPath) . '.php';

        if (!file_exists($file)) {
            throw new RuntimeException("View not found: {$file}");
        }

        require $file;
    }

    /**
     * Render view dengan layout
     */
    protected function render(string $layout, string $viewPath, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        $viewFile   = APP_PATH . '/Views/' . str_replace('.', '/', $viewPath) . '.php';
        $layoutFile = APP_PATH . '/Views/' . str_replace('.', '/', $layout) . '.php';

        if (!file_exists($viewFile)) {
            throw new RuntimeException("View not found: {$viewFile}");
        }

        if (!file_exists($layoutFile)) {
            throw new RuntimeException("Layout not found: {$layoutFile}");
        }

        // Capture view content
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Render layout dengan $content tersedia
        require $layoutFile;
    }

    /**
     * JSON response
     */
    protected function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Ambil data POST dengan sanitasi
     */
    protected function input(string $key, string $type = 'string', mixed $default = null): mixed
    {
        $value = $_POST[$key] ?? $_GET[$key] ?? $default;
        if ($value === null) return $default;
        return Security::sanitize($value, $type);
    }

    /**
     * Ambil semua settings website
     */
    protected function getSettings(): array
    {
        static $settings = null;
        if ($settings === null) {
            try {
                $stmt     = $this->db->query("SELECT setting_key, setting_value FROM settings");
                $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            } catch (Exception) {
                $settings = [];
            }
        }
        return $settings;
    }

    /**
     * Ambil satu setting
     */
    protected function setting(string $key, string $default = ''): string
    {
        return $this->getSettings()[$key] ?? $default;
    }

    /**
     * Cek & validasi CSRF token untuk POST requests
     */
    protected function verifyCsrf(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $token    = $_POST['csrf_token'] ?? '';
        $security = new Security($this->db);
        $security->validateCSRFToken($token);
    }

    /**
     * Pagination helper
     */
    protected function paginate(string $query, array $params = [], int $perPage = 10): array
    {
        $page    = max(1, (int) ($_GET['page'] ?? 1));
        $offset  = ($page - 1) * $perPage;

        // Count total
        $countQuery = "SELECT COUNT(*) FROM ({$query}) AS t";
        $stmt       = $this->db->prepare($countQuery);
        $stmt->execute($params);
        $total = (int) $stmt->fetchColumn();

        // Fetch data
        $stmt = $this->db->prepare($query . " LIMIT {$perPage} OFFSET {$offset}");
        $stmt->execute($params);
        $data = $stmt->fetchAll();

        return [
            'data'        => $data,
            'total'       => $total,
            'per_page'    => $perPage,
            'current_page'=> $page,
            'last_page'   => max(1, (int) ceil($total / $perPage)),
            'from'        => $total > 0 ? $offset + 1 : 0,
            'to'          => min($offset + $perPage, $total),
        ];
    }
}
