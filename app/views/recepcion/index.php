<?php

declare(strict_types=1);

$success = Session::getFlash('success');
$error = Session::getFlash('error');

$reservas = $reservas ?? [];
$mesas = $mesas ?? [];
$espera = $espera ?? [];

$pagosPendientes = (int) ($pagosPendientes ?? 0);
$reservasConfirmadas = (int) ($reservasConfirmadas ?? 0);
$llegadasConfirmadas = (int) ($llegadasConfirmadas ?? 0);
$mesasLibres = (int) ($mesasLibres ?? 0);
$mesasOcupadas = (int) ($mesasOcupadas ?? 0);
$mesasReservadas = (int) ($mesasReservadas ?? 0);

$csrfToken = $csrfToken ?? '';
?>

<section class="page-header">
    <div>
        <p class="eyebrow">RECEPCIÓN</p>
        <h1>Operación de reservas</h1>
        <p>
            Confirma llegadas, revisa las reservas del día y controla el estado
            actual de las mesas.
        </p>
    </div>

    <a class="btn btn-primary" href="<?= APP_URL ?>/recepcion/solicitudes">
        <i class="bi bi-clipboard-check me-1"></i>
        Solicitudes de pago
        <?php if ($pagosPendientes > 0): ?>
            <span class="badge text-bg-light ms-1"><?= $pagosPendientes ?></span>
        <?php endif; ?>
    </a>
</section>

<?php if ($success !== null): ?>
    <div class="alert alert-success shadow-sm">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?= e((string) $success) ?>
    </div>
<?php endif; ?>

<?php if ($error !== null): ?>
    <div class="alert alert-danger shadow-sm">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?= e((string) $error) ?>
    </div>
<?php endif; ?>

