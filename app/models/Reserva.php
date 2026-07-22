<?php

declare(strict_types=1);

final class Reserva extends Model
{
    public function expireOverdueReservations(): void
    {
        $this->db->beginTransaction();

        try {
            $statement = $this->db->prepare(
                "SELECT id, mesa_id
                 FROM reservas
                 WHERE fecha = CURDATE()
                   AND hora_limite IS NOT NULL
                   AND hora_limite <= NOW()
                   AND estado IN ('PendientePago', 'Confirmada')
                 FOR UPDATE"
            );

            $statement->execute();
            $reservas = $statement->fetchAll();

            foreach ($reservas as $reserva) {
                $this->expireReservation(
                    (int) $reserva['id'],
                    (int) $reserva['mesa_id']
                );
            }

            $this->db->commit();
        } catch (Throwable $exception) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $exception;
        }
    }

    public function getTodayReservations(): array
    {
        $statement = $this->db->query(
            "SELECT
                reservas.id,
                reservas.fecha,
                reservas.hora,
                reservas.hora_limite,
                reservas.personas,
                reservas.adelanto,
                reservas.estado,
                reservas.creado AS reserva_creada,

                clientes.nombres,
                clientes.apellidos,
                clientes.dni,
                clientes.telefono,

                mesas.codigo AS mesa_codigo,

                pagos.id AS pago_id,
                pagos.metodo,
                pagos.monto,
                pagos.numero_operacion,
                pagos.voucher,
                pagos.validado,
                pagos.estado_revision,
                pagos.revisado_en,
                pagos.observacion_revision

            FROM reservas
            INNER JOIN clientes ON clientes.id = reservas.cliente_id
            INNER JOIN mesas ON mesas.id = reservas.mesa_id
            LEFT JOIN pagos ON pagos.reserva_id = reservas.id
            WHERE reservas.fecha = CURDATE()
            ORDER BY reservas.hora ASC, reservas.id ASC"
        );

        return $statement->fetchAll();
    }

    public function getTables(): array
    {
        $statement = $this->db->query(
            "SELECT id, codigo, capacidad, ubicacion, estado
             FROM mesas
             ORDER BY codigo ASC"
        );

        return $statement->fetchAll();
    }

    public function getWaitingList(): array
    {
        $statement = $this->db->query(
            "SELECT id, nombres, telefono, personas, fecha_registro
             FROM lista_espera
             ORDER BY fecha_registro ASC"
        );

        return $statement->fetchAll();
    }

    public function confirmArrivalByDni(string $dni): string
    {
        $this->db->beginTransaction();

        try {
            $statement = $this->db->prepare(
                "SELECT id, mesa_id, estado, hora_limite
                 FROM reservas
                 WHERE cliente_id = (
                    SELECT id
                    FROM clientes
                    WHERE dni = :dni
                    LIMIT 1
                 )
                 AND fecha = CURDATE()
                 ORDER BY hora ASC
                 LIMIT 1
                 FOR UPDATE"
            );

            $statement->execute(['dni' => $dni]);
            $reserva = $statement->fetch();

            if ($reserva === false) {
                throw new RuntimeException(
                    'No existe una reserva para este DNI el día de hoy.'
                );
            }

            if ((string) $reserva['estado'] !== 'Confirmada') {
                throw new RuntimeException(
                    'La reserva aún no está confirmada o ya fue procesada.'
                );
            }

            if (
                $reserva['hora_limite'] !== null
                && strtotime((string) $reserva['hora_limite']) < time()
            ) {
                $this->expireReservation(
                    (int) $reserva['id'],
                    (int) $reserva['mesa_id']
                );

                $this->db->commit();

                throw new RuntimeException(
                    'La reserva expiró porque superó la tolerancia de 20 minutos.'
                );
            }

            $updateReservation = $this->db->prepare(
                "UPDATE reservas
                 SET estado = 'EnCurso',
                     fecha_llegada = NOW()
                 WHERE id = :id"
            );

            $updateReservation->execute([
                'id' => (int) $reserva['id'],
            ]);

            $updateTable = $this->db->prepare(
                "UPDATE mesas
                 SET estado = 'Ocupada'
                 WHERE id = :mesa_id"
            );

            $updateTable->execute([
                'mesa_id' => (int) $reserva['mesa_id'],
            ]);

            $this->db->commit();

            return 'Llegada confirmada. La mesa fue marcada como ocupada.';
        } catch (Throwable $exception) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $exception;
        }
    }

    public function validatePayment(int $reservationId): string
    {
        if ($reservationId <= 0) {
            throw new RuntimeException('La reserva seleccionada no es válida.');
        }

        $this->db->beginTransaction();

        try {
            $statement = $this->db->prepare(
                "SELECT
                    reservas.id,
                    reservas.mesa_id,
                    reservas.estado,
                    pagos.id AS pago_id,
                    pagos.validado,
                    pagos.estado_revision
                 FROM reservas
                 INNER JOIN pagos ON pagos.reserva_id = reservas.id
                 WHERE reservas.id = :reservation_id
                 LIMIT 1
                 FOR UPDATE"
            );

            $statement->execute([
                'reservation_id' => $reservationId,
            ]);

            $reserva = $statement->fetch();

            if ($reserva === false) {
                throw new RuntimeException(
                    'No se encontró un pago asociado a esta reserva.'
                );
            }

            if ((int) $reserva['validado'] === 1) {
                throw new RuntimeException('Este pago ya fue validado.');
            }

            $paymentStatement = $this->db->prepare(
                "UPDATE pagos
                 SET validado = 1,
                     estado_revision = 'Aceptado',
                     revisado_en = NOW()
                 WHERE id = :pago_id"
            );

            $paymentStatement->execute([
                'pago_id' => (int) $reserva['pago_id'],
            ]);

            $reservationStatement = $this->db->prepare(
                "UPDATE reservas
                 SET estado = 'Confirmada'
                 WHERE id = :reservation_id"
            );

            $reservationStatement->execute([
                'reservation_id' => $reservationId,
            ]);

            $this->db->commit();

            return 'Pago validado. La reserva quedó confirmada.';
        } catch (Throwable $exception) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $exception;
        }
    }

    public function getPendingPaymentRequests(): array
    {
        $statement = $this->db->query(
            "SELECT
                pagos.id AS pago_id,
                pagos.metodo,
                pagos.monto,
                pagos.numero_operacion,
                pagos.voucher,
                pagos.validado,
                pagos.estado_revision,
                pagos.creado AS pago_creado,

                reservas.id AS reserva_id,
                reservas.fecha AS fecha_reserva,
                reservas.hora AS hora_reserva,
                reservas.personas,
                reservas.adelanto,
                reservas.estado AS estado_reserva,
                reservas.creado AS reserva_creada,

                clientes.nombres,
                clientes.apellidos,
                clientes.dni,
                clientes.telefono,

                mesas.codigo AS mesa_codigo,
                mesas.capacidad AS mesa_capacidad

            FROM pagos
            INNER JOIN reservas ON reservas.id = pagos.reserva_id
            INNER JOIN clientes ON clientes.id = reservas.cliente_id
            INNER JOIN mesas ON mesas.id = reservas.mesa_id

            WHERE pagos.validado = 0
              AND pagos.estado_revision = 'Pendiente'
              AND reservas.estado = 'PendientePago'

            ORDER BY pagos.creado ASC"
        );

        return $statement->fetchAll();
    }

    public function getRecentPaymentReviews(): array
    {
        $statement = $this->db->query(
            "SELECT
                pagos.id AS pago_id,
                pagos.metodo,
                pagos.monto,
                pagos.numero_operacion,
                pagos.voucher,
                pagos.validado,
                pagos.estado_revision,
                pagos.observacion_revision,
                pagos.revisado_en,

                reservas.id AS reserva_id,
                reservas.fecha AS fecha_reserva,
                reservas.hora AS hora_reserva,
                reservas.estado AS estado_reserva,

                clientes.nombres,
                clientes.apellidos,
                clientes.dni,

                mesas.codigo AS mesa_codigo,

                usuarios.nombres AS revisor_nombre

            FROM pagos
            INNER JOIN reservas ON reservas.id = pagos.reserva_id
            INNER JOIN clientes ON clientes.id = reservas.cliente_id
            INNER JOIN mesas ON mesas.id = reservas.mesa_id
            LEFT JOIN usuarios ON usuarios.id = pagos.revisado_por

            WHERE pagos.estado_revision IN ('Aceptado', 'Rechazado')

            ORDER BY pagos.revisado_en DESC, pagos.id DESC
            LIMIT 20"
        );

        return $statement->fetchAll();
    }

    public function reviewPayment(
        int $paymentId,
        string $decision,
        int $reviewedBy,
        string $observation = ''
    ): string {
        if ($paymentId <= 0) {
            throw new RuntimeException('La solicitud de pago no es válida.');
        }

        if (!in_array($decision, ['Aceptado', 'Rechazado'], true)) {
            throw new RuntimeException('La decisión de pago no es válida.');
        }

        if ($reviewedBy <= 0) {
            throw new RuntimeException('No se identificó al usuario de recepción.');
        }

        $this->db->beginTransaction();

        try {
            $statement = $this->db->prepare(
                "SELECT
                    pagos.id AS pago_id,
                    pagos.estado_revision,
                    pagos.validado,

                    reservas.id AS reserva_id,
                    reservas.mesa_id,
                    reservas.estado AS estado_reserva

                 FROM pagos
                 INNER JOIN reservas ON reservas.id = pagos.reserva_id
                 WHERE pagos.id = :pago_id
                 LIMIT 1
                 FOR UPDATE"
            );

            $statement->execute([
                'pago_id' => $paymentId,
            ]);

            $payment = $statement->fetch();

            if ($payment === false) {
                throw new RuntimeException(
                    'No se encontró el pago asociado a esta solicitud.'
                );
            }

            if ((string) $payment['estado_revision'] !== 'Pendiente') {
                throw new RuntimeException(
                    'Este pago ya fue revisado anteriormente.'
                );
            }

            $accepted = $decision === 'Aceptado';

            $paymentStatement = $this->db->prepare(
                "UPDATE pagos
                 SET validado = :validado,
                     estado_revision = :estado_revision,
                     revisado_por = :revisado_por,
                     revisado_en = NOW(),
                     observacion_revision = :observacion
                 WHERE id = :pago_id"
            );

            $paymentStatement->execute([
                'validado' => $accepted ? 1 : 0,
                'estado_revision' => $decision,
                'revisado_por' => $reviewedBy,
                'observacion' => $observation !== '' ? $observation : null,
                'pago_id' => (int) $payment['pago_id'],
            ]);

            $reservationStatement = $this->db->prepare(
                "UPDATE reservas
                 SET estado = :estado
                 WHERE id = :reserva_id"
            );

            $reservationStatement->execute([
                'estado' => $accepted ? 'Confirmada' : 'Cancelada',
                'reserva_id' => (int) $payment['reserva_id'],
            ]);

            if (!$accepted) {
                $tableStatement = $this->db->prepare(
                    "UPDATE mesas
                     SET estado = 'Libre'
                     WHERE id = :mesa_id
                       AND estado = 'Reservada'"
                );

                $tableStatement->execute([
                    'mesa_id' => (int) $payment['mesa_id'],
                ]);
            }

            $this->db->commit();

            return $accepted
                ? 'Pago aceptado. La reserva fue confirmada correctamente.'
                : 'Pago rechazado. La reserva fue cancelada y la mesa quedó libre.';
        } catch (Throwable $exception) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $exception;
        }
    }

    public function getVoucherByReservationId(int $reservationId): array|false
    {
        if ($reservationId <= 0) {
            return false;
        }

        $statement = $this->db->prepare(
            "SELECT id, voucher, metodo, numero_operacion, monto
             FROM pagos
             WHERE reserva_id = :reservation_id
             LIMIT 1"
        );

        $statement->execute([
            'reservation_id' => $reservationId,
        ]);

        return $statement->fetch();
    }

    public function getVoucherByPaymentId(int $paymentId): array|false
    {
        if ($paymentId <= 0) {
            return false;
        }

        $statement = $this->db->prepare(
            "SELECT id, voucher, metodo, numero_operacion, monto
             FROM pagos
             WHERE id = :pago_id
             LIMIT 1"
        );

        $statement->execute([
            'pago_id' => $paymentId,
        ]);

        return $statement->fetch();
    }

    private function expireReservation(
        int $reservationId,
        int $tableId
    ): void {
        $updateReservation = $this->db->prepare(
            "UPDATE reservas
             SET estado = 'Expirada',
                 fecha_expiracion = NOW()
             WHERE id = :id"
        );

        $updateReservation->execute([
            'id' => $reservationId,
        ]);

        $updateTable = $this->db->prepare(
            "UPDATE mesas
             SET estado = 'Libre'
             WHERE id = :mesa_id
               AND estado = 'Reservada'"
        );

        $updateTable->execute([
            'mesa_id' => $tableId,
        ]);
    }
}