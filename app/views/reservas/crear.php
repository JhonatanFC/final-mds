<?php

declare(strict_types=1);

$products = $products ?? [];
$csrfToken = $csrfToken ?? '';

$success = Session::getFlash('success');
$error = Session::getFlash('error');

$heroImage = 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1800&q=85';
?>

<header class="reservation-navbar">
    <a class="reservation-brand" href="<?= APP_URL ?>/reservar">
        <span class="reservation-brand-icon">
            <i class="bi bi-calendar-heart"></i>
        </span>

        <span>
            <strong>Reserva</strong>
            <small>Fácil</small>
        </span>
    </a>

    <nav class="reservation-nav-links">
        <a href="#inicio">Inicio</a>
        <a href="#menu">Menú</a>
        <a href="#reservar">Reservar</a>
    </nav>

    <div class="reservation-socials">
        <a href="#" aria-label="Facebook">
            <i class="bi bi-facebook"></i>
        </a>

        <a href="#" aria-label="Instagram">
            <i class="bi bi-instagram"></i>
        </a>

        <a href="<?= APP_URL ?>/login" aria-label="Acceso para empleados">
            <i class="bi bi-person-lock"></i>
        </a>
    </div>
</header>

<main>
    <?php if ($success !== null): ?>
        <div class="container pt-4" aria-live="polite">
            <div class="alert alert-success shadow-sm">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= e((string) $success) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($error !== null): ?>
        <div class="container pt-4" aria-live="assertive">
            <div class="alert alert-danger shadow-sm">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= e((string) $error) ?>
            </div>
        </div>
    <?php endif; ?>

    <section
        class="reservation-hero"
        id="inicio"
        style="--hero-image: url('<?= e($heroImage) ?>');"
    >
        <div class="reservation-hero-overlay"></div>

        <div class="reservation-hero-content">
            <p class="public-eyebrow">
                <i class="bi bi-stars"></i>
                EXPERIENCIA GASTRONÓMICA
            </p>

            <h1>Tu mesa lista,<br>en segundos.</h1>

            <p>
                Reserva tu mesa con un adelanto de S/ 30.00.
                Este monto será descontado directamente de tu consumo final.
            </p>

            <div class="hero-benefits">
                <span>
                    <i class="bi bi-check2-circle"></i>
                    Confirmación segura
                </span>

                <span>
                    <i class="bi bi-check2-circle"></i>
                    Adelanto descontable
                </span>

                <span>
                    <i class="bi bi-check2-circle"></i>
                    Tolerancia de 20 min.
                </span>
            </div>
        </div>

        <div class="reservation-form-card" id="reservar">
            <div class="reservation-form-heading">
                <p class="public-eyebrow">PASO 1 DE 2</p>
                <h2>Datos de reserva</h2>
                <span>Completa tus datos para continuar al pago.</span>
            </div>

            <form
                id="reservation-form"
                method="POST"
                action="<?= APP_URL ?>/reservar"
                enctype="multipart/form-data"
            >
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= e((string) $csrfToken) ?>"
                >

                <div class="reservation-form-grid">
                    <div class="form-field">
                        <label for="nombres">Nombres</label>
                        <input
                            id="nombres"
                            name="nombres"
                            type="text"
                            maxlength="100"
                            required
                            autocomplete="given-name"
                            placeholder="Ejemplo: Jhonatan"
                        >
                    </div>

                    <div class="form-field">
                        <label for="apellidos">Apellidos</label>
                        <input
                            id="apellidos"
                            name="apellidos"
                            type="text"
                            maxlength="100"
                            required
                            autocomplete="family-name"
                            placeholder="Ejemplo: Fernández"
                        >
                    </div>

                    <div class="form-field">
                        <label for="dni">DNI</label>
                        <input
                            id="dni"
                            name="dni"
                            type="text"
                            inputmode="numeric"
                            pattern="[0-9]{8}"
                            maxlength="8"
                            required
                            placeholder="12345678"
                        >
                    </div>

                    <div class="form-field">
                        <label for="telefono">Celular</label>
                        <input
                            id="telefono"
                            name="telefono"
                            type="tel"
                            inputmode="tel"
                            maxlength="20"
                            required
                            autocomplete="tel"
                            placeholder="987 654 321"
                        >
                    </div>

                    <div class="form-field">
                        <label for="fecha">Fecha de reserva</label>
                        <input
                            id="fecha"
                            name="fecha"
                            type="date"
                            min="<?= date('Y-m-d') ?>"
                            required
                        >
                    </div>

                    <div class="form-field">
                        <label for="hora">Hora</label>
                        <select id="hora" name="hora" required>
                            <option value="">Selecciona una hora</option>
                            <option value="12:00">12:00 p. m.</option>
                            <option value="13:00">1:00 p. m.</option>
                            <option value="14:00">2:00 p. m.</option>
                            <option value="18:00">6:00 p. m.</option>
                            <option value="19:00">7:00 p. m.</option>
                            <option value="20:00">8:00 p. m.</option>
                            <option value="21:00">9:00 p. m.</option>
                            <option value="22:00">10:00 p. m.</option>
                        </select>
                    </div>

                    <div class="form-field form-field-full">
                        <label for="personas">Cantidad de personas</label>
                        <select id="personas" name="personas" required>
                            <option value="">Selecciona cantidad</option>
                            <option value="1">1 persona</option>
                            <option value="2">2 personas</option>
                            <option value="3">3 personas</option>
                            <option value="4">4 personas</option>
                            <option value="5">5 personas</option>
                            <option value="6">6 personas</option>
                            <option value="7">7 personas</option>
                            <option value="8">8 personas</option>
                        </select>
                    </div>
                </div>

                <div class="reservation-policy">
                    <i class="bi bi-info-circle"></i>

                    <span>
                        La reserva requiere un adelanto de
                        <strong>S/ 30.00</strong>.
                        Este monto se descuenta de tu consumo final.
                    </span>
                </div>

                <button
                    class="reservation-submit"
                    id="checkout-trigger"
                    type="button"
                    disabled
                    data-bs-toggle="modal"
                    data-bs-target="#paymentModal"
                >
                    Completa tus datos para pagar
                    <i class="bi bi-lock"></i>
                </button>
            </form>
        </div>
    </section>

    <section class="public-menu-section" id="menu">
        <div class="public-section-heading">
            <div>
                <p class="public-eyebrow">NUESTRA CARTA</p>
                <h2>Menú del día</h2>
                <p>Conoce los platos disponibles antes de reservar.</p>
            </div>

            <a href="#reservar" class="public-outline-button">
                Reservar mesa
                <i class="bi bi-arrow-up-right"></i>
            </a>
        </div>

        <?php if ($products === []): ?>
            <div class="public-empty-menu">
                <i class="bi bi-journal-x"></i>
                <h3>Menú en actualización</h3>
                <p>Muy pronto podrás conocer nuestros platos disponibles.</p>
            </div>
        <?php else: ?>
            <div class="public-menu-grid">
                <?php foreach ($products as $product): ?>
                    <?php
                    $hasImage = !empty($product['imagen']);

                    $imageUrl = $hasImage
                        ? APP_URL . '/uploads/productos/' . rawurlencode(
                            (string) $product['imagen']
                        )
                        : '';
                    ?>

                    <article class="public-menu-card">
                        <div class="public-menu-image">
                            <?php if ($hasImage): ?>
                                <img
                                    src="<?= e($imageUrl) ?>"
                                    alt="<?= e((string) $product['nombre']) ?>"
                                >
                            <?php else: ?>
                                <div class="menu-image-placeholder">
                                    <i class="bi bi-cup-hot"></i>
                                </div>
                            <?php endif; ?>

                            <span>
                                <?= e((string) ($product['categoria'] ?? 'Carta')) ?>
                            </span>
                        </div>

                        <div class="public-menu-content">
                            <div class="menu-card-title">
                                <h3><?= e((string) $product['nombre']) ?></h3>

                                <strong>
                                    S/ <?= number_format(
                                        (float) $product['precio'],
                                        2
                                    ) ?>
                                </strong>
                            </div>

                            <p>
                                <?= e(
                                    (string) (
                                        $product['descripcion']
                                        ?? 'Preparado con ingredientes seleccionados.'
                                    )
                                ) ?>
                            </p>

                            <a href="#reservar">
                                Reservar para probar
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="public-rules-section">
        <div class="public-rule">
            <i class="bi bi-wallet2"></i>

            <div>
                <h3>S/ 30.00 de adelanto</h3>
                <p>Se descuenta directamente de tu consumo final.</p>
            </div>
        </div>

        <div class="public-rule">
            <i class="bi bi-clock-history"></i>

            <div>
                <h3>20 minutos de tolerancia</h3>
                <p>Después de ese tiempo, la mesa se libera automáticamente.</p>
            </div>
        </div>

        <div class="public-rule">
            <i class="bi bi-calendar2-check"></i>

            <div>
                <h3>Mesa bloqueada por 2 horas</h3>
                <p>Garantizamos disponibilidad durante tu experiencia.</p>
            </div>
        </div>
    </section>
