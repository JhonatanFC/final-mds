<?php

declare(strict_types=1);

$reservation = $reservation ?? [];

$reservationId = (int) ($reservation['id'] ?? 0);
$clientName = (string) ($reservation['nombres'] ?? 'Cliente');
$date = (string) ($reservation['fecha'] ?? '');
$time = substr((string) ($reservation['hora'] ?? ''), 0, 5);
$people = (int) ($reservation['personas'] ?? 0);
?>

<main class="public-confirmation-page">
    <section class="confirmation-card">
        <div class="confirmation-icon">
            <i class="bi bi-check2-circle"></i>
        </div>

        <p class="public-eyebrow">SOLICITUD RECIBIDA</p>

        <h1>¡Gracias, <?= e($clientName) ?>!</h1>

        <p class="confirmation-description">
            Recibimos tu solicitud de reserva y el comprobante de pago.
            Recepción validará manualmente el adelanto de <strong>S/ 30.00</strong>.
        </p>

        <div class="confirmation-status">
            <i class="bi bi-hourglass-split"></i>
            <span>Pago pendiente de validación manual</span>
        </div>

        <div class="confirmation-details">
            <div>
                <span>Código de solicitud</span>
                <strong>#<?= $reservationId ?></strong>
            </div>

            <div>
                <span>Fecha reservada</span>
                <strong><?= e($date) ?></strong>
            </div>

            <div>
                <span>Hora</span>
                <strong><?= e($time) ?></strong>
            </div>

            <div>
                <span>Personas</span>
                <strong>
                    <?= $people ?>
                    <?= $people === 1 ? 'persona' : 'personas' ?>
                </strong>
            </div>
        </div>

        <div class="confirmation-information">
            <i class="bi bi-info-circle-fill"></i>

            <p>
                Cuando recepción valide tu pago, la reserva quedará confirmada.
                Tienes una tolerancia máxima de 20 minutos después de la hora reservada.
            </p>
        </div>

        <a class="confirmation-button" href="<?= APP_URL ?>/reservar">
            <i class="bi bi-arrow-left"></i>
            Volver a Reserva Fácil
        </a>

        <p class="confirmation-access">
            ¿Eres parte del restaurante?
            <a href="<?= APP_URL ?>/login">Acceso para empleados</a>
        </p>
    </section>
</main>