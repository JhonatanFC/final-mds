<?php

declare(strict_types=1);

/**
 * Gestiona pedidos, productos, stock y totales de consumo.
 */
final class Pedido extends Model
{
    /**
     * Obtiene las mesas disponibles para tomar pedidos.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAvailableTables(): array
    {
        $statement = $this->db->query(
            "SELECT id, codigo, capacidad, ubicacion, estado
             FROM mesas
             WHERE estado IN ('Libre', 'Ocupada')
             ORDER BY codigo ASC"
        );

        return $statement->fetchAll();
    }

    /**
     * Obtiene los productos activos y con stock.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAvailableProducts(): array
    {
        $statement = $this->db->query(
            "SELECT
                productos.id,
                productos.nombre,
                productos.precio,
                productos.stock,
                categorias.nombre AS categoria
            FROM productos
            INNER JOIN categorias ON categorias.id = productos.categoria_id
            WHERE productos.activo = 1
              AND categorias.activo = 1
              AND productos.stock > 0
            ORDER BY categorias.nombre ASC, productos.nombre ASC"
        );

        return $statement->fetchAll();
    }

    /**
     * Crea un pedido, sus detalles y descuenta stock.
     *
     * @param array<int, array<string, mixed>> $items
     */
    public function createOrder(
        int $mesaId,
        int $meseroId,
        array $items,
        string $observaciones = ''
    ): int {
        if ($items === []) {
            throw new RuntimeException('Debe agregar al menos un producto al pedido.');
        }

        $this->db->beginTransaction();

        try {
            $tableStatement = $this->db->prepare(
                "SELECT id, estado
                 FROM mesas
                 WHERE id = :mesa_id
                 FOR UPDATE"
            );
            $tableStatement->execute(['mesa_id' => $mesaId]);
            $table = $tableStatement->fetch();

            if ($table === false) {
                throw new RuntimeException('La mesa seleccionada no existe.');
            }

            if ($table['estado'] === 'Limpieza') {
                throw new RuntimeException('La mesa está en limpieza.');
            }

            $reservationStatement = $this->db->prepare(
                "SELECT id, adelanto
                 FROM reservas
                 WHERE mesa_id = :mesa_id
                   AND fecha = CURDATE()
                   AND estado = 'EnCurso'
                 ORDER BY id DESC
                 LIMIT 1"
            );
            $reservationStatement->execute(['mesa_id' => $mesaId]);
            $reservation = $reservationStatement->fetch();

            $reservationId = $reservation !== false ? (int) $reservation['id'] : null;
            $adelanto = $reservation !== false ? (float) $reservation['adelanto'] : 0.00;
            $subtotal = 0.00;
            $validatedItems = [];

            $productStatement = $this->db->prepare(
                "SELECT id, nombre, precio, stock
                 FROM productos
                 WHERE id = :producto_id
                   AND activo = 1
                 FOR UPDATE"
            );

            foreach ($items as $item) {
                $productId = (int) ($item['producto_id'] ?? 0);
                $quantity = (int) ($item['cantidad'] ?? 0);

                if ($productId <= 0 || $quantity <= 0) {
                    throw new RuntimeException('Existe un producto o cantidad inválida.');
                }

                $productStatement->execute(['producto_id' => $productId]);
                $product = $productStatement->fetch();

                if ($product === false) {
                    throw new RuntimeException('Uno de los productos ya no está disponible.');
                }

                if ((int) $product['stock'] < $quantity) {
                    throw new RuntimeException(
                        'Stock insuficiente para: ' . $product['nombre']
                    );
                }

                $price = (float) $product['precio'];
                $lineTotal = round($price * $quantity, 2);
                $subtotal += $lineTotal;

                $validatedItems[] = [
                    'producto_id' => $productId,
                    'cantidad' => $quantity,
                    'precio' => $price,
                    'subtotal' => $lineTotal,
                ];
            }

            $adelantoAplicado = min($adelanto, $subtotal);
            $total = $subtotal - $adelantoAplicado;

            $orderStatement = $this->db->prepare(
                "INSERT INTO pedidos (
                    reserva_id,
                    mesa_id,
                    mesero_id,
                    estado,
                    observaciones,
                    subtotal,
                    descuento,
                    adelanto_aplicado,
                    total
                ) VALUES (
                    :reserva_id,
                    :mesa_id,
                    :mesero_id,
                    'Pendiente',
                    :observaciones,
                    :subtotal,
                    0.00,
                    :adelanto_aplicado,
                    :total
                )"
            );

            $orderStatement->execute([
                'reserva_id' => $reservationId,
                'mesa_id' => $mesaId,
                'mesero_id' => $meseroId,
                'observaciones' => trim($observaciones) !== '' ? trim($observaciones) : null,
                'subtotal' => $subtotal,
                'adelanto_aplicado' => $adelantoAplicado,
                'total' => $total,
            ]);

            $orderId = (int) $this->db->lastInsertId();

            $detailStatement = $this->db->prepare(
                "INSERT INTO detalle_pedido (
                    pedido_id,
                    producto_id,
                    cantidad,
                    precio,
                    subtotal
                ) VALUES (
                    :pedido_id,
                    :producto_id,
                    :cantidad,
                    :precio,
                    :subtotal
                )"
            );

