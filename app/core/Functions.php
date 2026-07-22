<?php

declare(strict_types=1);

/**
 * Escapa una cadena antes de enviarla a una vista.
 */
function e(?string $value): string
{
    return Security::escape($value);
}

/**
 * Redirige a una ruta interna de la aplicación.
 */
function redirect(string $path): never
{
    if (filter_var($path, FILTER_VALIDATE_URL) !== false) {
        header('Location: ' . $path, true, 302);
        exit;
    }

    $url = rtrim(APP_URL, '/') . '/' . ltrim($path, '/');

    header('Location: ' . $url, true, 302);
    exit;
}