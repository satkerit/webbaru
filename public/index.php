<?php

/**
 * BPRS Bangka Belitung - Application Entry Point
 */

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', __DIR__);
define('START_TIME', microtime(true));

// Load environment
$envFile = BASE_PATH . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $k = trim($key);
        $v = trim($value, " \t\n\r\0\x0B\"'");
        $_ENV[$k] = $v;
        putenv("{$k}={$v}");
    }
}

// Display errors berdasarkan env
$debug = filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN);
ini_set('display_errors', $debug ? '1' : '0');
error_reporting($debug ? E_ALL : 0);

// Autoload helpers & classes
$helpers = [
    'Database', 'Security', 'RBAC', 'Common',
];
foreach ($helpers as $helper) {
    $file = APP_PATH . '/Helpers/' . $helper . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}

// Security headers
Security::setSecurityHeaders();

// Secure session
Security::secureSessionStart();

// Router
require_once APP_PATH . '/Router.php';

$router = new Router();
$routes = require APP_PATH . '/Config/routes.php';

foreach ($routes as $route) {
    [$method, $path, $handler, $middleware] = array_pad($route, 4, null);
    $router->add($method, $path, $handler, $middleware);
}

$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);
