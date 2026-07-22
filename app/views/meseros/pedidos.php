<?php

declare(strict_types=1);

$success = Session::flash('success');
$error = Session::flash('error');

$tables = $tables ?? [];
$products = $products ?? [];
$orders = $orders ?? [];
$csrfToken = $csrfToken ?? '';
?>

<section class="page-header">
    <div>
        <p class="eyebrow">OPERACIÓN</p>
        <h1>Pedidos de mesas</h1>
        <p>Registra consumos, controla el stock y envía pedidos a preparación.</p>
    </div>
</section>

<?php if ($success !== null): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars((string) $success, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if ($error !== null): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h4 class="mb-3">Nuevo pedido</h4>

                <?php if ($tables === []): ?>
                    <div class="alert alert-warning mb-0">
                        No existen mesas disponibles.
                    </div>
                <?php elseif ($products === []): ?>
                    <div class="alert alert-warning mb-0">
                        No existen productos activos con stock disponible.
                    </div>
                <?php else: ?>
                    <form method="POST" action="<?= APP_URL ?>/pedidos/guardar" id="order-form">
                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>"
                        >

                        <div class="mb-3">
                            <label for="mesa_id" class="form-label">Mesa</label>
                            <select class="form-select" id="mesa_id" name="mesa_id" required>
                                <option value="">Selecciona una mesa</option>

                                <?php foreach ($tables as $table): ?>
                                    <option value="<?= (int) $table['id'] ?>">
                                        <?= htmlspecialchars((string) $table['codigo'], ENT_QUOTES, 'UTF-8') ?>
                                        · <?= (int) $table['capacidad'] ?> personas
                                        · <?= htmlspecialchars((string) $table['estado'], ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label mb-0">Productos solicitados</label>

                            <button
                                type="button"
                                class="btn btn-outline-success btn-sm"
                                id="add-product"
                            >
                                <i class="bi bi-plus-lg"></i> Agregar producto
                            </button>
                        </div>

                        <div id="order-items"></div>

                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>

                            <textarea
                                class="form-control"
                                id="observaciones"
                                name="observaciones"
                                rows="3"
                                maxlength="500"
                                placeholder="Ejemplo: sin cebolla, término medio, alergias."
                            ></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle"></i> Registrar pedido
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Pedidos activos</h4>
                    <span class="badge text-bg-primary"><?= count($orders) ?></span>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Mesa</th>
                                <th>Cliente</th>
                                <th>Mesero</th>
                                <th>Estado</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if ($orders === []): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No hay pedidos activos.
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($orders as $order): ?>
                                <?php
                                $clientName = trim(
                                    (string) ($order['cliente_nombre'] ?? '')
                                    . ' '
                                    . (string) ($order['cliente_apellido'] ?? '')
                                );
                                ?>

                                <tr>
                                    <td>
                                        <strong>
                                            <?= htmlspecialchars((string) $order['mesa_codigo'], ENT_QUOTES, 'UTF-8') ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $clientName !== '' ? $clientName : 'Cliente directo',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) ($order['mesero_nombre'] ?? 'Sin asignar'),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?php
                                        $statusClass = match ($order['estado']) {
                                            'Pendiente' => 'text-bg-warning',
                                            'Preparando' => 'text-bg-info',
                                            'Entregado' => 'text-bg-success',
                                            default => 'text-bg-secondary',
                                        };
                                        ?>

                                        <span class="badge <?= $statusClass ?>">
                                            <?= htmlspecialchars((string) $order['estado'], ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <strong>
                                            S/ <?= number_format((float) $order['total'], 2) ?>
                                        </strong>

                                        <?php if ((float) $order['adelanto_aplicado'] > 0): ?>
                                            <small class="d-block text-success">
                                                Adelanto aplicado:
                                                -S/ <?= number_format((float) $order['adelanto_aplicado'], 2) ?>
                                            </small>
                                        <?php endif; ?>
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

<template id="product-row-template">
    <div class="border rounded p-3 mb-2 product-row">
        <div class="row g-2 align-items-end">
            <div class="col-md-7">
                <label class="form-label small">Producto</label>

                <select class="form-select product-select" required>
                    <option value="">Selecciona un producto</option>

                    <?php foreach ($products as $product): ?>
                        <option value="<?= (int) $product['id'] ?>">
                            <?= htmlspecialchars((string) $product['nombre'], ENT_QUOTES, 'UTF-8') ?>
                            · S/ <?= number_format((float) $product['precio'], 2) ?>
                            · Stock: <?= (int) $product['stock'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small">Cantidad</label>

                <input
                    class="form-control quantity-input"
                    type="number"
                    min="1"
                    value="1"
                    required
                >
            </div>

            <div class="col-md-2 d-grid">
                <button
                    type="button"
                    class="btn btn-outline-danger remove-product"
                    aria-label="Eliminar producto"
                >
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('order-items');
    const template = document.getElementById('product-row-template');
    const addButton = document.getElementById('add-product');
    let rowIndex = 0;

    function addProductRow() {
        const row = template.content.cloneNode(true);
        const select = row.querySelector('.product-select');
        const quantity = row.querySelector('.quantity-input');
        const removeButton = row.querySelector('.remove-product');

        select.name = `items[${rowIndex}][producto_id]`;
        quantity.name = `items[${rowIndex}][cantidad]`;

        removeButton.addEventListener('click', function () {
            const rows = container.querySelectorAll('.product-row');

            if (rows.length > 1) {
                this.closest('.product-row').remove();
            }
        });

        container.appendChild(row);
        rowIndex++;
    }

    if (container && template && addButton) {
        addProductRow();

        addButton.addEventListener('click', addProductRow);
    }
});
</script>