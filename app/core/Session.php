<?php

declare(strict_types=1);

/**
 * Gestiona la sesión y mensajes temporales de la aplicación.
 */
final class Session
{
    private const FLASH_KEY = '_flash';

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        session_name('rmrs_session');

        session_set_cookie_params([
            'httponly' => true,
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'samesite' => 'Lax',
        ]);

        session_start();

        if (!isset($_SESSION['_started'])) {
            session_regenerate_id(true);
            $_SESSION['_started'] = true;
        }
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Guarda un mensaje temporal o lo obtiene y elimina.
     */
    public static function flash(string $key, ?string $message = null): ?string
    {
        if ($message !== null) {
            $_SESSION[self::FLASH_KEY][$key] = $message;

            return null;
        }

        return self::getFlash($key);
    }

    /**
     * Obtiene un mensaje temporal y lo elimina de la sesión.
     */
    public static function getFlash(string $key): ?string
    {
        $message = $_SESSION[self::FLASH_KEY][$key] ?? null;

        unset($_SESSION[self::FLASH_KEY][$key]);

        return is_string($message) ? $message : null;
    }

    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }

    public static function destroy(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $parameters = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $parameters['path'],
                $parameters['domain'],
                (bool) $parameters['secure'],
                (bool) $parameters['httponly']
            );
        }

        session_destroy();
    }

    private function __construct()
    {
    }
}