            $stockStatement = $this->db->prepare(
                "UPDATE productos
                 SET stock = stock - :cantidad
                 WHERE id = :producto_id"
            );

            foreach ($validatedItems as $item) {
                $detailStatement->execute([
                    'pedido_id' => $orderId,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                    'subtotal' => $item['subtotal'],
                ]);

                $stockStatement->execute([
                    'cantidad' => $item['cantidad'],
                    'producto_id' => $item['producto_id'],
                ]);
            }

            $updateTable = $this->db->prepare(
                "UPDATE mesas
                 SET estado = 'Ocupada'
                 WHERE id = :mesa_id"
            );
            $updateTable->execute(['mesa_id' => $mesaId]);

            $this->db->commit();

            return $orderId;
        } catch (Throwable $exception) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $exception;
        }
    }

    /**
     * Obtiene pedidos que todavía no han sido cobrados.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getActiveOrders(): array
    {
        $statement = $this->db->query(
            "SELECT
                pedidos.id,
                pedidos.estado,
                pedidos.fecha,
                pedidos.subtotal,
                pedidos.adelanto_aplicado,
                pedidos.total,
                mesas.codigo AS mesa_codigo,
                usuarios.nombres AS mesero_nombre,
                clientes.nombres AS cliente_nombre,
                clientes.apellidos AS cliente_apellido
            FROM pedidos
            INNER JOIN mesas ON mesas.id = pedidos.mesa_id
            LEFT JOIN usuarios ON usuarios.id = pedidos.mesero_id
            LEFT JOIN reservas ON reservas.id = pedidos.reserva_id
            LEFT JOIN clientes ON clientes.id = reservas.cliente_id
            WHERE pedidos.estado IN ('Pendiente', 'Preparando', 'Entregado')
            ORDER BY pedidos.fecha DESC"
        );

        return $statement->fetchAll();
    }

    /**
     * Actualiza el avance operativo de un pedido.
     */
    public function updateStatus(int $orderId, string $status): void
    {
        $allowedStatuses = ['Pendiente', 'Preparando', 'Entregado'];

        if (!in_array($status, $allowedStatuses, true)) {
            throw new RuntimeException('El estado del pedido no es válido.');
        }

        $statement = $this->db->prepare(
            "UPDATE pedidos
             SET estado = :estado
             WHERE id = :id
               AND estado <> 'Pagado'"
        );

        $statement->execute([
            'id' => $orderId,
            'estado' => $status,
        ]);
    }
}