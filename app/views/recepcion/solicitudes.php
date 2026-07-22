<?php

declare(strict_types=1);

$success = Session::getFlash('success');
$error = Session::getFlash('error');

$pendingRequests = $pendingRequests ?? [];
$recentReviews = $recentReviews ?? [];
$csrfToken = $csrfToken ?? '';
?>

<section class="page-header">
    <div>
        <p class="eyebrow">RECEPCIÓN</p>
        <h1>Solicitudes de pago</h1>
        <p>Revisa vouchers y valida manualmente los adelantos de reservas.</p>
    </div>
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

<section class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <p class="eyebrow mb-1">VALIDACIÓN MANUAL</p>
                <h4 class="mb-0">Pagos pendientes de verificación</h4>
            </div>

            <span class="badge text-bg-warning px-3 py-2">
                <?= count($pendingRequests) ?> pendientes
            </span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Reserva</th>
                        <th>Cliente</th>
                        <th>Mesa</th>
                        <th>Pago informado</th>
                        <th>Comprobante</th>
                        <th class="text-end">Decisión</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($pendingRequests === []): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No existen pagos pendientes de verificación.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($pendingRequests as $request): ?>
                        <tr>
                            <td>
                                <strong>#<?= (int) ($request['reserva_id'] ?? 0) ?></strong>
                                <small class="d-block text-muted">
                                    <?= e((string) ($request['fecha'] ?? '-')) ?>
                                    · <?= e(substr((string) ($request['hora'] ?? ''), 0, 5)) ?>
                                </small>
                                <small class="d-block text-muted">
                                    Registrada: <?= e((string) ($request['reserva_creada'] ?? '-')) ?>
                                </small>
                            </td>

                            <td>
                                <strong>
                                    <?= e(trim(
                                        (string) ($request['nombres'] ?? '')
                                        . ' '
                                        . (string) ($request['apellidos'] ?? '')
                                    )) ?>
                                </strong>
                                <small class="d-block text-muted">
                                    DNI: <?= e((string) ($request['dni'] ?? '-')) ?>
                                </small>
                                <small class="d-block text-muted">
                                    <?= e((string) ($request['telefono'] ?? '-')) ?>
                                </small>
                            </td>

                            <td>
                                <span class="badge text-bg-secondary">
                                    <?= e((string) ($request['mesa_codigo'] ?? '-')) ?>
                                </span>
                                <small class="d-block text-muted mt-1">
                                    <?= (int) ($request['personas'] ?? 0) ?> personas
                                </small>
                            </td>

                            <td>
                                <strong>
                                    S/ <?= number_format((float) ($request['monto'] ?? 0), 2) ?>
                                </strong>
                                <small class="d-block text-muted">
                                    <?= e((string) ($request['metodo'] ?? '-')) ?>
                                </small>
                                <small class="d-block text-muted">
                                    Operación: <?= e((string) ($request['numero_operacion'] ?? '-')) ?>
                                </small>
                            </td>

                            <td>
                                <?php if (!empty($request['voucher'])): ?>
                                    <a
                                        class="btn btn-outline-primary btn-sm"
                                        href="<?= APP_URL ?>/recepcion/voucher?pago_id=<?= (int) ($request['pago_id'] ?? 0) ?>"
                                        target="_blank"
                                        rel="noopener"
                                    >
                                        <i class="bi bi-file-earmark-image"></i>
                                        Ver voucher
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">Sin comprobante adjunto</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-end">
                                <form
                                    class="d-inline"
                                    method="POST"
                                    action="<?= APP_URL ?>/recepcion/revisar-pago"
                                >
                                    <input type="hidden" name="csrf_token" value="<?= e((string) $csrfToken) ?>">
                                    <input type="hidden" name="pago_id" value="<?= (int) ($request['pago_id'] ?? 0) ?>">
                                    <input type="hidden" name="decision" value="Aceptado">

                                    <button class="btn btn-success btn-sm" type="submit">
                                        <i class="bi bi-check-circle"></i>
                                        Aceptar
                                    </button>
                                </form>

                                <form
                                    class="d-inline"
                                    method="POST"
                                    action="<?= APP_URL ?>/recepcion/revisar-pago"
                                >
                                    <input type="hidden" name="csrf_token" value="<?= e((string) $csrfToken) ?>">
                                    <input type="hidden" name="pago_id" value="<?= (int) ($request['pago_id'] ?? 0) ?>">
                                    <input type="hidden" name="decision" value="Rechazado">

                                    <button class="btn btn-outline-danger btn-sm" type="submit">
                                        <i class="bi bi-x-circle"></i>
                                        Rechazar
                                    </button>
                                </form>
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
        <p class="eyebrow mb-1">HISTORIAL</p>
        <h4 class="mb-4">Últimas decisiones de recepción</h4>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Reserva</th>
                        <th>Cliente</th>
                        <th>Fecha reservada</th>
                        <th>Pago</th>
                        <th>Resultado</th>
                        <th>Revisado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($recentReviews === []): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Aún no existen pagos revisados.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($recentReviews as $review): ?>
                        <?php $accepted = ($review['estado_revision'] ?? '') === 'Aceptado'; ?>

                        <tr>
                            <td>#<?= (int) ($review['reserva_id'] ?? 0) ?></td>
                            <td>
                                <?= e(trim(
                                    (string) ($review['nombres'] ?? '')
                                    . ' '
                                    . (string) ($review['apellidos'] ?? '')
                                )) ?>
                            </td>
                            <td>
                                <?= e((string) ($review['fecha'] ?? '-')) ?>
                                · <?= e(substr((string) ($review['hora'] ?? ''), 0, 5)) ?>
                            </td>
                            <td>
                                <?= e((string) ($review['metodo'] ?? '-')) ?>
                                · S/ <?= number_format((float) ($review['monto'] ?? 0), 2) ?>
                            </td>
                            <td>
                                <span class="badge <?= $accepted ? 'text-bg-success' : 'text-bg-danger' ?>">
                                    <?= e((string) ($review['estado_revision'] ?? '-')) ?>
                                </span>
                            </td>
                            <td><?= e((string) ($review['revisado_en'] ?? '-')) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>