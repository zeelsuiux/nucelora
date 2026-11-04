<?php
namespace App\Helpers;

use App\Config\App;

class Router {
    private static array $routes = [];

    public static function get(string $path, callable|array $handler): void {
        self::$routes['GET'][$path] = $handler;
    }

    public static function post(string $path, callable|array $handler): void {
        self::$routes['POST'][$path] = $handler;
    }

    public static function any(string $path, callable|array $handler): void {
        self::$routes['GET'][$path] = $handler;
        self::$routes['POST'][$path] = $handler;
    }

    public static function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if ($method === 'HEAD') {
            $method = 'GET';
        }
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        // Parse path
        $path = parse_url($uri, PHP_URL_PATH);

        // Compute project base path (e.g. /projects/lymko)
        $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        $scriptDir = str_replace('\\', '/', $scriptDir);
        if (substr($scriptDir, -7) === '/public') {
            $scriptDir = substr($scriptDir, 0, -7);
        }
        $scriptDir = rtrim($scriptDir, '/');

        if ($scriptDir !== '' && str_starts_with($path, $scriptDir)) {
            $path = substr($path, strlen($scriptDir));
        }

        $path = '/' . trim($path, '/');
        if ($path === '//') $path = '/';
        $noExtPath = preg_replace('/\.php$/i', '', $path);
        if ($noExtPath === '') $noExtPath = '/';

        $routesForMethod = self::$routes[$method] ?? [];

        // 1. Exact match
        if (isset($routesForMethod[$path])) {
            call_user_func($routesForMethod[$path]);
            return;
        }

        // 2. Exact match without .php extension
        if (isset($routesForMethod[$noExtPath])) {
            call_user_func($routesForMethod[$noExtPath]);
            return;
        }

        // 3. Case-insensitive exact match
        foreach ($routesForMethod as $routePattern => $handler) {
            if (strcasecmp($routePattern, $path) === 0 || strcasecmp($routePattern, $noExtPath) === 0) {
                call_user_func($handler);
                return;
            }
        }

        // 4. Pattern match (e.g. /collections/{slug}, /products/{handle}, /pages/{slug})
        foreach ($routesForMethod as $routePattern => $handler) {
            $regex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $routePattern);
            $regex = '#^' . $regex . '$#i';

            if (preg_match($regex, $path, $matches) || preg_match($regex, $noExtPath, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                call_user_func_array($handler, array_values($params));
                return;
            }
        }

        // 404 Not Found
        http_response_code(404);
        header("Cache-Control: no-cache, no-store, must-revalidate");
        echo "<!DOCTYPE html><html><head><title>404 Not Found</title></head><body style='font-family:sans-serif; text-align:center; padding:60px;'><h1>404 &mdash; Page Not Found</h1><p>The requested page <code>" . htmlspecialchars($path) . "</code> does not exist.</p><p><a href='" . App::baseUrl() . "'>Return to Home</a></p></body></html>";
    }
}
