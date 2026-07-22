<section class="auth-page">
    <div class="auth-background-shape auth-background-shape-one"></div>
    <div class="auth-background-shape auth-background-shape-two"></div>

    <div class="container auth-container">
        <div class="auth-layout">
            <section class="auth-welcome-panel">
                <a class="auth-brand" href="<?= APP_URL ?>/reservar">
                    <span class="auth-brand-icon">
                        <i class="bi bi-shop"></i>
                    </span>

                    <span>
                        <strong>RMRS</strong>
                        <small>Restaurant Management</small>
                    </span>
                </a>

                <div class="auth-welcome-content">
                    <p class="auth-eyebrow">PLATAFORMA INTERNA</p>

                    <h1>Todo el restaurante,<br>en un solo lugar.</h1>

                    <p>
                        Gestiona reservas, pedidos, mesas, caja y reportes
                        desde un entorno seguro.
                    </p>

                    <div class="auth-features">
                        <span>
                            <i class="bi bi-shield-check"></i>
                            Acceso seguro
                        </span>

                        <span>
                            <i class="bi bi-graph-up-arrow"></i>
                            Operación en tiempo real
                        </span>
                    </div>
                </div>

                <a class="auth-public-link" href="<?= APP_URL ?>/reservar">
                    <i class="bi bi-arrow-left"></i>
                    Volver a Reserva Fácil
                </a>
            </section>

            <section class="auth-login-panel">
                <div class="auth-login-card">
                    <div class="auth-mobile-brand">
                        <span class="auth-brand-icon">
                            <i class="bi bi-shop"></i>
                        </span>
                        <strong>RMRS</strong>
                    </div>

                    <div class="auth-heading">
                        <span class="auth-heading-icon">
                            <i class="bi bi-person-lock"></i>
                        </span>

                        <div>
                            <p class="auth-eyebrow">ACCESO DE EMPLEADOS</p>
                            <h2>Bienvenido nuevamente</h2>
                            <p>Ingresa tus credenciales para continuar.</p>
                        </div>
                    </div>

                    <?php if ($error = Session::flash('error')): ?>
                        <div class="auth-alert auth-alert-danger">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <span><?= e((string) $error) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($success = Session::flash('success')): ?>
                        <div class="auth-alert auth-alert-success">
                            <i class="bi bi-check-circle-fill"></i>
                            <span><?= e((string) $success) ?></span>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= APP_URL ?>/login">
                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= e(Security::csrfToken()) ?>"
                        >

                        <div class="auth-field">
                            <label for="correo">Correo electrónico</label>

                            <div class="auth-input-wrapper">
                                <i class="bi bi-envelope"></i>

                                <input
                                    id="correo"
                                    name="correo"
                                    type="email"
                                    autocomplete="email"
                                    placeholder="correo@restaurante.com"
                                    required
                                    autofocus
                                >
                            </div>
                        </div>

                        <div class="auth-field">
                            <label for="password">Contraseña</label>

                            <div class="auth-input-wrapper">
                                <i class="bi bi-lock"></i>

                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="current-password"
                                    placeholder="Ingresa tu contraseña"
                                    required
                                >
                            </div>
                        </div>

                        <button class="auth-submit-button" type="submit">
                            Ingresar al sistema
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </form>

                    <p class="auth-help-text">
                        ¿Problemas de acceso? Comunícate con el administrador.
                    </p>
                </div>
            </section>
        </div>
    </div>
</section>