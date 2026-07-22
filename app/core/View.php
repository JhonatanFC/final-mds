<?php

declare(strict_types=1);

/**
 * Renderiza vistas y layouts del sistema.
 */
final class View
{
    /**
     * Carga una vista dentro de un layout.
     *
     * @param array<string, mixed> $data
     */
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        $viewFile = BASE_PATH . '/app/views/' . $view . '.php';
        $layoutFile = BASE_PATH . '/app/views/layouts/' . $layout . '.php';

        if (!is_file($viewFile) || !is_file($layoutFile)) {
            http_response_code(500);
            exit('Vista o layout no encontrado.');
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = (string) ob_get_clean();

        require $layoutFile;
    }

    private function __construct()
    {
    }
}
