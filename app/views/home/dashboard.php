<?php

declare(strict_types=1);

$metrics = $metrics ?? [];
$topProducts = $topProducts ?? [];
$recentCharges = $recentCharges ?? [];

$salesToday = (float) (
    $metrics['sales_today']
    ?? $metrics['ventas_dia']
    ?? 0
);

$reservationsToday = (int) (
    $metrics['reservations_today']
    ?? $metrics['reservas_hoy']
    ?? 0
);

$activeReservations = (int) (
    $metrics['active_reservations']
    ?? $metrics['reservas_activas']
    ?? 0
);

$occupiedTables = (int) (
    $metrics['occupied_tables']
    ?? $metrics['mesas_ocupadas']
    ?? 0
);

$availableTables = (int) (
    $metrics['available_tables']
    ?? $metrics['mesas_libres']
    ?? 0
);

$totalTables = (int) (
    $metrics['total_tables']
    ?? $metrics['mesas_total']
    ?? ($occupiedTables + $availableTables)
);

$openOrders = (int) (
    $metrics['open_orders']
    ?? $metrics['pedidos_abiertos']
    ?? 0
);

$occupationPercent = $totalTables > 0
    ? min(100, max(0, (int) round(($occupiedTables / $totalTables) * 100)))
    : 0;

$today = date('d/m/Y');
?>

<section class="dashboard-hero">
    <div>
        <p class="eyebrow">RMRS · OPERACIÓN</p>
        <h1>Dashboard RMRS</h1>
        <p>Control ejecutivo de reservas, mesas, pedidos y ventas del restaurante.</p>
    </div>

    <div class="dashboard-date">
        <i class="bi bi-calendar3"></i>
        <?= e($today) ?>
    </div>
</section>

<section class="dashboard-metrics">
    <article class="dashboard-metric-card metric-sales">
        <span class="metric-icon">
            <i class="bi bi-cash-stack"></i>
        </span>

        <small>Ventas cobradas</small>
        <strong>S/ <?= number_format($salesToday, 2) ?></strong>
        <p>Ingresos registrados hoy</p>
    </article>

    <article class="dashboard-metric-card metric-reservations">
        <span class="metric-icon">
            <i class="bi bi-calendar-check"></i>
        </span>

        <small>Reservas hoy</small>
        <strong><?= $reservationsToday ?></strong>
        <p>Activas: <?= $activeReservations ?></p>
    </article>

    <article class="dashboard-metric-card metric-tables">
        <span class="metric-icon">
            <i class="bi bi-grid-3x3-gap"></i>
        </span>

        <small>Mesas ocupadas</small>
        <strong><?= $occupiedTables ?> / <?= $totalTables ?></strong>
        <p><?= $availableTables ?> disponibles</p>
    </article>

    <article class="dashboard-metric-card metric-orders">
        <span class="metric-icon">
            <i class="bi bi-receipt"></i>
        </span>

        <small>Pedidos abiertos</small>
        <strong><?= $openOrders ?></strong>
        <p>Por atender o cobrar</p>
    </article>
</section>

<section class="dashboard-content-grid">
    <article class="dashboard-panel dashboard-occupation-panel">
        <div class="dashboard-panel-header">
            <div>
                <p class="eyebrow">OPERACIÓN</p>
                <h2>Ocupación del restaurante</h2>
            </div>

            <span class="panel-icon">
                <i class="bi bi-bar-chart-line"></i>
            </span>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted fw-semibold">Capacidad utilizada</span>
            <strong><?= $occupationPercent ?>%</strong>
        </div>

        <div class="occupation-progress" aria-label="Ocupación <?= $occupationPercent ?>%">
            <span style="width: <?= $occupationPercent ?>%;"></span>
        </div>

        <div class="occupation-summary">
            <div>
                <span>Ocupadas</span>
                <strong><?= $occupiedTables ?></strong>
            </div>

            <div>
                <span>Libres</span>
                <strong><?= $availableTables ?></strong>
            </div>

            <div>
                <span>Total</span>
                <strong><?= $totalTables ?></strong>
            </div>
        </div>

        <div class="mt-4">
            <a class="dashboard-panel-link" href="<?= APP_URL ?>/recepcion">
                Gestionar reservas
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </article>

    <article class="dashboard-panel dashboard-products-panel">
        <div class="dashboard-panel-header">
            <div>
                <p class="eyebrow">MENÚ</p>
                <h2>Más solicitados</h2>
            </div>

            <span class="panel-icon">
                <i class="bi bi-trophy"></i>
            </span>
        </div>

        <?php if ($topProducts === []): ?>
            <div class="dashboard-empty-small">
                <div>
                    <i class="bi bi-bar-chart"></i>
                    <p>Aún no hay pedidos registrados hoy.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="top-products-list">
                <?php foreach (array_slice($topProducts, 0, 5) as $index => $product): ?>
                    <?php
                    $name = (string) (
                        $product['nombre']
                        ?? $product['producto']
                        ?? 'Producto'
                    );

                    $quantity = (int) (
                        $product['cantidad']
                        ?? $product['total_cantidad']
                        ?? 0
                    );

                    $total = (float) (
                        $product['total']
                        ?? $product['ventas']
                        ?? 0
                    );
                    ?>

                    <div class="top-product-item">
                        <span class="product-position">
                            <?= $index + 1 ?>
                        </span>

                        <div>
                            <strong><?= e($name) ?></strong>
                            <small><?= $quantity ?> unidades solicitadas</small>
                        </div>

                        <span class="product-total">
                            S/ <?= number_format($total, 2) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </article>
</section>

<section class="dashboard-panel dashboard-charges-panel">
    <div class="dashboard-panel-header">
        <div>
            <p class="eyebrow">CAJA</p>
            <h2>Últimos cobros</h2>
        </div>

        <a class="dashboard-panel-link" href="<?= APP_URL ?>/caja">
            Ver caja
            <i class="bi bi-arrow-up-right"></i>
        </a>
    </div>

    <?php if ($recentCharges === []): ?>
        <div class="dashboard-empty">
            <div>
                <i class="bi bi-cash-coin"></i>
                <p>Aún no hay cobros registrados durante el día.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
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
                    <?php foreach (array_slice($recentCharges, 0, 6) as $charge): ?>
                        <?php
                        $createdAt = (string) ($charge['creado'] ?? '');
                        $time = $createdAt !== ''
                            ? date('H:i', strtotime($createdAt))
                            : '-';
                        ?>

                        <tr>
                            <td>
                                <span class="table-code">
                                    <?= e((string) ($charge['mesa_codigo'] ?? '-')) ?>
                                </span>
                            </td>

                            <td><?= e((string) ($charge['metodo'] ?? '-')) ?></td>

                            <td><?= e((string) ($charge['comprobante'] ?? '-')) ?></td>

                            <td>
                                <?= e(
                                    (string) (
                                        $charge['numero_operacion']
                                        ?? '-'
                                    )
                                ) ?>
                            </td>

                            <td><?= e($time) ?></td>

                            <td class="text-end">
                                <strong>
                                    S/ <?= number_format(
                                        (float) ($charge['monto'] ?? 0),
                                        2
                                    ) ?>
                                </strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>