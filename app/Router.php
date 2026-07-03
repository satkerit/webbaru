<?php

/**
 * Simple PHP Router
 * Mendukung parameter dinamis seperti /produk/{slug}
 */
class Router
{
    private array $routes = [];

    public function add(string $method, string $path, string $handler, ?string $middleware = null): void
    {
        $this->routes[] = [
            'method'     => strtoupper($method),
            'pattern'    => $this->buildPattern($path),
            'handler'    => $handler,
            'middleware' => $middleware,
            'params'     => $this->extractParamNames($path),
        ];
    }

    private function buildPattern(string $path): string
    {
        // Escape forward slashes, convert {param} to named capture groups
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    private function extractParamNames(string $path): array
    {
        preg_match_all('/\{(\w+)\}/', $path, $matches);
        return $matches[1] ?? [];
    }

    public function dispatch(string $method, string $uri): void
    {
        // Bersihkan query string dari URI
        $uri = strtok($uri, '?') ?: '/';
        $uri = rtrim($uri, '/') ?: '/';

        // Normalisasi jika menggunakan subfolder (Laragon)
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptDir !== '/' && str_starts_with($uri, $scriptDir)) {
            $uri = substr($uri, strlen($scriptDir)) ?: '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($method)) continue;

            if (!preg_match($route['pattern'], $uri, $matches)) continue;

            // Ekstrak parameter
            $params = [];
            foreach ($route['params'] as $param) {
                $params[$param] = $matches[$param] ?? null;
            }

            // Handle middleware
            if ($route['middleware']) {
                $this->handleMiddleware($route['middleware']);
            }

            // Dispatch controller
            $this->callHandler($route['handler'], $params);
            return;
        }

        // 404
        $this->notFound();
    }

    private function handleMiddleware(string $middleware): void
    {
        $parts = explode(':', $middleware, 2);
        $type  = $parts[0];
        $perm  = $parts[1] ?? null;

        if ($type === 'auth') {
            require_once APP_PATH . '/Middleware/AuthMiddleware.php';
            $auth = new AuthMiddleware();
            $auth->handle($perm);
        }
    }

    private function callHandler(string $handler, array $params): void
    {
        [$class, $method] = explode('@', $handler);

        // Tentukan namespace folder
        $classFile = '';
        if (str_starts_with($class, 'Frontend\\')) {
            $className = str_replace('Frontend\\', '', $class);
            $classFile = APP_PATH . '/Controllers/Frontend/' . $className . '.php';
        } elseif (str_starts_with($class, 'Backend\\')) {
            $className = str_replace('Backend\\', '', $class);
            $classFile = APP_PATH . '/Controllers/Backend/' . $className . '.php';
        } else {
            $classFile = APP_PATH . '/Controllers/' . $class . '.php';
            $className = $class;
        }

        if (!file_exists($classFile)) {
            error_log("[Router] Controller not found: {$classFile}");
            $this->notFound();
            return;
        }

        require_once $classFile;

        if (!class_exists($className)) {
            error_log("[Router] Class not found: {$className}");
            $this->notFound();
            return;
        }

        $controller = new $className();

        if (!method_exists($controller, $method)) {
            error_log("[Router] Method not found: {$className}@{$method}");
            $this->notFound();
            return;
        }

        call_user_func_array([$controller, $method], $params);
    }

    private function notFound(): void
    {
        http_response_code(404);
        $view404 = APP_PATH . '/Views/errors/404.php';
        if (file_exists($view404)) {
            require $view404;
        } else {
            echo '<h1>404 - Halaman tidak ditemukan</h1>';
        }
    }
}
