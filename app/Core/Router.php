<?php

declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void { $this->add('GET', $path, $handler); }
    public function post(string $path, array $handler): void { $this->add('POST', $path, $handler); }

    private function add(string $method, string $path, array $handler): void
    {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch(string $method, string $uri): void
    {
        $requestPath = parse_url($uri, PHP_URL_PATH) ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $requestPath, $matches)) {
                [$class, $action] = $route['handler'];
                $controller = new $class();
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $controller->{$action}($params);
                return;
            }
        }

        http_response_code(404);
        echo '404 — Страница не найдена';
    }
}
