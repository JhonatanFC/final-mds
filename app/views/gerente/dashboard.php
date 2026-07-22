<?php

declare(strict_types=1);

$metrics = $metrics ?? [];
$topProducts = $topProducts ?? [];
$recentCharges = $recentCharges ?? [];
?>

<section class="page-header">
    <div>
        <p class="eyebrow">GERENCIA</p>
        <h1>Dashboard ejecutivo</h1>
        <p>Resumen operativo y financiero del restaurante para hoy.</p>
    </div>
</section>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="text-muted mb-2">Ventas cobradas</p>
                <h3 class="mb-0">
                    S/ <?= number_format((float) ($metrics['sales'] ?? 0), 2) ?>
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="text-muted mb-2">Reservas hoy</p>
                <h3 class="mb-0"><?= (int) ($metrics['reservations'] ?? 0) ?></h3>
                <small class="text-success">
                    Activas: <?= (int) ($metrics['active_reservations'] ?? 0) ?>
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="text-muted mb-2">Ocupación de mesas</p>
                <h3 class="mb-0">
                    <?= (int) ($metrics['tables_occupied'] ?? 0) ?>
                    /
                    <?= (int) ($metrics['tables_total'] ?? 0) ?>
                </h3>
                <small class="text-success">
                    Libres: <?= (int) ($metrics['tables_available'] ?? 0) ?>
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="text-muted mb-2">Cuentas pendientes</p>
                <h3 class="mb-0"><?= (int) ($metrics['pending_orders'] ?? 0) ?></h3>
                <small class="text-danger">
                    Reservas expiradas:
                    <?= (int) ($metrics['expired_reservations'] ?? 0) ?>
                </small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <h4 class="mb-3">Platos más solicitados</h4>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($topProducts === []): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        Aún no hay ventas registradas hoy.
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($topProducts as $product): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars(
                                            (string) $product['nombre'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>
                                    <td class="text-center">
                                        <?= (int) $product['cantidad'] ?>
                                    </td>
                                    <td class="text-end">
                                        S/ <?= number_format((float) $product['importe'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <h4 class="mb-3">Últimos cobros</h4>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Mesa</th>
                                <th>Método</th>
                                <th>Cajera</th>
                                <th class="text-end">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recentCharges === []): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Aún no existen cobros registrados.
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($recentCharges as $charge): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars(
                                            (string) $charge['mesa_codigo'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars(
                                            (string) $charge['metodo'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars(
                                            (string) $charge['cajera_nombre'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>
                                    <td class="text-end">
                                        S/ <?= number_format((float) $charge['monto'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>