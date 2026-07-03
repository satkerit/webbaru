<?php

/**
 * Security Helper Class
 * Menangani CSRF, sanitasi, password, rate limiting, session, dan security headers
 */
class Security
{
    private PDO $db;
    private int $maxLoginAttempts;
    private int $lockoutDuration;

    public function __construct(PDO $db)
    {
        $config = require dirname(__DIR__) . '/Config/app.php';
        $this->db = $db;
        $this->maxLoginAttempts = $config['max_login_attempts'];
        $this->lockoutDuration  = $config['lockout_duration'];
    }

    // ============================================================
    // CSRF PROTECTION
    // ============================================================

    public function generateCSRFToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public function validateCSRFToken(string $token): bool
    {
        if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            throw new RuntimeException('CSRF token validation failed.');
        }
        return true;
    }

    public function csrfField(): string
    {
        $token = $this->generateCSRFToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    // ============================================================
    // INPUT SANITIZATION & VALIDATION
    // ============================================================

    public static function sanitize(mixed $input, string $type = 'string'): mixed
    {
        return match ($type) {
            'string' => htmlspecialchars(strip_tags(trim((string) $input)), ENT_QUOTES, 'UTF-8'),
            'email'  => filter_var(trim((string) $input), FILTER_SANITIZE_EMAIL),
            'int'    => filter_var($input, FILTER_VALIDATE_INT),
            'float'  => filter_var($input, FILTER_VALIDATE_FLOAT),
            'url'    => filter_var(trim((string) $input), FILTER_VALIDATE_URL),
            'html'   => strip_tags(trim((string) $input), '<p><br><strong><em><ul><ol><li><h1><h2><h3><h4><h5><h6><a><img><table><thead><tbody><tr><td><th>'),
            default  => htmlspecialchars(strip_tags(trim((string) $input)), ENT_QUOTES, 'UTF-8'),
        };
    }

    public static function validate(array $input, array $rules): array|true
    {
        $errors = [];

        foreach ($rules as $field => $ruleSet) {
            $value = $input[$field] ?? '';
            foreach (explode('|', $ruleSet) as $rule) {
                [$ruleName, $ruleValue] = array_pad(explode(':', $rule, 2), 2, null);

                switch ($ruleName) {
                    case 'required':
                        if ($value === '' || $value === null) {
                            $errors[$field][] = "Field {$field} wajib diisi.";
                        }
                        break;
                    case 'min':
                        if (mb_strlen((string) $value) < (int) $ruleValue) {
                            $errors[$field][] = "Field {$field} minimal {$ruleValue} karakter.";
                        }
                        break;
                    case 'max':
                        if (mb_strlen((string) $value) > (int) $ruleValue) {
                            $errors[$field][] = "Field {$field} maksimal {$ruleValue} karakter.";
                        }
                        break;
                    case 'email':
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $errors[$field][] = "Format email tidak valid.";
                        }
                        break;
                    case 'numeric':
                        if (!is_numeric($value)) {
                            $errors[$field][] = "Field {$field} harus berupa angka.";
                        }
                        break;
                    case 'in':
                        $allowed = explode(',', $ruleValue ?? '');
                        if (!in_array($value, $allowed, true)) {
                            $errors[$field][] = "Field {$field} tidak valid.";
                        }
                        break;
                    case 'url':
                        if (!filter_var($value, FILTER_VALIDATE_URL)) {
                            $errors[$field][] = "Format URL tidak valid.";
                        }
                        break;
                }
            }
        }

        return empty($errors) ? true : $errors;
    }

    // ============================================================
    // PASSWORD SECURITY
    // ============================================================

    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function validatePasswordStrength(string $password): array|true
    {
        $errors = [];

        if (mb_strlen($password) < 8) {
            $errors[] = 'Password minimal 8 karakter.';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password harus mengandung huruf besar.';
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password harus mengandung huruf kecil.';
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password harus mengandung angka.';
        }
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = 'Password harus mengandung karakter khusus (!@#$%^&*).';
        }

        return empty($errors) ? true : $errors;
    }

    // ============================================================
    // RATE LIMITING - LOGIN
    // ============================================================

    public function checkLoginAttempts(string $username): void
    {
        $stmt = $this->db->prepare(
            "SELECT failed_login_attempts, locked_until FROM users WHERE username = ? OR email = ?"
        );
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        if (!$user) return;

        if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
            $remaining = strtotime($user['locked_until']) - time();
            throw new RuntimeException("Akun terkunci. Coba lagi dalam " . ceil($remaining / 60) . " menit.");
        }
    }

    public function recordFailedLogin(string $username, string $ip): void
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET failed_login_attempts = failed_login_attempts + 1,
                locked_until = CASE
                    WHEN failed_login_attempts + 1 >= :maxAttempts
                    THEN DATE_ADD(NOW(), INTERVAL :lockDuration SECOND)
                    ELSE locked_until
                END
            WHERE username = :username OR email = :email
        ");
        $stmt->execute([
            'maxAttempts'   => $this->maxLoginAttempts,
            'lockDuration'  => $this->lockoutDuration,
            'username'      => $username,
            'email'         => $username,
        ]);

        $stmt = $this->db->prepare(
            "INSERT INTO login_logs (username, ip_address, user_agent, status, reason) VALUES (?, ?, ?, 'failed', 'Invalid credentials')"
        );
        $stmt->execute([$username, $ip, $_SERVER['HTTP_USER_AGENT'] ?? '']);
    }

    public function resetLoginAttempts(int $userId): void
    {
        $stmt = $this->db->prepare(
            "UPDATE users SET failed_login_attempts = 0, locked_until = NULL WHERE id = ?"
        );
        $stmt->execute([$userId]);
    }

    public function recordSuccessLogin(int $userId, string $ip): void
    {
        $stmt = $this->db->prepare(
            "UPDATE users SET last_login = NOW(), last_ip = ? WHERE id = ?"
        );
        $stmt->execute([$ip, $userId]);

        $stmt = $this->db->prepare(
            "INSERT INTO login_logs (user_id, ip_address, user_agent, status) VALUES (?, ?, ?, 'success')"
        );
        $stmt->execute([$userId, $ip, $_SERVER['HTTP_USER_AGENT'] ?? '']);
    }

    // ============================================================
    // FILE UPLOAD SECURITY
    // ============================================================

    public function uploadFile(array $file, string $directory, ?array $allowedTypes = null): string
    {
        $config = require dirname(__DIR__) . '/Config/app.php';

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Upload gagal: ' . $this->getUploadError($file['error']));
        }

        if ($file['size'] > $config['max_upload_size']) {
            throw new RuntimeException('Ukuran file maksimal ' . ($config['max_upload_size'] / 1048576) . 'MB.');
        }

        $finfo    = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        $allowed  = $allowedTypes ?? array_merge(
            $config['allowed_image_types'],
            $config['allowed_document_types']
        );

        if (!in_array($mimeType, $allowed, true)) {
            throw new RuntimeException("Tipe file '{$mimeType}' tidak diizinkan.");
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename  = bin2hex(random_bytes(16)) . '.' . $extension;
        $fullDir   = $config['upload_path'] . '/' . $directory;

        if (!is_dir($fullDir)) {
            mkdir($fullDir, 0755, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $fullDir . '/' . $filename)) {
            throw new RuntimeException('Gagal menyimpan file.');
        }

        return $filename;
    }

    private function getUploadError(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE  => 'File terlalu besar (server limit).',
            UPLOAD_ERR_FORM_SIZE => 'File terlalu besar (form limit).',
            UPLOAD_ERR_PARTIAL   => 'File hanya terupload sebagian.',
            UPLOAD_ERR_NO_FILE   => 'Tidak ada file yang diupload.',
            UPLOAD_ERR_NO_TMP_DIR=> 'Folder temporary tidak ditemukan.',
            UPLOAD_ERR_CANT_WRITE=> 'Gagal menulis file ke disk.',
            default              => 'Unknown error.',
        };
    }

    // ============================================================
    // SESSION SECURITY
    // ============================================================

    public static function secureSessionStart(): void
    {
        if (session_status() !== PHP_SESSION_NONE) return;

        $secure   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
        $lifetime = (int) ($_ENV['SESSION_LIFETIME'] ?? 3600);

        session_set_cookie_params([
            'lifetime' => $lifetime,
            'path'     => '/',
            'domain'   => '',
            'secure'   => $secure,
            'httponly' => true,
            'samesite' => 'Strict',
        ]);

        ini_set('session.use_strict_mode', '1');
        ini_set('session.gc_maxlifetime', (string) $lifetime);

        session_start();

        // Regenerate periodically
        if (!isset($_SESSION['_last_regen'])) {
            $_SESSION['_last_regen'] = time();
        } elseif (time() - $_SESSION['_last_regen'] > 300) {
            session_regenerate_id(true);
            $_SESSION['_last_regen'] = time();
        }
    }

    // ============================================================
    // SECURITY HEADERS
    // ============================================================

    public static function setSecurityHeaders(): void
    {
        if (headers_sent()) return;

        header('X-Frame-Options: DENY');
        header('X-Content-Type-Options: nosniff');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
        header(
            "Content-Security-Policy: default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' cdn.jsdelivr.net cdnjs.cloudflare.com; " .
            "style-src 'self' 'unsafe-inline' fonts.googleapis.com cdn.jsdelivr.net cdnjs.cloudflare.com; " .
            "font-src 'self' fonts.gstatic.com cdnjs.cloudflare.com; " .
            "img-src 'self' data:; " .
            "frame-ancestors 'none';"
        );
    }
}
