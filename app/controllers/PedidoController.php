<?php

declare(strict_types=1);

/**
 * Controlador del módulo operativo de pedidos.
 */
final class PedidoController extends Controller
{
    /**
     * Muestra la pantalla de pedidos para meseros.
     */
    public function index(): void
    {
        AuthMiddleware::requirePermission('pedidos.view');

        $pedidoModel = new Pedido();

        $this->view('meseros/pedidos', [
            'tables' => $pedidoModel->getAvailableTables(),
            'products' => $pedidoModel->getAvailableProducts(),
            'orders' => $pedidoModel->getActiveOrders(),
            'csrfToken' => Security::generateCsrfToken(),
        ], 'dashboard');
    }

    /**
     * Registra un nuevo pedido.
     */
    public function store(): void
    {
        AuthMiddleware::requirePermission('pedidos.create');

        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'La sesión expiró. Intenta nuevamente.');
            redirect('/pedidos');

            return;
        }

        try {
            $rawItems = $_POST['items'] ?? [];

            if (!is_array($rawItems)) {
                throw new RuntimeException('Los productos enviados no son válidos.');
            }

            $items = [];

            foreach ($rawItems as $item) {
                if (!is_array($item)) {
                    continue;
                }

                $items[] = [
                    'producto_id' => (int) ($item['producto_id'] ?? 0),
                    'cantidad' => (int) ($item['cantidad'] ?? 0),
                ];
            }

            $user = AuthMiddleware::user();

            if ($user === null) {
                throw new RuntimeException('No se encontró la sesión del mesero.');
            }

            $orderId = (new Pedido())->createOrder(
                (int) ($_POST['mesa_id'] ?? 0),
                (int) $user['id'],
                $items,
                (string) ($_POST['observaciones'] ?? '')
            );

            Session::flash(
                'success',
                'Pedido #' . $orderId . ' registrado correctamente.'
            );
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        redirect('/pedidos');
    }

    /**
     * Actualiza el estado operativo de un pedido.
     */
    public function updateStatus(): void
    {
        AuthMiddleware::requirePermission('pedidos.update');

        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'La sesión expiró. Intenta nuevamente.');
            redirect('/pedidos');

            return;
        }

        try {
            (new Pedido())->updateStatus(
                (int) ($_POST['pedido_id'] ?? 0),
                (string) ($_POST['estado'] ?? '')
            );

            Session::flash('success', 'Estado del pedido actualizado.');
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        redirect('/pedidos');
    }
}