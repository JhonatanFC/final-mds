<?php

declare(strict_types=1);

/**
 * Controlador de la lista de espera FIFO.
 */
final class ListaEsperaController extends Controller
{
    /**
     * Muestra solicitudes pendientes, historial y mesas libres.
     */
    public function index(): void
    {
        AuthMiddleware::requirePermission('reservas.view');

        $model = new ListaEspera();

        $this->view('recepcion/lista_espera', [
            'title' => 'Lista de espera | RMRS',
            'user' => AuthMiddleware::user(),
            'waitingList' => $model->getPending(),
            'history' => $model->getRecent(),
            'availableTables' => $model->getAvailableTables(),
            'csrfToken' => Security::csrfToken(),
        ], 'dashboard');
    }

    /**
     * Registra un cliente en la lista de espera.
     */
    public function store(): void
    {
        AuthMiddleware::requirePermission('reservas.view');

        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            Session::flash(
                'error',
                'La sesión expiró. Actualiza la página e inténtalo nuevamente.'
            );

            redirect('/lista-espera');
            return;
        }

        try {
            $model = new ListaEspera();

            $model->add(
                trim((string) ($_POST['nombres'] ?? '')),
                trim((string) ($_POST['telefono'] ?? '')),
                (int) ($_POST['personas'] ?? 0)
            );

            Session::flash('success', 'Cliente agregado a la lista de espera.');
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        redirect('/lista-espera');
    }

    /**
     * Asigna una mesa libre a una solicitud pendiente.
     */
    public function assign(): void
    {
        AuthMiddleware::requirePermission('reservas.view');

        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            Session::flash(
                'error',
                'La sesión expiró. Actualiza la página e inténtalo nuevamente.'
            );

            redirect('/lista-espera');
            return;
        }

        try {
            $model = new ListaEspera();

            $message = $model->assignTable(
                (int) ($_POST['lista_espera_id'] ?? 0),
                (int) ($_POST['mesa_id'] ?? 0)
            );

            Session::flash('success', $message);
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        redirect('/lista-espera');
    }

    /**
     * Cancela una solicitud pendiente.
     */
    public function cancel(): void
    {
        AuthMiddleware::requirePermission('reservas.view');

        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            Session::flash(
                'error',
                'La sesión expiró. Actualiza la página e inténtalo nuevamente.'
            );

            redirect('/lista-espera');
            return;
        }

        try {
            $model = new ListaEspera();

            $model->cancel((int) ($_POST['lista_espera_id'] ?? 0));

            Session::flash('success', 'Solicitud cancelada correctamente.');
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        redirect('/lista-espera');
    }
}