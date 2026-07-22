<?php

declare(strict_types=1);

$success = Session::getFlash('success');
$error = Session::getFlash('error');

$pendingCharges = $pendingCharges ?? [];
$todayCharges = $todayCharges ?? [];
$summary = $summary ?? [
    'total_cobros' => 0,
    'ventas_dia' => 0,
];

$csrfToken = $csrfToken ?? '';
?>

<section class="page-header">
    <div>
        <p class="eyebrow">CAJA</p>
        <h1>Cobro de consumos</h1>
        <p>Aplica adelantos validados y registra el pago final de cada mesa.</p>
    </div>
</section>

<?php if ($success !== null): ?>
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?= e((string) $success) ?>
    </div>
<?php endif; ?>

<?php if ($error !== null): ?>
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?= e((string) $error) ?>
    </div>
<?php endif; ?>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="eyebrow mb-1">VENTAS DEL DÍA</p>
                <h2 class="mb-0">
                    S/ <?= number_format((float) $summary['ventas_dia'], 2) ?>
                </h2>
                <small class="text-muted">Monto cobrado a clientes.</small>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="eyebrow mb-1">COBROS REALIZADOS</p>
                <h2 class="mb-0"><?= (int) $summary['total_cobros'] ?></h2>
                <small class="text-muted">Operaciones cerradas hoy.</small>
            </div>
        </div>
    </div>
</div>

<section class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <p class="eyebrow mb-1">PENDIENTES</p>
                <h4 class="mb-0">Pedidos por cobrar</h4>
            </div>

            <span class="badge text-bg-warning">
                <?= count($pendingCharges) ?> pendientes
            </span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Mesa</th>
                        <th>Cliente</th>
                        <th>Consumo</th>
                        <th>Adelanto</th>
                        <th>Total a cobrar</th>
                        <th class="text-end">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($pendingCharges === []): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No existen pedidos pendientes de cobro.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($pendingCharges as $charge): ?>
                        <?php
                        $subtotal = (float) ($charge['subtotal'] ?? 0);
                        $discount = (float) ($charge['descuento'] ?? 0);
                        $consumption = max(0, $subtotal - $discount);
                        $advance = min(
                            (float) ($charge['adelanto_validado'] ?? 0),
                            $consumption
                        );
                        $totalToPay = max(0, $consumption - $advance);
                        ?>
                        <tr>
                            <td>
                                <span class="badge text-bg-secondary">
                                    <?= e((string) $charge['mesa_codigo']) ?>
                                </span>
                            </td>
                            <td>
                                <?= e(
                                    trim(
                                        (string) ($charge['cliente_nombres'] ?? '')
                                        . ' '
                                        . (string) ($charge['cliente_apellidos'] ?? '')
                                    ) ?: 'Cliente directo'
                                ) ?>
                            </td>
                            <td>S/ <?= number_format($consumption, 2) ?></td>
                            <td class="text-success">
                                - S/ <?= number_format($advance, 2) ?>
                            </td>
                            <td>
                                <strong>S/ <?= number_format($totalToPay, 2) ?></strong>
                            </td>
                            <td class="text-end">
                                <button
                                    class="btn btn-primary btn-sm"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#chargeModal<?= (int) $charge['id'] ?>"
                                >
                                    <i class="bi bi-cash-coin"></i>
                                    Cobrar
                                </button>
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
        <h4 class="mb-3">Cobros realizados hoy</h4>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Mesa</th>
                        <th>Método</th>
                        <th>Comprobante</th>
                        <th>Operación</th>
                        <th>Hora</th>
                        <th class="text-end">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($todayCharges === []): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Aún no existen cobros registrados hoy.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($todayCharges as $charge): ?>
                        <tr>
                            <td><?= e((string) $charge['mesa_codigo']) ?></td>
                            <td><?= e((string) $charge['metodo']) ?></td>
                            <td><?= e((string) $charge['comprobante']) ?></td>
                            <td><?= e((string) ($charge['numero_operacion'] ?? '-')) ?></td>
                            <td><?= e(date('H:i', strtotime((string) $charge['creado']))) ?></td>
                            <td class="text-end">
                                <strong>S/ <?= number_format((float) $charge['monto'], 2) ?></strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php foreach ($pendingCharges as $charge): ?>
    <?php
    $subtotal = (float) ($charge['subtotal'] ?? 0);
    $discount = (float) ($charge['descuento'] ?? 0);
    $consumption = max(0, $subtotal - $discount);
    $advance = min(
        (float) ($charge['adelanto_validado'] ?? 0),
        $consumption
    );
    $totalToPay = max(0, $consumption - $advance);
    ?>

    <div
        class="modal fade"
        id="chargeModal<?= (int) $charge['id'] ?>"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="<?= APP_URL ?>/caja/cobrar">
                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= e((string) $csrfToken) ?>"
                    >

                    <input
                        type="hidden"
                        name="pedido_id"
                        value="<?= (int) $charge['id'] ?>"
                    >

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Cobrar mesa <?= e((string) $charge['mesa_codigo']) ?>
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Cerrar"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <div class="cash-summary">
    <div class="cash-summary-item">
        <span>Consumo</span>
        <strong>S/ <?= number_format($consumption, 2) ?></strong>
    </div>

    <div class="cash-summary-item cash-summary-advance">
        <span>Adelanto aplicado</span>
        <strong>- S/ <?= number_format($advance, 2) ?></strong>
    </div>

    <div class="cash-summary-item cash-summary-total">
        <span>Total a cobrar</span>
        <strong>S/ <?= number_format($totalToPay, 2) ?></strong>
    </div>
</div>

                        <div class="mb-3">
                            <label class="form-label" for="metodo<?= (int) $charge['id'] ?>">
                                Método de pago
                            </label>

                            <select
                                class="form-select"
                                id="metodo<?= (int) $charge['id'] ?>"
                                name="metodo"
                                required
                            >
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Yape">Yape</option>
                                <option value="Plin">Plin</option>
                                <option value="QR">QR</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Comprobante</label>

                            <select class="form-select" name="comprobante" required>
                                <option value="Boleta">Boleta</option>
                                <option value="Factura">Factura</option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Número de operación</label>

                            <input
                                class="form-control"
                                name="numero_operacion"
                                type="text"
                                maxlength="100"
                                placeholder="Obligatorio para Yape, Plin o QR"
                            >
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Cancelar
                        </button>

                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-check-circle"></i>
                            Confirmar cobro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>