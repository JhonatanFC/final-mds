<?php

declare(strict_types=1);

$employees = $employees ?? [];
$roles = $roles ?? [];
$csrfToken = $csrfToken ?? '';

$success = Session::getFlash('success');
$error = Session::getFlash('error');
?>

<section class="page-header">
    <div>
        <p class="eyebrow">ADMINISTRACIÓN</p>
        <h1>Usuarios internos</h1>
        <p>Crea cuentas y controla el acceso de los empleados al sistema.</p>
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
        <section class="card shadow-sm border-0">
            <div class="card-body p-4">
                <p class="eyebrow">NUEVA CUENTA</p>
                <h4 class="mb-4">Registrar empleado</h4>

                <form method="POST" action="<?= APP_URL ?>/usuarios/guardar">
                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= e((string) $csrfToken) ?>"
                    >

                    <div class="mb-3">
                        <label class="form-label" for="rol_id">Cargo</label>
                        <select class="form-select" id="rol_id" name="rol_id" required>
                            <option value="">Selecciona un cargo</option>

                            <?php foreach ($roles as $role): ?>
                                <option value="<?= (int) $role['id'] ?>">
                                    <?= e((string) $role['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="nombres">Nombres completos</label>
                        <input
                            class="form-control"
                            id="nombres"
                            name="nombres"
                            type="text"
                            maxlength="150"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="correo">Correo institucional</label>
                        <input
                            class="form-control"
                            id="correo"
                            name="correo"
                            type="email"
                            maxlength="150"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="password">Contraseña temporal</label>
                        <input
                            class="form-control"
                            id="password"
                            name="password"
                            type="password"
                            minlength="6"
                            required
                        >
                    </div>

                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-person-plus"></i>
                        Crear cuenta
                    </button>
                </form>
            </div>
        </section>
    </div>

    <div class="col-lg-8">
        <section class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <p class="eyebrow mb-1">PERSONAL REGISTRADO</p>
                        <h4 class="mb-0">Cuentas del sistema</h4>
                    </div>

                    <span class="badge text-bg-primary"><?= count($employees) ?></span>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Empleado</th>
                                <th>Cargo</th>
                                <th>Correo</th>
                                <th>Estado</th>
                                <th class="text-end">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($employees === []): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No existen empleados registrados.
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($employees as $employee): ?>
                                <?php $active = (int) $employee['estado'] === 1; ?>

                                <tr>
                                    <td>
                                        <strong><?= e((string) $employee['nombres']) ?></strong>
                                        <small class="d-block text-muted">
                                            Registro #<?= (int) $employee['id'] ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge text-bg-secondary">
                                            <?= e((string) $employee['rol']) ?>
                                        </span>
                                    </td>
                                    <td><?= e((string) $employee['correo']) ?></td>
                                    <td>
                                        <?php if ($active): ?>
                                            <span class="badge text-bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge text-bg-danger">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <form method="POST" action="<?= APP_URL ?>/usuarios/estado">
                                            <input
                                                type="hidden"
                                                name="csrf_token"
                                                value="<?= e((string) $csrfToken) ?>"
                                            >

                                            <input
                                                type="hidden"
                                                name="usuario_id"
                                                value="<?= (int) $employee['id'] ?>"
                                            >

                                            <button
                                                class="btn btn-sm <?= $active ? 'btn-outline-danger' : 'btn-outline-success' ?>"
                                                type="submit"
                                            >
                                                <?= $active ? 'Desactivar' : 'Activar' ?>
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