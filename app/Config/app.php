<?php

/**
 * Application Configuration
 */

return [
    'name'     => $_ENV['APP_NAME'] ?? 'BPRS Bangka Belitung',
    'url'      => $_ENV['APP_URL']  ?? 'http://localhost',
    'env'      => $_ENV['APP_ENV']  ?? 'production',
    'debug'    => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
    'key'      => $_ENV['APP_KEY']  ?? '',
    'timezone' => 'Asia/Jakarta',
    'locale'   => 'id',

    // Upload settings
    'max_upload_size'       => (int) ($_ENV['MAX_UPLOAD_SIZE'] ?? 5242880),
    'allowed_image_types'   => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
    'allowed_document_types'=> ['application/pdf'],

    // Security settings
    'max_login_attempts' => (int) ($_ENV['MAX_LOGIN_ATTEMPTS'] ?? 5),
    'lockout_duration'   => (int) ($_ENV['LOCKOUT_DURATION'] ?? 900),
    'session_lifetime'   => (int) ($_ENV['SESSION_LIFETIME'] ?? 3600),
    'password_min_length'=> (int) ($_ENV['PASSWORD_MIN_LENGTH'] ?? 8),

    // Paths
    'upload_path'  => dirname(__DIR__, 2) . '/public/uploads',
    'storage_path' => dirname(__DIR__, 2) . '/storage',
    'public_url'   => '/uploads',
];
