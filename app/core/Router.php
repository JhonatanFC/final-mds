<?php

declare(strict_types=1);

/**
 * Registra y resuelve las rutas HTTP de la aplicación.
 */
final class Router
{
    /** @var array<string, array<string, callable|array{0: string, 1: string}>> */
    private array $routes = [];

    /**
     * Registra una ruta GET.
     */
    public function get(string $path, callable|array $action): void
    {
        $this->add('GET', $path, $action);
    }

    /**
     * Registra una ruta POST.
     */
    public function post(string $path, callable|array $action): void
    {
        $this->add('POST', $path, $action);
    }

    /**
     * Ejecuta la acción correspondiente a la solicitud.
     */
    public function dispatch(): void
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $basePath = parse_url(APP_URL, PHP_URL_PATH) ?: '';

        if ($basePath !== '' && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath)) ?: '/';
        }

        $uri = '/' . trim($uri, '/');
        $uri = $uri === '/' ? '/' : rtrim($uri, '/');

        $action = $this->routes[$method][$uri] ?? null;

        if ($action === null) {
            http_response_code(404);
            View::render('errors/404', ['title' => 'Página no encontrada']);
            return;
        }

        if (is_callable($action)) {
            $action();
            return;
        }

        [$controller, $methodName] = $action;
        $instance = new $controller();
        $instance->{$methodName}();
    }

    /**
     * Registra una ruta por método HTTP.
     */
    private function add(string $method, string $path, callable|array $action): void
    {
        $path = '/' . trim($path, '/');
        $path = $path === '/' ? '/' : rtrim($path, '/');

        $this->routes[$method][$path] = $action;
    }
}
