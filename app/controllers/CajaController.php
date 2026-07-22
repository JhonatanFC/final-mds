<?php

declare(strict_types=1);

/**
 * Controlador del módulo de caja.
 */
final class CajaController extends Controller
{
    /**
     * Muestra los pedidos pendientes de cobro y los cobros del día.
     */
    public function index(): void
    {
        AuthMiddleware::requirePermission('caja.view');

        $cajaModel = new Caja();

        $this->view('caja/index', [
            'title' => 'Caja | RMRS',
            'user' => AuthMiddleware::user(),
            'modules' => [],
            'pendingCharges' => $cajaModel->getPendingCharges(),
            'todayCharges' => $cajaModel->getTodayCharges(),
            'summary' => $cajaModel->getTodaySummary(),
            'csrfToken' => Security::csrfToken(),
        ], 'dashboard');
    }

    /**
     * Registra el cobro final de un pedido.
     */
    public function charge(): void
    {
        AuthMiddleware::requirePermission('caja.charge');

        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            Session::flash('error', 'La sesión expiró. Actualiza la página.');
            redirect('/caja');
        }

        try {
            $user = AuthMiddleware::user();

            if ($user === null) {
                throw new RuntimeException('No se encontró la sesión de caja.');
            }

            $message = (new Caja())->chargeOrder(
                (int) ($_POST['pedido_id'] ?? 0),
                (int) $user['id'],
                trim((string) ($_POST['metodo'] ?? '')),
                trim((string) ($_POST['comprobante'] ?? '')),
                trim((string) ($_POST['numero_operacion'] ?? ''))
            );

            Session::flash('success', $message);
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        redirect('/caja');
    }
}