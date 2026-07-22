<?php

declare(strict_types=1);

final class Reporte extends Model
{
    public function getTodayMetrics(): array
    {
        $date = date('Y-m-d');
        $summary = $this->getSummary($date);

        $openOrdersStatement = $this->db->query(
            "SELECT COUNT(*) AS total
             FROM pedidos
             WHERE estado IN ('Pendiente', 'Preparando', 'Entregado')"
        );

        $openOrders = (int) ($openOrdersStatement->fetch()['total'] ?? 0);

        return [
            'ventas_hoy' => (float) $summary['ventas'],
            'reservas_hoy' => (int) $summary['reservas'],
            'mesas_ocupadas' => (int) $summary['mesas_ocupadas'],
            'pedidos_abiertos' => $openOrders,

            'sales' => (float) $summary['ventas'],
            'reservations' => (int) $summary['reservas'],
            'occupiedTables' => (int) $summary['mesas_ocupadas'],
            'openOrders' => $openOrders,
        ];
    }

    public function getSummary(string $date): array
    {
        $salesStatement = $this->db->prepare(
            "SELECT
                COUNT(*) AS total_cobros,
                COALESCE(SUM(monto), 0) AS ventas,
                COALESCE(AVG(monto), 0) AS ticket_promedio
             FROM cobros
             WHERE DATE(creado) = :fecha"
        );

        $salesStatement->execute(['fecha' => $date]);
        $sales = $salesStatement->fetch() ?: [];

        $reservationStatement = $this->db->prepare(
            "SELECT
                COUNT(*) AS reservas,
                SUM(estado = 'Confirmada') AS confirmadas,
                SUM(estado = 'Expirada') AS expiradas,
                SUM(estado = 'Cancelada') AS canceladas
             FROM reservas
             WHERE fecha = :fecha"
        );

        $reservationStatement->execute(['fecha' => $date]);
        $reservations = $reservationStatement->fetch() ?: [];

        $tableStatement = $this->db->query(
            "SELECT
                COUNT(*) AS mesas_total,
                SUM(estado = 'Libre') AS mesas_libres,
                SUM(estado = 'Ocupada') AS mesas_ocupadas,
                SUM(estado = 'Reservada') AS mesas_reservadas
             FROM mesas"
        );

        $tables = $tableStatement->fetch() ?: [];

        return [
            'ventas' => (float) ($sales['ventas'] ?? 0),
            'total_cobros' => (int) ($sales['total_cobros'] ?? 0),
            'ticket_promedio' => (float) ($sales['ticket_promedio'] ?? 0),
            'reservas' => (int) ($reservations['reservas'] ?? 0),
            'confirmadas' => (int) ($reservations['confirmadas'] ?? 0),
            'expiradas' => (int) ($reservations['expiradas'] ?? 0),
            'canceladas' => (int) ($reservations['canceladas'] ?? 0),
            'mesas_total' => (int) ($tables['mesas_total'] ?? 0),
            'mesas_libres' => (int) ($tables['mesas_libres'] ?? 0),
            'mesas_ocupadas' => (int) ($tables['mesas_ocupadas'] ?? 0),
            'mesas_reservadas' => (int) ($tables['mesas_reservadas'] ?? 0),
        ];
    }

    public function getWeeklySales(): array
    {
        return $this->getDailySales(date('Y-m-d'));
    }

    public function getDailySales(string $date): array
    {
        $startDate = (new DateTimeImmutable($date))
            ->modify('-6 days')
            ->format('Y-m-d');

        $statement = $this->db->prepare(
            "SELECT
                DATE(creado) AS fecha,
                COALESCE(SUM(monto), 0) AS total
             FROM cobros
             WHERE DATE(creado) BETWEEN :inicio AND :fin
             GROUP BY DATE(creado)
             ORDER BY fecha ASC"
        );

        $statement->execute([
            'inicio' => $startDate,
            'fin' => $date,
        ]);

        return $statement->fetchAll();
    }

    public function getSalesByMethod(string $date): array
    {
        $statement = $this->db->prepare(
            "SELECT
                metodo,
                COUNT(*) AS cantidad,
                COALESCE(SUM(monto), 0) AS total
             FROM cobros
             WHERE DATE(creado) = :fecha
             GROUP BY metodo
             ORDER BY total DESC"
        );

        $statement->execute(['fecha' => $date]);

        return $statement->fetchAll();
    }

    public function getTopProducts(?string $date = null): array
    {
        $date ??= date('Y-m-d');

        $statement = $this->db->prepare(
            "SELECT
                productos.nombre,
                SUM(detalle_pedido.cantidad) AS cantidad,
                COALESCE(SUM(detalle_pedido.subtotal), 0) AS total
             FROM detalle_pedido
             INNER JOIN pedidos ON pedidos.id = detalle_pedido.pedido_id
             INNER JOIN productos ON productos.id = detalle_pedido.producto_id
             WHERE DATE(pedidos.fecha) = :fecha
             GROUP BY productos.id, productos.nombre
             ORDER BY cantidad DESC, total DESC
             LIMIT 8"
        );

        $statement->execute(['fecha' => $date]);

        return $statement->fetchAll();
    }

    public function getRecentCharges(string $date): array
    {
        $statement = $this->db->prepare(
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
             LEFT JOIN mesas ON mesas.id = pedidos.mesa_id
             LEFT JOIN usuarios ON usuarios.id = cobros.cajera_id
             WHERE DATE(cobros.creado) = :fecha
             ORDER BY cobros.id DESC
             LIMIT 15"
        );

        $statement->execute(['fecha' => $date]);

        return $statement->fetchAll();
    }

    public function getRecentSales(): array
    {
        return $this->getRecentCharges(date('Y-m-d'));
    }
}