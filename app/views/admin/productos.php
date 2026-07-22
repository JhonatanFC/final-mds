<section class="mb-4">
    <p class="page-eyebrow">Administración</p>
    <h1 class="page-title">Productos y categorías</h1>
    <p class="page-subtitle">Gestiona el menú disponible para los pedidos.</p>
</section>

<?php if ($error = Session::flash('error')): ?>
    <div class="alert alert-danger"><?= e($error) ?></div>
<?php endif; ?>

<?php if ($success = Session::flash('success')): ?>
    <div class="alert alert-success"><?= e($success) ?></div>
<?php endif; ?>

<?php if ($canManage): ?>
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <article class="panel">
                <h2 class="panel-title mb-3">
                    <?= $categoriaEdit ? 'Editar categoría' : 'Nueva categoría' ?>
                </h2>

                <form method="POST" action="<?= APP_URL ?>/categorias/guardar">
                    <input type="hidden" name="csrf_token" value="<?= e(Security::csrfToken()) ?>">
                    <input type="hidden" name="id" value="<?= e((string) ($categoriaEdit['id'] ?? 0)) ?>">

                    <input class="form-control mb-3" name="nombre" placeholder="Nombre" value="<?= e($categoriaEdit['nombre'] ?? '') ?>" required>

                    <textarea class="form-control mb-3" name="descripcion" placeholder="Descripción"><?= e($categoriaEdit['descripcion'] ?? '') ?></textarea>

                    <label class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="activo" <?= ($categoriaEdit['activo'] ?? 1) ? 'checked' : '' ?>>
                        <span class="form-check-label">Categoría activa</span>
                    </label>

                    <button class="btn btn-success w-100">Guardar categoría</button>
                </form>
            </article>
        </div>

        <div class="col-lg-8">
            <article class="panel">
                <h2 class="panel-title mb-3">
                    <?= $productoEdit ? 'Editar producto' : 'Nuevo producto' ?>
                </h2>

                <form method="POST" action="<?= APP_URL ?>/productos/guardar" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= e(Security::csrfToken()) ?>">
                    <input type="hidden" name="id" value="<?= e((string) ($productoEdit['id'] ?? 0)) ?>">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <select class="form-select" name="categoria_id" required>
                                <option value="">Selecciona categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= e((string) $categoria['id']) ?>" <?= (int) ($productoEdit['categoria_id'] ?? 0) === (int) $categoria['id'] ? 'selected' : '' ?>>
                                        <?= e($categoria['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <input class="form-control" name="nombre" placeholder="Nombre del producto" value="<?= e($productoEdit['nombre'] ?? '') ?>" required>
                        </div>

                        <div class="col-md-4">
                            <input class="form-control" type="number" step="0.01" min="0" name="precio" placeholder="Precio" value="<?= e((string) ($productoEdit['precio'] ?? '')) ?>" required>
                        </div>

                        <div class="col-md-4">
                            <input class="form-control" type="number" min="0" name="stock" placeholder="Stock" value="<?= e((string) ($productoEdit['stock'] ?? 0)) ?>" required>
                        </div>

                        <div class="col-md-4">
                            <input class="form-control" type="file" name="imagen" accept=".jpg,.jpeg,.png,.webp">
                        </div>

                        <div class="col-12">
                            <textarea class="form-control" name="descripcion" placeholder="Descripción"><?= e($productoEdit['descripcion'] ?? '') ?></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="activo" <?= ($productoEdit['activo'] ?? 1) ? 'checked' : '' ?>>
                                <span class="form-check-label">Producto disponible</span>
                            </label>
                        </div>
                    </div>

                    <button class="btn btn-success mt-3" type="submit">Guardar producto</button>
                </form>
            </article>
        </div>
    </div>
<?php endif; ?>

<article class="panel">
    <h2 class="panel-title mb-3">Menú registrado</h2>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <?php if ($canManage): ?><th></th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td>
                            <strong><?= e($producto['nombre']) ?></strong>
                            <small class="d-block text-secondary"><?= e($producto['descripcion']) ?></small>
                        </td>
                        <td><?= e($producto['categoria_nombre']) ?></td>
                        <td>S/ <?= e(number_format((float) $producto['precio'], 2)) ?></td>
                        <td><?= e((string) $producto['stock']) ?></td>
                        <td>
                            <span class="badge text-bg-<?= $producto['activo'] ? 'success' : 'secondary' ?>">
                                <?= $producto['activo'] ? 'Disponible' : 'No disponible' ?>
                            </span>
                        </td>
                        <?php if ($canManage): ?>
                            <td class="text-end">
                                <a class="btn btn-outline-primary btn-sm" href="<?= APP_URL ?>/productos?editar_producto=<?= e((string) $producto['id']) ?>">Editar</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>

                <?php if ($productos === []): ?>
                    <tr>
                        <td colspan="6" class="text-center text-secondary py-4">
                            No existen productos registrados.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</article>