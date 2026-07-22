<?php

declare(strict_types=1);

/**
 * Proporciona utilidades de seguridad para CSRF y salida segura.
 */
final class Security
{
    private const CSRF_SESSION_KEY = '_rmrs_csrf_token';

    /**
     * Obtiene o crea el token CSRF de la sesión activa.
     */
    public static function csrfToken(): string
    {
        $token = Session::get(self::CSRF_SESSION_KEY);

        if (!is_string($token) || strlen($token) !== 64) {
            $token = bin2hex(random_bytes(32));

            Session::set(self::CSRF_SESSION_KEY, $token);
        }

        return $token;
    }

    /**
     * Comprueba que el token enviado coincida con el token de sesión.
     */
    public static function verifyCsrf(mixed $submittedToken): bool
    {
        if (!is_string($submittedToken) || $submittedToken === '') {
            return false;
        }

        $sessionToken = Session::get(self::CSRF_SESSION_KEY);

        if (!is_string($sessionToken) || $sessionToken === '') {
            return false;
        }

        return hash_equals($sessionToken, $submittedToken);
    }

    /**
     * Genera un token nuevo para la sesión.
     */
    public static function regenerateCsrfToken(): string
    {
        $token = bin2hex(random_bytes(32));

        Session::set(self::CSRF_SESSION_KEY, $token);

        return $token;
    }

    /**
     * Compatibilidad con controladores anteriores.
     */
    public static function generateCsrfToken(): string
    {
        return self::csrfToken();
    }

    /**
     * Compatibilidad con controladores anteriores.
     */
    public static function validateCsrfToken(mixed $submittedToken): bool
    {
        return self::verifyCsrf($submittedToken);
    }

    /**
     * Escapa una salida HTML.
     */
    public static function escape(mixed $value): string
    {
        return htmlspecialchars(
            (string) $value,
            ENT_QUOTES,
            'UTF-8'
        );
    }

    private function __construct()
    {
    }
}