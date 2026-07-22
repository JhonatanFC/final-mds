<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= e((string) ($title ?? APP_NAME)) ?></title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <link href="<?= APP_URL ?>/assets/css/app.css" rel="stylesheet">
</head>

<body>
    <?php
    $user = $user ?? [];
    $role = (string) ($user['rol'] ?? '');
    ?>

    <aside class="app-sidebar">
        <a class="brand" href="<?= APP_URL ?>/dashboard">
            <span class="brand-icon">
                <i class="bi bi-shop"></i>
            </span>

            <span>RMRS</span>
        </a>

        <p class="sidebar-label">Principal</p>

        <a class="sidebar-link" href="<?= APP_URL ?>/dashboard">
            <i class="bi bi-grid-1x2"></i>
            Dashboard
        </a>

        <p class="sidebar-label">Módulos habilitados</p>

        <?php if (AuthMiddleware::can('reservas.view')): ?>
            <a class="sidebar-link" href="<?= APP_URL ?>/recepcion">
                <i class="bi bi-calendar-check"></i>
                Recepción y reservas
            </a>

            <a class="sidebar-link" href="<?= APP_URL ?>/lista-espera">
                <i class="bi bi-hourglass-split"></i>
                Lista de espera
            </a>
        <?php endif; ?>

        <?php if (AuthMiddleware::can('reservas.confirm')): ?>
            <a class="sidebar-link" href="<?= APP_URL ?>/recepcion/solicitudes">
                <i class="bi bi-clipboard2-check"></i>
                Solicitudes de pago
            </a>
        <?php endif; ?>

        <?php if (AuthMiddleware::can('mesas.view')): ?>
            <a class="sidebar-link" href="<?= APP_URL ?>/mesas">
                <i class="bi bi-table"></i>
                Mesas
            </a>
        <?php endif; ?>

        <?php if (AuthMiddleware::can('pedidos.view')): ?>
            <a class="sidebar-link" href="<?= APP_URL ?>/pedidos">
                <i class="bi bi-receipt"></i>
                Pedidos
            </a>
        <?php endif; ?>

        <?php if (AuthMiddleware::can('productos.view')): ?>
            <a class="sidebar-link" href="<?= APP_URL ?>/productos">
                <i class="bi bi-menu-button-wide"></i>
                Productos
            </a>
        <?php endif; ?>

        <?php if (AuthMiddleware::can('caja.view')): ?>
    <a class="sidebar-link" href="<?= APP_URL ?>/caja">
        <i class="bi bi-cash-stack"></i>
        Caja y cobros
    </a>
<?php endif; ?>

        <?php if ($role === 'Administrador'): ?>
            <a class="sidebar-link" href="<?= APP_URL ?>/usuarios">
                <i class="bi bi-people"></i>
                Usuarios
            </a>
        <?php endif; ?>

        <?php if (AuthMiddleware::can('reportes')): ?>
            <a class="sidebar-link" href="<?= APP_URL ?>/gerencia">
                <i class="bi bi-bar-chart-line"></i>
                Gerencia
            </a>

            <a class="sidebar-link" href="<?= APP_URL ?>/reportes">
                <i class="bi bi-file-earmark-bar-graph"></i>
                Reportes
            </a>
        <?php endif; ?>

        <div class="sidebar-role">
            <small>Sesión activa</small>

            <strong>
                <?= e((string) ($user['nombres'] ?? 'Usuario RMRS')) ?>
            </strong>

            <small>
                <?= e($role !== '' ? $role : 'Sin rol') ?>
            </small>
        </div>
    </aside>

    <div class="app-content">
        <header class="topbar">
            <button
                class="sidebar-toggle"
                type="button"
                data-sidebar-toggle
                aria-label="Mostrar navegación"
            >
                <i class="bi bi-list"></i>
            </button>

            <span class="status-badge">
                <i class="bi bi-circle-fill me-1"></i>
                Sistema operativo
            </span>

            <form method="POST" action="<?= APP_URL ?>/logout">
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= e(Security::csrfToken()) ?>"
                >

                <button class="btn btn-outline-danger btn-sm" type="submit">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    Salir
                </button>
            </form>
        </header>

        <main class="page-content">
            <?= $content ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/app.js"></script>
</body>
</html>