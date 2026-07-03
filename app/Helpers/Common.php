<?php

/**
 * Common Helper Functions
 */

/**
 * Generate slug dari string
 */
function str_slug(string $text): string
{
    // Transliterasi huruf Indonesia
    $text = mb_strtolower($text, 'UTF-8');
    $from = ['á','à','ä','â','é','è','ë','ê','í','ì','ï','î','ó','ò','ö','ô','ú','ù','ü','û','ñ','ç'];
    $to   = ['a','a','a','a','e','e','e','e','i','i','i','i','o','o','o','o','u','u','u','u','n','c'];
    $text = str_replace($from, $to, $text);

    // Hapus karakter non-alphanumeric
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

/**
 * Format angka rupiah
 */
function format_rupiah(float|int $amount, bool $withSymbol = true): string
{
    $formatted = number_format($amount, 0, ',', '.');
    return $withSymbol ? 'Rp ' . $formatted : $formatted;
}

/**
 * Format tanggal ke bahasa Indonesia
 */
function format_date(string $date, string $format = 'd F Y'): string
{
    $bulan = [
        'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
        'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
        'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
        'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember',
    ];

    $result = date($format, strtotime($date));
    return strtr($result, $bulan);
}

/**
 * Buat excerpt dari konten HTML
 */
function make_excerpt(string $content, int $length = 150): string
{
    $text = strip_tags($content);
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . '...';
}

/**
 * Ambil flash message dan hapus dari session
 */
function flash(string $key): ?string
{
    if (isset($_SESSION['flash_' . $key])) {
        $msg = $_SESSION['flash_' . $key];
        unset($_SESSION['flash_' . $key]);
        return $msg;
    }
    return null;
}

/**
 * Set flash message
 */
function set_flash(string $key, string $message): void
{
    $_SESSION['flash_' . $key] = $message;
}

/**
 * Redirect
 */
function redirect(string $url, int $code = 302): never
{
    header("Location: {$url}", true, $code);
    exit;
}

/**
 * Cek apakah request adalah AJAX
 */
function is_ajax(): bool
{
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
}

/**
 * Ambil client IP
 */
function get_client_ip(): string
{
    $headers = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR'];
    foreach ($headers as $header) {
        if (!empty($_SERVER[$header])) {
            $ip = trim(explode(',', $_SERVER[$header])[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    return '0.0.0.0';
}

/**
 * Format file size
 */
function format_filesize(int $bytes): string
{
    if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
    if ($bytes >= 1048576)    return number_format($bytes / 1048576, 2) . ' MB';
    if ($bytes >= 1024)       return number_format($bytes / 1024, 2) . ' KB';
    return $bytes . ' Bytes';
}

/**
 * Ambil URL publik untuk upload file
 */
function asset_url(string $path = ''): string
{
    $appUrl = $_ENV['APP_URL'] ?? '';
    return rtrim($appUrl, '/') . '/assets/' . ltrim($path, '/');
}

/**
 * Ambil URL untuk upload file
 */
function upload_url(string $directory, string $filename): string
{
    $appUrl = $_ENV['APP_URL'] ?? '';
    return rtrim($appUrl, '/') . '/uploads/' . $directory . '/' . $filename;
}

/**
 * Sanitasi output untuk HTML
 */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Truncate text
 */
function truncate(string $text, int $length, string $suffix = '...'): string
{
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . $suffix;
}

/**
 * Ambil setting website dari database
 */
function get_setting(PDO $db, string $key, string $default = ''): string
{
    static $settings = null;

    if ($settings === null) {
        try {
            $stmt = $db->query("SELECT setting_key, setting_value FROM settings");
            $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        } catch (Exception) {
            $settings = [];
        }
    }

    return $settings[$key] ?? $default;
}

/**
 * Log visitor
 */
function log_visitor(PDO $db): void
{
    try {
        $stmt = $db->prepare("
            INSERT INTO visitor_logs (ip_address, user_agent, page_url, referrer, session_id, visit_date, visit_time)
            VALUES (?, ?, ?, ?, ?, CURDATE(), CURTIME())
        ");
        $stmt->execute([
            get_client_ip(),
            $_SERVER['HTTP_USER_AGENT'] ?? '',
            $_SERVER['REQUEST_URI'] ?? '',
            $_SERVER['HTTP_REFERER'] ?? '',
            session_id(),
        ]);
    } catch (Exception) {
        // Silent fail — jangan sampai error log ganggu halaman
    }
}
