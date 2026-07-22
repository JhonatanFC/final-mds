<?php

declare(strict_types=1);

/**
 * Gestiona el registro público de clientes, reservas y adelantos.
 */
final class ReservaPublica extends Model
{
    /**
     * Registra cliente, reserva, pago pendiente y bloqueo de mesa.
     *
     * @param array<string, mixed> $data
     */
    public function createReservation(array $data): int
    {
        $this->db->beginTransaction();

        try {
            $clientId = $this->findOrCreateClient($data);
            $table = $this->findAvailableTable((int) $data['personas']);

            if ($table === false) {
                throw new RuntimeException(
                    'No hay mesas libres con capacidad para la cantidad de personas indicada.'
                );
            }

            $reservationDateTime = new DateTimeImmutable(
                (string) $data['fecha'] . ' ' . (string) $data['hora']
            );

            $limitTime = $reservationDateTime
                ->modify('+20 minutes')
                ->format('Y-m-d H:i:s');

            $blockedUntil = $reservationDateTime
                ->modify('+2 hours')
                ->format('Y-m-d H:i:s');

            $reservationStatement = $this->db->prepare(
                "INSERT INTO reservas (
                    cliente_id,
                    mesa_id,
                    fecha,
                    hora,
                    personas,
                    adelanto,
                    hora_limite,
                    bloqueo_hasta,
                    estado
                ) VALUES (
                    :cliente_id,
                    :mesa_id,
                    :fecha,
                    :hora,
                    :personas,
                    :adelanto,
                    :hora_limite,
                    :bloqueo_hasta,
                    'PendientePago'
                )"
            );

            $reservationStatement->execute([
                'cliente_id' => $clientId,
                'mesa_id' => (int) $table['id'],
                'fecha' => (string) $data['fecha'],
                'hora' => (string) $data['hora'] . ':00',
                'personas' => (int) $data['personas'],
                'adelanto' => 30.00,
                'hora_limite' => $limitTime,
                'bloqueo_hasta' => $blockedUntil,
            ]);

            $reservationId = (int) $this->db->lastInsertId();

            $paymentStatement = $this->db->prepare(
                "INSERT INTO pagos (
                    reserva_id,
                    metodo,
                    monto,
                    numero_operacion,
                    voucher,
                    validado
                ) VALUES (
                    :reserva_id,
                    :metodo,
                    :monto,
                    :numero_operacion,
                    :voucher,
                    0
                )"
            );

            $paymentStatement->execute([
                'reserva_id' => $reservationId,
                'metodo' => (string) $data['metodo'],
                'monto' => 30.00,
                'numero_operacion' => (string) $data['numero_operacion'],
                'voucher' => (string) $data['voucher'],
            ]);

            $tableStatement = $this->db->prepare(
                "UPDATE mesas
                 SET estado = 'Reservada'
                 WHERE id = :mesa_id"
            );

            $tableStatement->execute([
                'mesa_id' => (int) $table['id'],
            ]);

            $this->db->commit();

            return $reservationId;
        } catch (Throwable $exception) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $exception;
        }
    }

    /**
     * Busca un cliente por DNI o registra uno nuevo.
     *
     * @param array<string, mixed> $data
     */
    private function findOrCreateClient(array $data): int
    {
        $findStatement = $this->db->prepare(
            "SELECT id
             FROM clientes
             WHERE dni = :dni
             LIMIT 1
             FOR UPDATE"
        );

        $findStatement->execute([
            'dni' => (string) $data['dni'],
        ]);

        $client = $findStatement->fetch();

        if ($client !== false) {
            $updateStatement = $this->db->prepare(
                "UPDATE clientes
                 SET nombres = :nombres,
                     apellidos = :apellidos,
                     telefono = :telefono
                 WHERE id = :id"
            );

            $updateStatement->execute([
                'id' => (int) $client['id'],
                'nombres' => (string) $data['nombres'],
                'apellidos' => (string) $data['apellidos'],
                'telefono' => (string) $data['telefono'],
            ]);

            return (int) $client['id'];
        }

        $insertStatement = $this->db->prepare(
            "INSERT INTO clientes (
                nombres,
                apellidos,
                dni,
                telefono
            ) VALUES (
                :nombres,
                :apellidos,
                :dni,
                :telefono
            )"
        );

        $insertStatement->execute([
            'nombres' => (string) $data['nombres'],
            'apellidos' => (string) $data['apellidos'],
            'dni' => (string) $data['dni'],
            'telefono' => (string) $data['telefono'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Busca la mesa libre con capacidad suficiente más pequeña.
     *
     * @return array<string, mixed>|false
     */
    private function findAvailableTable(int $people): array|false
    {
        $statement = $this->db->prepare(
            "SELECT id, codigo, capacidad
             FROM mesas
             WHERE estado = 'Libre'
               AND capacidad >= :personas
             ORDER BY capacidad ASC, codigo ASC
             LIMIT 1
             FOR UPDATE"
        );

        $statement->execute([
            'personas' => $people,
        ]);

        return $statement->fetch();
    }
}