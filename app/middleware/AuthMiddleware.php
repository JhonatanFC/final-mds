<?php

declare(strict_types=1);

/**
 * Controla autenticación y permisos por rol.
 */
final class AuthMiddleware
{
    private const ROLE_PERMISSIONS = [
        'administrador' => ['*'],

        'recepcion' => [
            'dashboard.view',
            'reservas.view',
            'reservas.create',
            'reservas.confirm',
            'espera.manage',
            'mesas.view',
        ],

        'mesero' => [
            'dashboard.view',
            'mesas.view',
            'mesas.open',
            'pedidos.view',
            'pedidos.create',
            'pedidos.update',
            'productos.view',
        ],

        'cajera' => [
            'dashboard.view',
            'caja.view',
            'caja.charge',
            'caja.close',
            'pagos.view',
            'pagos.register',
        ],

        'caja' => [
            'dashboard.view',
            'caja.view',
            'caja.charge',
            'caja.close',
            'pagos.view',
            'pagos.register',
        ],

        'gerente' => [
            'dashboard.view',
            'reportes.view',
            'caja.view',
            'ventas.view',
            'reservas.view',
            'mesas.view',
            'productos.view',
        ],
    ];

    public static function requireLogin(): void
    {
        if (!Session::has('user')) {
            Session::flash('error', 'Debes iniciar sesión para continuar.');
            header('Location: ' . APP_URL . '/login');
            exit;
        }
    }

    public static function requirePermission(string $permission): void
    {
        self::requireLogin();

        if (!self::can($permission)) {
            Session::flash('error', 'No tienes permiso para acceder a este módulo.');
            header('Location: ' . APP_URL . '/dashboard');
            exit;
        }
    }

    public static function can(string $permission): bool
    {
        $permissions = self::permissions();

        return in_array('*', $permissions, true)
            || in_array($permission, $permissions, true);
    }

    /**
     * @return array<int, string>
     */
    public static function permissions(): array
    {
        $user = self::user();

        if ($user === null) {
            return [];
        }

        $role = self::normalizeRole((string) $user['rol']);

        return self::ROLE_PERMISSIONS[$role] ?? [];
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function user(): ?array
    {
        $user = Session::get('user');

        return is_array($user) ? $user : null;
    }

    private static function normalizeRole(string $role): string
    {
        $role = strtolower($role);

        return strtr($role, [
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
        ]);
    }

    private function __construct()
    {
    }
}