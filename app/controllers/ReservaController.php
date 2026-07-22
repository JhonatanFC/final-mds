<?php

declare(strict_types=1);

/**
 * Gestiona las reservas realizadas desde la página pública.
 */
final class ReservaController extends Controller
{
    /**
     * Muestra el formulario público de reserva.
     */
    public function create(): void
{
    $productoModel = new Producto();

    $this->view('reservas/crear', [
        'title' => 'Reserva tu mesa | RMRS',
        'products' => $productoModel->getPublicMenu(),
        'csrfToken' => Security::csrfToken(),
    ], 'public');
}

    /**
     * Guarda una solicitud de reserva y su adelanto pendiente de validar.
     */
    public function store(): void
    {
        if (!Security::verifyCsrf($_POST['csrf_token'] ?? null)) {
            throw new RuntimeException(
                'La sesión expiró. Actualiza la página e inténtalo nuevamente.'
            );
        }

        $voucherFile = null;

        try {
            $data = $this->validateRequest();
            $voucherFile = $this->uploadVoucher();

            $data['voucher'] = $voucherFile;

            $reservationId = (new ReservaPublica())->createReservation($data);

            Session::set('public_reservation', [
                'id' => $reservationId,
                'nombres' => $data['nombres'],
                'fecha' => $data['fecha'],
                'hora' => $data['hora'],
                'personas' => $data['personas'],
            ]);

            Session::flash(
                'success',
                'Solicitud registrada correctamente. Tu pago será revisado por recepción.'
            );

            redirect('/reservar/confirmacion');
        } catch (Throwable $exception) {
    if (
        $voucherFile !== null
        && is_file(BASE_PATH . '/uploads/vouchers/' . $voucherFile)
    ) {
        unlink(BASE_PATH . '/uploads/vouchers/' . $voucherFile);
    }

    Session::flash(
        'error',
        'No se pudo registrar la reserva: ' . $exception->getMessage()
    );

    redirect('/reservar');
}
    }

    /**
     * Muestra la confirmación posterior al registro público.
     */
    public function confirmation(): void
    {
        $reservation = Session::get('public_reservation');

        if (!is_array($reservation)) {
            redirect('/reservar');
        }

        $this->view('reservas/confirmacion', [
            'title' => 'Solicitud registrada | Reserva Fácil',
            'reservation' => $reservation,
        ], 'public');
    }

    /**
     * Valida y normaliza los datos recibidos desde el formulario público.
     *
     * @return array<string, mixed>
     */
    private function validateRequest(): array
    {
        $nombres = trim((string) ($_POST['nombres'] ?? ''));
        $apellidos = trim((string) ($_POST['apellidos'] ?? ''));
        $dni = preg_replace('/\D/', '', (string) ($_POST['dni'] ?? ''));
        $telefono = preg_replace('/\D/', '', (string) ($_POST['telefono'] ?? ''));
        $fecha = trim((string) ($_POST['fecha'] ?? ''));
        $hora = trim((string) ($_POST['hora'] ?? ''));
        $personas = (int) ($_POST['personas'] ?? 0);
        $metodo = trim((string) ($_POST['metodo'] ?? ''));
        $numeroOperacion = trim((string) ($_POST['numero_operacion'] ?? ''));

        if (mb_strlen($nombres) < 2 || mb_strlen($apellidos) < 2) {
            throw new RuntimeException('Ingresa nombres y apellidos válidos.');
        }

        if (!preg_match('/^\d{8}$/', $dni)) {
            throw new RuntimeException('El DNI debe tener exactamente ocho dígitos.');
        }

        if (strlen($telefono) < 9 || strlen($telefono) > 15) {
            throw new RuntimeException('Ingresa un número de celular válido.');
        }

        $dateObject = DateTimeImmutable::createFromFormat('Y-m-d', $fecha);

        if (
            $dateObject === false
            || $dateObject->format('Y-m-d') !== $fecha
        ) {
            throw new RuntimeException('Selecciona una fecha de reserva válida.');
        }

        if (!preg_match('/^\d{2}:\d{2}$/', $hora)) {
            throw new RuntimeException('Selecciona una hora de reserva válida.');
        }

        $reservationDateTime = new DateTimeImmutable($fecha . ' ' . $hora);

        if ($reservationDateTime <= new DateTimeImmutable()) {
            throw new RuntimeException(
                'La fecha y hora de la reserva deben ser posteriores a este momento.'
            );
        }

        if ($personas < 1 || $personas > 8) {
            throw new RuntimeException('La reserva debe ser para entre 1 y 8 personas.');
        }

        if (!in_array($metodo, ['Yape', 'Plin'], true)) {
            throw new RuntimeException('Selecciona Yape o Plin como método de pago.');
        }

        if (mb_strlen($numeroOperacion) < 4) {
            throw new RuntimeException(
                'Ingresa el número de operación del pago realizado.'
            );
        }

        return [
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'dni' => $dni,
            'telefono' => $telefono,
            'fecha' => $fecha,
            'hora' => $hora,
            'personas' => $personas,
            'metodo' => $metodo,
            'numero_operacion' => $numeroOperacion,
        ];
    }

    /**
     * Guarda el voucher adjuntado por el cliente.
     */
    private function uploadVoucher(): string
    {
        if (
            !isset($_FILES['voucher'])
            || !is_array($_FILES['voucher'])
            || (int) $_FILES['voucher']['error'] !== UPLOAD_ERR_OK
        ) {
            throw new RuntimeException('Debes adjuntar el voucher del pago.');
        }

        $fileSize = (int) $_FILES['voucher']['size'];

        if ($fileSize <= 0 || $fileSize > 5 * 1024 * 1024) {
            throw new RuntimeException(
                'El voucher debe tener un tamaño máximo de 5 MB.'
            );
        }

        $originalName = (string) $_FILES['voucher']['name'];
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

        if (!in_array($extension, $allowedExtensions, true)) {
            throw new RuntimeException(
                'El voucher debe ser un archivo JPG, JPEG, PNG o PDF.'
            );
        }

        $uploadDirectory = BASE_PATH . '/uploads/vouchers';

        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0775, true);
        }

        $fileName = 'voucher_'
            . date('Ymd_His')
            . '_'
            . bin2hex(random_bytes(8))
            . '.'
            . $extension;

        $destination = $uploadDirectory . '/' . $fileName;
        $temporaryFile = (string) $_FILES['voucher']['tmp_name'];

        if (!move_uploaded_file($temporaryFile, $destination)) {
            throw new RuntimeException(
                'No se pudo guardar el voucher. Revisa permisos de uploads/vouchers.'
            );
        }

        return $fileName;
    }
}