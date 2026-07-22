<section class="mb-4">
    <p class="page-eyebrow">Administración</p>
    <h1 class="page-title">Gestión de mesas</h1>
    <p class="page-subtitle">Capacidad, ubicación y estado operativo del restaurante.</p>
</section>

<?php if ($error = Session::flash('error')): ?>
    <div class="alert alert-danger"><?= e($error) ?></div>
<?php endif; ?>

<?php if ($success = Session::flash('success')): ?>
    <div class="alert alert-success"><?= e($success) ?></div>
<?php endif; ?>

<div class="row g-4">
    <?php if ($canManage): ?>
        <div class="col-lg-4">
            <article class="panel">
                <h2 class="panel-title mb-3">
                    <?= $mesaEdit ? 'Editar mesa' : 'Nueva mesa' ?>
                </h2>

                <form method="POST" action="<?= APP_URL ?>/mesas/guardar">
                    <input type="hidden" name="csrf_token" value="<?= e(Security::csrfToken()) ?>">
                    <input type="hidden" name="id" value="<?= e((string) ($mesaEdit['id'] ?? 0)) ?>">

                    <div class="mb-3">
                        <label class="form-label">Código</label>
                        <input
                            class="form-control"
                            name="codigo"
                            maxlength="20"
                            placeholder="M01"
                            value="<?= e($mesaEdit['codigo'] ?? '') ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Capacidad</label>
                        <input
                            class="form-control"
                            type="number"
                            name="capacidad"
                            min="1"
                            max="20"
                            value="<?= e((string) ($mesaEdit['capacidad'] ?? 2)) ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ubicación</label>
                        <input
                            class="form-control"
                            name="ubicacion"
                            maxlength="100"
                            placeholder="Salón principal"
                            value="<?= e($mesaEdit['ubicacion'] ?? '') ?>"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="estado" required>
                            <?php foreach (['Libre', 'Reservada', 'Ocupada', 'Limpieza'] as $state): ?>
                                <option
                                    value="<?= e($state) ?>"
                                    <?= ($mesaEdit['estado'] ?? 'Libre') === $state ? 'selected' : '' ?>
                                >
                                    <?= e($state) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button class="btn btn-success w-100" type="submit">
                        <i class="bi bi-save me-1"></i>
                        <?= $mesaEdit ? 'Actualizar mesa' : 'Guardar mesa' ?>
                    </button>

                    <?php if ($mesaEdit): ?>
                        <a class="btn btn-light w-100 mt-2" href="<?= APP_URL ?>/mesas">
                            Cancelar edición
                        </a>
                    <?php endif; ?>
                </form>
            </article>
        </div>
    <?php endif; ?>

    <div class="<?= $canManage ? 'col-lg-8' : 'col-12' ?>">
        <article class="panel">
            <h2 class="panel-title mb-3">Mesas registradas</h2>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Capacidad</th>
                            <th>Ubicación</th>
                            <th>Estado</th>
                            <?php if ($canManage): ?>
                                <th class="text-end">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mesas as $mesa): ?>
                            <?php
                            $color = match ($mesa['estado']) {
                                'Libre' => 'success',
                                'Reservada' => 'warning',
                                'Ocupada' => 'danger',
                                default => 'secondary',
                            };
                            ?>
                            <tr>
                                <td><strong><?= e($mesa['codigo']) ?></strong></td>
                                <td><?= e((string) $mesa['capacidad']) ?> personas</td>
                                <td><?= e($mesa['ubicacion']) ?></td>
                                <td>
                                    <span class="badge text-bg-<?= e($color) ?>">
                                        <?= e($mesa['estado']) ?>
                                    </span>
                                </td>

                                <?php if ($canManage): ?>
                                    <td class="text-end">
                                        <a
                                            class="btn btn-outline-primary btn-sm"
                                            href="<?= APP_URL ?>/mesas?editar=<?= e((string) $mesa['id']) ?>"
                                        >
                                            Editar
                                        </a>

                                        <form class="d-inline" method="POST" action="<?= APP_URL ?>/mesas/eliminar">
                                            <input type="hidden" name="csrf_token" value="<?= e(Security::csrfToken()) ?>">
                                            <input type="hidden" name="id" value="<?= e((string) $mesa['id']) ?>">

                                            <button
                                                class="btn btn-outline-danger btn-sm"
                                                type="submit"
                                                onclick="return confirm('¿Eliminar esta mesa?');"
                                            >
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>

                        <?php if ($mesas === []): ?>
                            <tr>
                                <td class="text-center text-secondary py-4" colspan="5">
                                    Aún no hay mesas registradas.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>
</div>