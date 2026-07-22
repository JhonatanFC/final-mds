<?php

declare(strict_types=1);

/**
 * Controlador de inicio y dashboard interno.
 */
final class HomeController extends Controller
{
    public function index(): void
    {
        if (Session::has('user')) {
            $this->redirect('/dashboard');
        }

        $this->redirect('/login');
    }

    public function dashboard(): void
    {
        AuthMiddleware::requirePermission('dashboard.view');

        $user = AuthMiddleware::user();
        $role = (string) ($user['rol'] ?? '');

        $this->view('home/dashboard', [
            'title' => 'Dashboard | RMRS',
            'user' => $user,
            'dashboard' => $this->dashboardByRole($role),
            'modules' => $this->modulesByPermission(),
        ], 'dashboard');
    }

    /**
     * @return array<string, mixed>
     */
    private function dashboardByRole(string $role): array
    {
        return match ($role) {
            'Mesero' => [
                'title' => 'Panel de mesero',
                'subtitle' => 'Mesas disponibles, pedidos activos y atención al salón.',
                'metrics' => [
                    ['label' => 'Mesas asignadas', 'value' => '0', 'icon' => 'bi-table', 'tone' => 'primary'],
                    ['label' => 'Mesas libres', 'value' => '0', 'icon' => 'bi-check-circle', 'tone' => 'info'],
                    ['label' => 'Pedidos activos', 'value' => '0', 'icon' => 'bi-receipt', 'tone' => 'warning'],
                    ['label' => 'Pedidos entregados', 'value' => '0', 'icon' => 'bi-bag-check', 'tone' => 'primary'],
                ],
            ],
            'Cajera', 'Caja' => [
                'title' => 'Panel de caja',
                'subtitle' => 'Cobro de consumos, adelantos y cierre de caja.',
                'metrics' => [
                    ['label' => 'Caja actual', 'value' => 'S/ 0.00', 'icon' => 'bi-cash-stack', 'tone' => 'primary'],
                    ['label' => 'Adelantos cobrados', 'value' => '0', 'icon' => 'bi-qr-code-scan', 'tone' => 'info'],
                    ['label' => 'Cuentas pendientes', 'value' => '0', 'icon' => 'bi-hourglass-split', 'tone' => 'warning'],
                    ['label' => 'Ventas del día', 'value' => 'S/ 0.00', 'icon' => 'bi-graph-up-arrow', 'tone' => 'primary'],
                ],
            ],
            'Gerente' => [
                'title' => 'Panel gerencial',
                'subtitle' => 'Indicadores, ventas, reservas y cierre operativo.',
                'metrics' => [
                    ['label' => 'Ventas del día', 'value' => 'S/ 0.00', 'icon' => 'bi-currency-dollar', 'tone' => 'primary'],
                    ['label' => 'Reservas hoy', 'value' => '0', 'icon' => 'bi-calendar-event', 'tone' => 'info'],
                    ['label' => 'Mesas ocupadas', 'value' => '0', 'icon' => 'bi-table', 'tone' => 'warning'],
                    ['label' => 'Clientes en espera', 'value' => '0', 'icon' => 'bi-people', 'tone' => 'danger'],
                ],
            ],
            'Recepcion', 'Recepción' => [
                'title' => 'Panel de recepción',
                'subtitle' => 'Control de reservas, llegadas y lista de espera.',
                'metrics' => [
                    ['label' => 'Reservas hoy', 'value' => '0', 'icon' => 'bi-calendar-check', 'tone' => 'primary'],
                    ['label' => 'Por confirmar', 'value' => '0', 'icon' => 'bi-clock-history', 'tone' => 'warning'],
                    ['label' => 'En espera', 'value' => '0', 'icon' => 'bi-people', 'tone' => 'info'],
                    ['label' => 'Mesas disponibles', 'value' => '0', 'icon' => 'bi-table', 'tone' => 'primary'],
                ],
            ],
            default => [
                'title' => 'Panel de administración',
                'subtitle' => 'Resumen general de la operación del restaurante.',
                'metrics' => [
                    ['label' => 'Reservas hoy', 'value' => '0', 'icon' => 'bi-calendar-check', 'tone' => 'primary'],
                    ['label' => 'Mesas activas', 'value' => '0', 'icon' => 'bi-table', 'tone' => 'info'],
                    ['label' => 'Pedidos abiertos', 'value' => '0', 'icon' => 'bi-receipt', 'tone' => 'warning'],
                    ['label' => 'Ventas del día', 'value' => 'S/ 0.00', 'icon' => 'bi-graph-up-arrow', 'tone' => 'primary'],
                ],
            ],
        };
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function modulesByPermission(): array
    {
        $modules = [
            ['permission' => 'reservas.view', 'name' => 'Reservas', 'icon' => 'bi-calendar-check'],
            ['permission' => 'espera.manage', 'name' => 'Lista de espera', 'icon' => 'bi-people'],
            ['permission' => 'mesas.view', 'name' => 'Mesas', 'icon' => 'bi-table'],
            ['permission' => 'pedidos.view', 'name' => 'Pedidos', 'icon' => 'bi-receipt'],
            ['permission' => 'caja.view', 'name' => 'Caja', 'icon' => 'bi-cash-stack'],
            ['permission' => 'ventas.view', 'name' => 'Ventas', 'icon' => 'bi-graph-up-arrow'],
            ['permission' => 'reportes.view', 'name' => 'Reportes', 'icon' => 'bi-bar-chart'],
        ];

        return array_values(array_filter(
            $modules,
            static fn (array $module): bool => AuthMiddleware::can($module['permission'])
        ));
    }
}