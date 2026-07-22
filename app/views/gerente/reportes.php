<?php

declare(strict_types=1);

$summary = $summary ?? [];
$salesByMethod = $salesByMethod ?? [];
$topProducts = $topProducts ?? [];
$dailySales = $dailySales ?? [];
$recentCharges = $recentCharges ?? [];
$date = $date ?? date('Y-m-d');

$labels = array_column($dailySales, 'hora');
$values = array_map(
    static fn (array $sale): float => (float) $sale['total'],
    $dailySales
);
?>

<section class="page-header">
    <div>
        <p class="eyebrow">GERENCIA</p>
        <h1>Reportes de operación</h1>
        <p>Consulta ventas, medios de pago y desempeño del menú.</p>
    </div>

    <form method="GET" action="<?= APP_URL ?>/reportes" class="d-flex gap-2">
        <input
            class="form-control"
            name="fecha"
            type="date"
            value="<?= e((string) $date) ?>"
        >

        <button class="btn btn-primary" type="submit">
            <i class="bi bi-search"></i>
            Consultar
        </button>
    </form>
</section>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <article class="metric-card">
            <i class="bi bi-cash-coin"></i>
            <span>Ventas cobradas</span>
            <strong>S/ <?= number_format((float) ($summary['ventas'] ?? 0), 2) ?></strong>
        </article>
    </div>

    <div class="col-md-6 col-xl-3">
        <article class="metric-card">
            <i class="bi bi-receipt"></i>
            <span>Cobros realizados</span>
            <strong><?= (int) ($summary['cobros_realizados'] ?? 0) ?></strong>
        </article>
    </div>

    <div class="col-md-6 col-xl-3">
        <article class="metric-card">
            <i class="bi bi-wallet2"></i>
            <span>Adelantos aplicados</span>
            <strong>S/ <?= number_format((float) ($summary['adelantos_aplicados'] ?? 0), 2) ?></strong>
        </article>
    </div>

    <div class="col-md-6 col-xl-3">
        <article class="metric-card">
            <i class="bi bi-cup-hot"></i>
            <span>Consumo bruto</span>
            <strong>S/ <?= number_format((float) ($summary['consumo_total'] ?? 0), 2) ?></strong>
        </article>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <section class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="eyebrow">VENTAS POR HORA</p>
                <h4>Comportamiento del día</h4>

                <canvas id="sales-chart" height="130"></canvas>
            </div>
        </section>
    </div>

    <div class="col-lg-5">
        <section class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="eyebrow">MEDIOS DE PAGO</p>
                <h4>Resumen de cobros</h4>

                <?php if ($salesByMethod === []): ?>
                    <p class="text-muted mb-0">No existen cobros para esta fecha.</p>
                <?php else: ?>
                    <?php foreach ($salesByMethod as $sale): ?>
                        <div class="d-flex justify-content-between border-bottom py-3">
                            <div>
                                <strong><?= e((string) $sale['metodo']) ?></strong>
                                <small class="d-block text-muted">
                                    <?= (int) $sale['cantidad'] ?> operación(es)
                                </small>
                            </div>

                            <strong>S/ <?= number_format((float) $sale['total'], 2) ?></strong>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <section class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="eyebrow">TOP PRODUCTOS</p>
                <h4>Más vendidos</h4>

                <?php if ($topProducts === []): ?>
                    <p class="text-muted mb-0">Aún no existen productos cobrados.</p>
                <?php else: ?>
                    <ol class="list-group list-group-numbered">
                        <?php foreach ($topProducts as $product): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?= e((string) $product['nombre']) ?></strong>
                                    <small class="d-block text-muted">
                                        <?= (int) $product['cantidad'] ?> unidad(es)
                                    </small>
                                </div>

                                <span class="badge text-bg-primary rounded-pill">
                                    S/ <?= number_format((float) $product['total'], 2) ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <div class="col-lg-7">
        <section class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="eyebrow">ÚLTIMOS COBROS</p>
                <h4>Movimientos registrados</h4>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Mesa</th>
                                <th>Cajera</th>
                                <th>Pago</th>
                                <th class="text-end">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recentCharges === []): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Sin cobros registrados.
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($recentCharges as $charge): ?>
                                <tr>
                                    <td><?= e(date('H:i', strtotime((string) $charge['creado']))) ?></td>
                                    <td><strong><?= e((string) $charge['mesa_codigo']) ?></strong></td>
                                    <td><?= e((string) $charge['cajera_nombre']) ?></td>
                                    <td>
                                        <span class="badge text-bg-light">
                                            <?= e((string) $charge['metodo']) ?>
                                        </span>
                                    </td>
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
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('sales-chart');

    if (!canvas || typeof Chart === 'undefined') {
        return;
    }

    new Chart(canvas, {
        type: 'line',
        data: {
            labels: <?= json_encode($labels, JSON_UNESCAPED_UNICODE) ?>,
            datasets: [{
                label: 'Ventas (S/)',
                data: <?= json_encode($values) ?>,
                borderColor: '#f87060',
                backgroundColor: 'rgba(248, 112, 96, 0.16)',
                fill: true,
                tension: 0.35,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>