</main>

<div
    class="modal fade payment-modal"
    id="paymentModal"
    tabindex="-1"
    aria-labelledby="paymentModalTitle"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <p class="public-eyebrow">PASO 2 DE 2</p>
                    <h2 class="modal-title" id="paymentModalTitle">
                        Pago de adelanto
                    </h2>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Cerrar"
                ></button>
            </div>

            <div class="modal-body">
                <div class="payment-reservation-summary">
                    <span>Adelanto por reserva</span>
                    <strong>S/ 30.00</strong>
                </div>

                <div class="payment-checkout-grid">
                    <section class="payment-qr-panel">
                        <div class="payment-qr-header">
                            <span class="payment-qr-icon">
                                <i class="bi bi-qr-code-scan"></i>
                            </span>

                            <div>
                                <strong id="payment-method-label">
                                    Paga con Yape
                                </strong>

                                <small>
                                    Escanea el código QR oficial del restaurante.
                                </small>
                            </div>
                        </div>

                        <img
                            class="payment-qr-image"
                            id="payment-qr-image"
                            src="<?= APP_URL ?>/assets/qr/yape-qr.png"
                            data-yape-qr="<?= APP_URL ?>/assets/qr/yape-qr.png"
                            data-plin-qr="<?= APP_URL ?>/assets/qr/plin-qr.png"
                            alt="Código QR de pago Yape"
                        >

                        <p>
                            Después de pagar, ingresa tu número de operación
                            y adjunta el voucher del pago.
                        </p>
                    </section>

                    <section class="payment-fields">
                        <div class="form-field">
                            <label for="metodo">Método de pago</label>

                            <select
                                id="metodo"
                                name="metodo"
                                form="reservation-form"
                                required
                            >
                                <option value="Yape">Yape</option>
                                <option value="Plin">Plin</option>
                            </select>
                        </div>

                        <div class="form-field">
                            <label for="numero_operacion">
                                Número de operación
                            </label>

                            <input
                                id="numero_operacion"
                                name="numero_operacion"
                                form="reservation-form"
                                type="text"
                                maxlength="100"
                                required
                                placeholder="Ejemplo: 123456789"
                            >
                        </div>

                        <div class="form-field">
                            <label for="voucher">
                                Voucher de pago
                                <span>JPG, PNG o PDF · Máx. 5 MB</span>
                            </label>

                            <input
                                id="voucher"
                                name="voucher"
                                form="reservation-form"
                                type="file"
                                accept=".jpg,.jpeg,.png,.pdf"
                                required
                            >
                        </div>

                        <div class="payment-security-note">
                            <i class="bi bi-shield-check"></i>

                            <span>
                                Recepción validará manualmente el pago antes
                                de confirmar la reserva.
                            </span>
                        </div>
                    </section>
                </div>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Volver y editar
                </button>

                <button
                    class="payment-confirm-button"
                    type="submit"
                    form="reservation-form"
                >
                    Registrar solicitud de reserva
                    <i class="bi bi-check-circle"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<footer class="public-footer">
    <div>
        <strong>Reserva Fácil</strong>
        <span>· RMRS</span>
    </div>

    <p>Tu mesa lista, en segundos.</p>

    <a href="<?= APP_URL ?>/login">Acceso de empleados</a>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('reservation-form');
    const checkoutButton = document.getElementById('checkout-trigger');
    const paymentMethod = document.getElementById('metodo');
    const paymentMethodLabel = document.getElementById('payment-method-label');
    const qrImage = document.getElementById('payment-qr-image');

    if (!form || !checkoutButton) {
        return;
    }

    function updateCheckoutButton() {
        const basicFields = [
            'nombres',
            'apellidos',
            'dni',
            'telefono',
            'fecha',
            'hora',
            'personas'
        ];

        const isValid = basicFields.every(function (fieldName) {
            const field = form.querySelector(
                '[name="' + fieldName + '"]'
            );

            return field !== null && field.checkValidity();
        });

        checkoutButton.disabled = !isValid;

        checkoutButton.innerHTML = isValid
            ? 'Continuar al pago <i class="bi bi-arrow-right"></i>'
            : 'Completa tus datos para pagar <i class="bi bi-lock"></i>';
    }

    form.querySelectorAll('input, select').forEach(function (field) {
        field.addEventListener('input', updateCheckoutButton);
        field.addEventListener('change', updateCheckoutButton);
    });

    checkoutButton.addEventListener('click', function () {
        if (!form.checkValidity()) {
            form.reportValidity();
        }
    });

    if (paymentMethod && paymentMethodLabel && qrImage) {
        paymentMethod.addEventListener('change', function () {
            const isYape = paymentMethod.value === 'Yape';

            paymentMethodLabel.textContent = isYape
                ? 'Paga con Yape'
                : 'Paga con Plin';

            qrImage.src = isYape
                ? qrImage.dataset.yapeQr
                : qrImage.dataset.plinQr;

            qrImage.alt = isYape
                ? 'Código QR de pago Yape'
                : 'Código QR de pago Plin';
        });
    }

    updateCheckoutButton();
});
</script>