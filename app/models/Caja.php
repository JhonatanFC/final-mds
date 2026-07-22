<?php

declare(strict_types=1);

/**
 * Gestiona los cobros finales de pedidos y la aplicación de adelantos.
 */
final class Caja extends Model
{
    /**
     * Obtiene pedidos pendientes de cobro.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getPendingCharges(): array
    {
        $statement = $this->db->query(
            "SELECT
                pedidos.id,
                pedidos.reserva_id,
                pedidos.mesa_id,
                pedidos.estado,
                pedidos.subtotal,
                pedidos.descuento,
                pedidos.adelanto_aplicado,
                pedidos.total,
                mesas.codigo AS mesa_codigo,
                clientes.nombres AS cliente_nombres,
                clientes.apellidos AS cliente_apellidos,
                COALESCE(
                    (
                        SELECT pagos.monto
                        FROM pagos
                        WHERE pagos.reserva_id = pedidos.reserva_id
                          AND pagos.validado = 1
                          AND pagos.estado_revision = 'Aceptado'
                        ORDER BY pagos.id DESC
                        LIMIT 1
                    ),
                    0
                ) AS adelanto_validado
            FROM pedidos
            INNER JOIN mesas ON mesas.id = pedidos.mesa_id
            LEFT JOIN reservas ON reservas.id = pedidos.reserva_id
            LEFT JOIN clientes ON clientes.id = reservas.cliente_id
            LEFT JOIN cobros ON cobros.pedido_id = pedidos.id
            WHERE pedidos.estado <> 'Pagado'
              AND pedidos.subtotal > 0
              AND cobros.id IS NULL
            ORDER BY pedidos.fecha ASC, pedidos.id ASC"
        );

        return $statement->fetchAll();
    }

    /**
     * Obtiene cobros registrados durante el día.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getTodayCharges(): array
    {
        $statement = $this->db->query(
            "SELECT
                cobros.id,
                cobros.monto,
                cobros.metodo,
                cobros.comprobante,
                cobros.numero_operacion,
                cobros.creado,
                mesas.codigo AS mesa_codigo,
                usuarios.nombres AS cajera_nombre
            FROM cobros
            INNER JOIN pedidos ON pedidos.id = cobros.pedido_id
            INNER JOIN mesas ON mesas.id = pedidos.mesa_id
            INNER JOIN usuarios ON usuarios.id = cobros.cajera_id
            WHERE DATE(cobros.creado) = CURDATE()
            ORDER BY cobros.id DESC"
        );

        return $statement->fetchAll();
    }

    /**
     * Devuelve indicadores del día.
     *
     * @return array<string, float|int>
     */
    public function getTodaySummary(): array
    {
        $statement = $this->db->query(
            "SELECT
                COUNT(*) AS total_cobros,
                COALESCE(SUM(monto), 0) AS ventas_dia
            FROM cobros
            WHERE DATE(creado) = CURDATE()"
        );

        $summary = $statement->fetch();

        return [
            'total_cobros' => (int) ($summary['total_cobros'] ?? 0),
            'ventas_dia' => (float) ($summary['ventas_dia'] ?? 0),
        ];
    }

