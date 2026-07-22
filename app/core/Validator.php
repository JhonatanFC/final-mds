<?php

declare(strict_types=1);

/**
 * Validador reutilizable para datos de formularios.
 */
final class Validator
{
    /**
     * Indica si un texto es un correo electrónico válido.
     */
    public static function email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Indica si un texto requerido contiene valor.
     */
    public static function required(?string $value): bool
    {
        return trim((string) $value) !== '';
    }

    /**
     * Valida que un texto tenga una longitud dentro de un rango.
     */
    public static function length(string $value, int $minimum, int $maximum): bool
    {
        $length = mb_strlen(trim($value));

        return $length >= $minimum && $length <= $maximum;
    }

    private function __construct()
    {
    }
}
