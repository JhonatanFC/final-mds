<?php

declare(strict_types=1);

/**
 * Clase base para todos los controladores.
 */
abstract class Controller
{
    /**
     * Renderiza una vista usando el layout principal.
     *
     * @param array<string, mixed> $data
     */
    protected function view(string $view, array $data = [], string $layout = 'main'): void
    {
        View::render($view, $data, $layout);
    }

    /**
     * Redirige a una ruta interna de la aplicación.
     */
    protected function redirect(string $path): never
    {
        header('Location: ' . APP_URL . $path);
        exit;
    }
}