    /**
     * Cobra un pedido, aplica el adelanto aprobado y libera la mesa.
     */
    public function chargeOrder(
        int $orderId,
        int $cashierId,
        string $method,
        string $receiptType,
        string $operationNumber = ''
    ): string {
        $validMethods = ['Efectivo', 'Tarjeta', 'Yape', 'Plin', 'QR'];
        $validReceipts = ['Boleta', 'Factura'];

        if ($orderId <= 0) {
            throw new RuntimeException('El pedido seleccionado no es válido.');
        }

        if (!in_array($method, $validMethods, true)) {
            throw new RuntimeException('Selecciona un método de cobro válido.');
        }

        if (!in_array($receiptType, $validReceipts, true)) {
            throw new RuntimeException('Selecciona Boleta o Factura.');
        }

        if (
            in_array($method, ['Yape', 'Plin', 'QR'], true)
            && trim($operationNumber) === ''
        ) {
            throw new RuntimeException(
                'Ingresa el número de operación para este método de pago.'
            );
        }

        $this->db->beginTransaction();

        try {
            $orderStatement = $this->db->prepare(
                "SELECT
                    pedidos.id,
                    pedidos.reserva_id,
                    pedidos.mesa_id,
                    pedidos.estado,
                    pedidos.subtotal,
                    pedidos.descuento
                FROM pedidos
                WHERE pedidos.id = :pedido_id
                LIMIT 1
                FOR UPDATE"
            );

            $orderStatement->execute(['pedido_id' => $orderId]);
            $order = $orderStatement->fetch();

            if ($order === false) {
                throw new RuntimeException('No se encontró el pedido.');
            }

            if ((string) $order['estado'] === 'Pagado') {
                throw new RuntimeException('Este pedido ya fue pagado.');
            }

            $existingChargeStatement = $this->db->prepare(
                "SELECT id
                 FROM cobros
                 WHERE pedido_id = :pedido_id
                 LIMIT 1
                 FOR UPDATE"
            );

            $existingChargeStatement->execute(['pedido_id' => $orderId]);

            if ($existingChargeStatement->fetch() !== false) {
                throw new RuntimeException(
                    'Ya existe un cobro registrado para este pedido.'
                );
            }

            $advance = 0.0;

            if ($order['reserva_id'] !== null) {
                $advanceStatement = $this->db->prepare(
                    "SELECT COALESCE(MAX(monto), 0) AS adelanto
                     FROM pagos
                     WHERE reserva_id = :reserva_id
                       AND validado = 1
                       AND estado_revision = 'Aceptado'"
                );

                $advanceStatement->execute([
                    'reserva_id' => (int) $order['reserva_id'],
                ]);

                $advanceRow = $advanceStatement->fetch();
                $advance = (float) ($advanceRow['adelanto'] ?? 0);
            }

            $subtotal = (float) $order['subtotal'];
            $discount = max(0, (float) $order['descuento']);
            $totalConsumption = max(0, $subtotal - $discount);
            $advanceApplied = min($advance, $totalConsumption);
            $totalToPay = max(0, $totalConsumption - $advanceApplied);

            $cashStatement = $this->db->prepare(
                "INSERT INTO caja (
                    pedido_id,
                    adelanto,
                    total_consumo,
                    total_pagar
                ) VALUES (
                    :pedido_id,
                    :adelanto,
                    :total_consumo,
                    :total_pagar
                )"
            );

            $cashStatement->execute([
                'pedido_id' => $orderId,
                'adelanto' => $advanceApplied,
                'total_consumo' => $totalConsumption,
                'total_pagar' => $totalToPay,
            ]);

            $chargeStatement = $this->db->prepare(
                "INSERT INTO cobros (
                    pedido_id,
                    cajera_id,
                    monto,
                    metodo,
                    comprobante,
                    numero_operacion
                ) VALUES (
                    :pedido_id,
                    :cajera_id,
                    :monto,
                    :metodo,
                    :comprobante,
                    :numero_operacion
                )"
            );

            $chargeStatement->execute([
                'pedido_id' => $orderId,
                'cajera_id' => $cashierId,
                'monto' => $totalToPay,
                'metodo' => $method,
                'comprobante' => $receiptType,
                'numero_operacion' => trim($operationNumber) !== ''
                    ? trim($operationNumber)
                    : null,
            ]);

            $updateOrderStatement = $this->db->prepare(
                "UPDATE pedidos
                 SET estado = 'Pagado',
                     adelanto_aplicado = :adelanto_aplicado,
                     total = :total
                 WHERE id = :pedido_id"
            );

            $updateOrderStatement->execute([
                'adelanto_aplicado' => $advanceApplied,
                'total' => $totalToPay,
                'pedido_id' => $orderId,
            ]);

            $updateTableStatement = $this->db->prepare(
                "UPDATE mesas
                 SET estado = 'Libre'
                 WHERE id = :mesa_id"
            );

            $updateTableStatement->execute([
                'mesa_id' => (int) $order['mesa_id'],
            ]);

            $this->db->commit();

            return 'Cobro registrado. Total cobrado: S/ '
                . number_format($totalToPay, 2) . '.';
        } catch (Throwable $exception) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $exception;
        }
    }
}