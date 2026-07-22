<?php

declare(strict_types=1);

$success = Session::getFlash('success');
$error = Session::getFlash('error');

$waitingList = $waitingList ?? [];
$history = $history ?? [];
$availableTables = $availableTables ?? [];
$csrfToken = $csrfToken ?? '';
?>

<section class="page-header">
    <div>
        <p class="eyebrow">RECEPCIÓN</p>
        <h1>Lista de espera</h1>
        <p>Gestiona solicitudes por orden de llegada y asigna mesas disponibles.</p>
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

<div class="row g-4">
    <div class="col-lg-4">
        <section class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <p class="eyebrow">NUEVA SOLICITUD</p>
                <h2 class="h4 mb-4">Agregar cliente</h2>

                <form method="POST" action="<?= APP_URL ?>/lista-espera/guardar">
                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= e((string) $csrfToken) ?>"
                    >

                    <div class="mb-3">
                        <label class="form-label" for="nombres">Nombres</label>
                        <input
                            class="form-control"
                            id="nombres"
                            name="nombres"
                            type="text"
                            maxlength="100"
                            autocomplete="name"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="telefono">Celular</label>
                        <input
                            class="form-control"
                            id="telefono"
                            name="telefono"
                            type="tel"
                            maxlength="20"
                            inputmode="tel"
                            autocomplete="tel"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="personas">Cantidad de personas</label>
                        <input
                            class="form-control"
                            id="personas"
                            name="personas"
                            type="number"
                            min="1"
                            max="20"
                            required
                        >
                    </div>

                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-person-plus me-1"></i>
                        Agregar a espera
                    </button>
                </form>
            </div>
        </section>
    </div>

    <div class="col-lg-8">
        <section class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="eyebrow mb-1">FIFO</p>
                        <h2 class="h4 mb-0">Solicitudes pendientes</h2>
                    </div>

                    <span class="badge text-bg-primary">
                        <?= count($waitingList) ?>
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Celular</th>
                                <th>Personas</th>
                                <th>Registro</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if ($waitingList === []): ?>
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-muted">
                                        No existen clientes en espera.
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($waitingList as $waiting): ?>
                                <tr>
                                    <td>
                                        <strong>
                                            <?= e((string) ($waiting['nombres'] ?? 'Cliente')) ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?= e((string) ($waiting['telefono'] ?? '-')) ?>
                                    </td>

                                    <td>
                                        <?= (int) ($waiting['personas'] ?? 0) ?>
                                    </td>

                                    <td>
                                        <?= e((string) ($waiting['fecha_registro'] ?? '-')) ?>
                                    </td>

                                    <td class="text-end">
                                        <button
                                            class="btn btn-sm btn-success mb-1"
                                            type="button"
                                            data-bs-toggle="modal"
                                            data-bs-target="#assignModal<?= (int) $waiting['id'] ?>"
                                        >
                                            <i class="bi bi-grid-3x3-gap"></i>
                                            Asignar mesa
                                        </button>

                                        <form
                                            class="d-inline"
                                            method="POST"
                                            action="<?= APP_URL ?>/lista-espera/cancelar"
                                        >
                                            <input
                                                type="hidden"
                                                name="csrf_token"
                                                value="<?= e((string) $csrfToken) ?>"
                                            >

                                            <input
                                                type="hidden"
                                                name="lista_espera_id"
                                                value="<?= (int) $waiting['id'] ?>"
                                            >

                                            <button
                                                class="btn btn-sm btn-outline-danger mb-1"
                                                type="submit"
                                            >
                                                Cancelar
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
    </div>
</div>

<section class="card shadow-sm border-0 mt-4">
    <div class="card-body p-4">
        <p class="eyebrow mb-1">HISTORIAL</p>
        <h2 class="h4 mb-3">Últimas solicitudes</h2>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Personas</th>
                        <th>Estado</th>
                        <th>Mesa</th>
                        <th>Registro</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($history === []): ?>
                        <tr>
                            <td colspan="5" class="py-4 text-center text-muted">
                                Aún no hay historial.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($history as $item): ?>
                        <tr>
                            <td><?= e((string) ($item['nombres'] ?? 'Cliente')) ?></td>
                            <td><?= (int) ($item['personas'] ?? 0) ?></td>

                            <td>
                                <span class="badge text-bg-secondary">
                                    <?= e((string) ($item['estado'] ?? '-')) ?>
                                </span>
                            </td>

                            <td>
                                <?= e((string) ($item['mesa_codigo'] ?? '-')) ?>
                            </td>

                            <td>
                                <?= e((string) ($item['fecha_registro'] ?? '-')) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php foreach ($waitingList as $waiting): ?>
    <?php
    $requiredCapacity = (int) ($waiting['personas'] ?? 0);
    $hasCompatibleTable = false;

    foreach ($availableTables as $table) {
        if ((int) ($table['capacidad'] ?? 0) >= $requiredCapacity) {
            $hasCompatibleTable = true;
            break;
        }
    }
    ?>

    <div
        class="modal fade"
        id="assignModal<?= (int) $waiting['id'] ?>"
        tabindex="-1"
        aria-labelledby="assignModalLabel<?= (int) $waiting['id'] ?>"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="<?= APP_URL ?>/lista-espera/asignar">
                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= e((string) $csrfToken) ?>"
                    >

                    <input
                        type="hidden"
                        name="lista_espera_id"
                        value="<?= (int) $waiting['id'] ?>"
                    >

                    <div class="modal-header">
                        <div>
                            <p class="eyebrow mb-1">ASIGNACIÓN DE MESA</p>
                            <h3
                                class="modal-title h5 mb-0"
                                id="assignModalLabel<?= (int) $waiting['id'] ?>"
                            >
                                Asignar mesa a <?= e((string) ($waiting['nombres'] ?? 'cliente')) ?>
                            </h3>
                        </div>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Cerrar"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-light border small">
                            Este cliente necesita una mesa para
                            <strong><?= $requiredCapacity ?> personas</strong>.
                        </div>

                        <label
                            class="form-label"
                            for="mesa<?= (int) $waiting['id'] ?>"
                        >
                            Mesa disponible
                        </label>

                        <select
                            class="form-select"
                            id="mesa<?= (int) $waiting['id'] ?>"
                            name="mesa_id"
                            required
                            <?= !$hasCompatibleTable ? 'disabled' : '' ?>
                        >
                            <option value="">Selecciona una mesa</option>

                            <?php foreach ($availableTables as $table): ?>
                                <?php if ((int) ($table['capacidad'] ?? 0) >= $requiredCapacity): ?>
                                    <option value="<?= (int) $table['id'] ?>">
                                        <?= e((string) $table['codigo']) ?>
                                        · <?= (int) $table['capacidad'] ?> personas
                                        <?php if (!empty($table['ubicacion'])): ?>
                                            · <?= e((string) $table['ubicacion']) ?>
                                        <?php endif; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>

                        <?php if (!$hasCompatibleTable): ?>
                            <div class="alert alert-warning mt-3 mb-0">
                                No existen mesas libres con capacidad para
                                <?= $requiredCapacity ?> personas.
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Cancelar
                        </button>

                        <button
                            class="btn btn-success"
                            type="submit"
                            <?= !$hasCompatibleTable ? 'disabled' : '' ?>
                        >
                            <i class="bi bi-check-circle me-1"></i>
                            Confirmar asignación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>