<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <section class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="eyebrow">LLEGADA DEL CLIENTE</p>
                <h2 class="h4 mb-2">Confirmar llegada</h2>

                <p class="text-muted mb-4">
                    Ingresa el DNI cuando el cliente llegue al restaurante.
                    Solo se pueden recibir reservas con pago aprobado.
                </p>

                <form method="POST" action="<?= APP_URL ?>/recepcion/confirmar-llegada">
                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= e((string) $csrfToken) ?>"
                    >

                    <label class="form-label" for="dni">
                        DNI del cliente
                    </label>

                    <div class="input-group">
                        <input
                            class="form-control"
                            id="dni"
                            name="dni"
                            type="text"
                            inputmode="numeric"
                            pattern="[0-9]{8}"
                            maxlength="8"
                            placeholder="12345678"
                            required
                        >

                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-person-check me-1"></i>
                            Confirmar
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <a
                    class="text-decoration-none small fw-semibold"
                    href="<?= APP_URL ?>/lista-espera"
                >
                    <i class="bi bi-hourglass-split me-1"></i>
                    Gestionar lista de espera
                </a>
            </div>
        </section>
    </div>

    <div class="col-lg-8">
        <section class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="eyebrow">RESUMEN DEL DÍA</p>

                <div class="row text-center g-3">
                    <div class="col-6 col-md-3">
                        <strong class="fs-2"><?= $pagosPendientes ?></strong>
                        <p class="text-muted mb-0">Pagos por revisar</p>
                    </div>

                    <div class="col-6 col-md-3">
                        <strong class="fs-2"><?= count($reservas) ?></strong>
                        <p class="text-muted mb-0">Reservas hoy</p>
                    </div>

                    <div class="col-6 col-md-3">
                        <strong class="fs-2"><?= $reservasConfirmadas ?></strong>
                        <p class="text-muted mb-0">Confirmadas</p>
                    </div>

                    <div class="col-6 col-md-3">
                        <strong class="fs-2"><?= $llegadasConfirmadas ?></strong>
                        <p class="text-muted mb-0">Clientes atendidos</p>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row text-center g-3">
                    <div class="col-4">
                        <span class="badge text-bg-success mb-2">Libre</span>
                        <p class="fs-4 fw-bold mb-0"><?= $mesasLibres ?></p>
                    </div>

                    <div class="col-4">
                        <span class="badge text-bg-warning mb-2">Reservada</span>
                        <p class="fs-4 fw-bold mb-0"><?= $mesasReservadas ?></p>
                    </div>

                    <div class="col-4">
                        <span class="badge text-bg-danger mb-2">Ocupada</span>
                        <p class="fs-4 fw-bold mb-0"><?= $mesasOcupadas ?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<section class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4">
            <div>
                <p class="eyebrow mb-1">OPERACIÓN DEL DÍA</p>
                <h2 class="h4 mb-0">Reservas programadas para hoy</h2>
            </div>

            <span class="badge text-bg-primary px-3 py-2">
                <?= count($reservas) ?> registradas
            </span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Cliente</th>
                        <th>Mesa</th>
                        <th>Personas</th>
                        <th>Pago</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($reservas === []): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-calendar-x d-block fs-2 mb-2"></i>
                                No existen reservas registradas para hoy.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($reservas as $reserva): ?>
                        <?php
                        $estadoReserva = (string) ($reserva['estado'] ?? '-');
                        $pagoValidado = (int) ($reserva['validado'] ?? 0) === 1;
                        $hora = substr((string) ($reserva['hora'] ?? ''), 0, 5);

                        $estadoClase = match ($estadoReserva) {
                            'Confirmada' => 'text-bg-success',
                            'EnCurso' => 'text-bg-primary',
                            'Expirada', 'Cancelada' => 'text-bg-danger',
                            default => 'text-bg-warning',
                        };
                        ?>

                        <tr>
                            <td>
                                <strong><?= e($hora) ?></strong>
                            </td>

                            <td>
                                <strong>
                                    <?= e(
                                        trim(
                                            (string) ($reserva['nombres'] ?? '')
                                            . ' '
                                            . (string) ($reserva['apellidos'] ?? '')
                                        )
                                    ) ?>
                                </strong>

                                <small class="d-block text-muted">
                                    DNI: <?= e((string) ($reserva['dni'] ?? '-')) ?>
                                </small>

                                <small class="d-block text-muted">
                                    <?= e((string) ($reserva['telefono'] ?? '-')) ?>
                                </small>
                            </td>

                            <td>
                                <span class="badge text-bg-secondary">
                                    <?= e((string) ($reserva['mesa_codigo'] ?? '-')) ?>
                                </span>
                            </td>

                            <td><?= (int) ($reserva['personas'] ?? 0) ?></td>

                            <td>
                                <strong>
                                    S/ <?= number_format(
                                        (float) ($reserva['adelanto'] ?? 30),
                                        2
                                    ) ?>
                                </strong>

                                <small class="d-block text-muted">
                                    <?= e((string) ($reserva['metodo'] ?? 'Sin método')) ?>
                                </small>

                                <?php if ($pagoValidado): ?>
                                    <span class="badge text-bg-success mt-1">
                                        Pago aprobado
                                    </span>
                                <?php else: ?>
                                    <span class="badge text-bg-warning mt-1">
                                        Pago pendiente
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <span class="badge <?= e($estadoClase) ?>">
                                    <?= e($estadoReserva) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="card shadow-sm border-0">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4">
            <div>
                <p class="eyebrow mb-1">MAPA OPERATIVO</p>
                <h2 class="h4 mb-0">Estado de mesas</h2>
            </div>

            <a class="btn btn-outline-primary btn-sm" href="<?= APP_URL ?>/mesas">
                Administrar mesas
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3">
            <?php foreach ($mesas as $mesa): ?>
                <?php
                $estadoMesa = (string) ($mesa['estado'] ?? 'Libre');

                $claseMesa = match ($estadoMesa) {
                    'Libre' => 'border-success',
                    'Reservada' => 'border-warning',
                    'Ocupada' => 'border-danger',
                    default => 'border-secondary',
                };
                ?>

                <div class="col-6 col-md-4 col-xl-3">
                    <article class="card h-100 border-2 <?= e($claseMesa) ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <strong class="fs-5">
                                    <?= e((string) ($mesa['codigo'] ?? '-')) ?>
                                </strong>

                                <span class="badge text-bg-light">
                                    <?= (int) ($mesa['capacidad'] ?? 0) ?> pers.
                                </span>
                            </div>

                            <p class="mb-0 mt-3 text-muted small">
                                <?= e((string) ($mesa['ubicacion'] ?? 'Sin ubicación')) ?>
                            </p>

                            <span class="badge mt-2 <?= e(
                                match ($estadoMesa) {
                                    'Libre' => 'text-bg-success',
                                    'Reservada' => 'text-bg-warning',
                                    'Ocupada' => 'text-bg-danger',
                                    default => 'text-bg-secondary',
                                }
                            ) ?>">
                                <?= e($estadoMesa) ?>
                            </span>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>

            <?php if ($mesas === []): ?>
                <div class="col-12 text-center text-muted py-4">
                    No hay mesas registradas.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>