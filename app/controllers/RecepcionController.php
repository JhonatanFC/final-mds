<?php

declare(strict_types=1);

final class RecepcionController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::requirePermission('reservas.view');

        $reservaModel = new Reserva();

        $reservaModel->expireOverdueReservations();

        $reservas = $reservaModel->getTodayReservations();
        $mesas = $reservaModel->getTables();
        $espera = $reservaModel->getWaitingList();

        $pagosPendientes = 0;
        $reservasConfirmadas = 0;
        $llegadasConfirmadas = 0;

        foreach ($reservas as $reserva) {
            $validado = (int) ($reserva['validado'] ?? 0) === 1;
            $estado = (string) ($reserva['estado'] ?? '');

            if (!$validado && $estado === 'PendientePago') {
                $pagosPendientes++;
            }

            if ($estado === 'Confirmada') {
                $reservasConfirmadas++;
            }

            if ($estado === 'EnCurso') {
                $llegadasConfirmadas++;
            }
        }

        $mesasLibres = 0;
        $mesasOcupadas = 0;
        $mesasReservadas = 0;

        foreach ($mesas as $mesa) {
            $estado = (string) ($mesa['estado'] ?? '');

            if ($estado === 'Libre') {
                $mesasLibres++;
            }

            if ($estado === 'Ocupada') {
                $mesasOcupadas++;
            }

            if ($estado === 'Reservada') {
                $mesasReservadas++;
            }
        }

        $this->view('recepcion/index', [
            'title' => 'Recepción | RMRS',
            'user' => AuthMiddleware::user(),
            'reservas' => $reservas,
            'mesas' => $mesas,
            'espera' => $espera,
            'pagosPendientes' => $pagosPendientes,
            'reservasConfirmadas' => $reservasConfirmadas,
            'llegadasConfirmadas' => $llegadasConfirmadas,
            'mesasLibres' => $mesasLibres,
            'mesasOcupadas' => $mesasOcupadas,
            'mesasReservadas' => $mesasReservadas,
            'csrfToken' => Security::csrfToken(),
        ], 'dashboard');
    }

    public function confirmArrival(): void
    {
        AuthMiddleware::requirePermission('reservas.confirm');

        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            Session::flash('error', 'La sesión expiró. Actualiza la página e inténtalo nuevamente.');
            redirect('/recepcion');
            return;
        }

        $dni = trim((string) ($_POST['dni'] ?? ''));

        if (!preg_match('/^\d{8}$/', $dni)) {
            Session::flash('error', 'Ingresa un DNI válido de 8 dígitos.');
            redirect('/recepcion');
            return;
        }

        try {
            $mensaje = (new Reserva())->confirmArrivalByDni($dni);

            Session::flash('success', $mensaje);
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        redirect('/recepcion');
    }

    public function requests(): void
{
    AuthMiddleware::requirePermission('reservas.view');

    $reservaModel = new Reserva();

    $this->view('recepcion/solicitudes', [
        'title' => 'Solicitudes de pago | RMRS',
        'user' => AuthMiddleware::user(),
        'pendingRequests' => $reservaModel->getPendingPaymentRequests(),
        'recentReviews' => $reservaModel->getRecentPaymentReviews(),
        'csrfToken' => Security::csrfToken(),
    ], 'dashboard');
}

    public function reviewPayment(): void
    {
        AuthMiddleware::requirePermission('reservas.confirm');

        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            Session::flash('error', 'La sesión expiró. Actualiza la página e inténtalo nuevamente.');
            redirect('/recepcion/solicitudes');
            return;
        }

        $pagoId = (int) ($_POST['pago_id'] ?? 0);
        $decision = trim((string) ($_POST['decision'] ?? ''));
        $observacion = trim((string) ($_POST['observacion'] ?? ''));

        if ($pagoId <= 0) {
            Session::flash('error', 'La solicitud de pago no es válida.');
            redirect('/recepcion/solicitudes');
            return;
        }

        if (!in_array($decision, ['Aceptado', 'Rechazado'], true)) {
            Session::flash('error', 'Selecciona una decisión válida.');
            redirect('/recepcion/solicitudes');
            return;
        }

        $usuario = AuthMiddleware::user();

        if ($usuario === null) {
            Session::flash('error', 'No se encontró la sesión del usuario.');
            redirect('/login');
            return;
        }

        try {
            $mensaje = (new Reserva())->reviewPayment(
                $pagoId,
                $decision,
                (int) $usuario['id'],
                $observacion
            );

            Session::flash('success', $mensaje);
        } catch (Throwable $exception) {
            Session::flash('error', $exception->getMessage());
        }

        redirect('/recepcion/solicitudes');
    }

    public function downloadVoucher(): void
    {
        AuthMiddleware::requirePermission('reservas.view');

        $pagoId = (int) ($_GET['pago_id'] ?? 0);

        if ($pagoId <= 0) {
            http_response_code(404);
            exit('Comprobante no válido.');
        }

        $reservaModel = new Reserva();
        $voucher = $reservaModel->getVoucherByPaymentId($pagoId);

        if ($voucher === false) {
            http_response_code(404);
            exit('Comprobante no encontrado.');
        }

        $fileName = basename((string) $voucher['voucher']);

        $filePath = BASE_PATH . '/uploads/vouchers/' . $fileName;

        if (!is_file($filePath)) {
            http_response_code(404);
            exit('El archivo del comprobante no existe.');
        }

        $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';

        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . (string) filesize($filePath));
        header(
            'Content-Disposition: inline; filename="' . rawurlencode($fileName) . '"'
        );

        readfile($filePath);
        exit;
    }
}