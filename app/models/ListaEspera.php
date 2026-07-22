<?php

declare(strict_types=1);

/**
 * Gestiona la lista de espera FIFO y la asignación de mesas.
 */
final class ListaEspera extends Model
{
    /**
     * Devuelve solicitudes pendientes en orden FIFO.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getPending(): array
    {
        $statement = $this->db->query(
            "SELECT
                lista_espera.id,
                lista_espera.nombres,
                lista_espera.telefono,
                lista_espera.personas,
                lista_espera.estado,
                lista_espera.fecha_registro,
                mesas.codigo AS mesa_codigo
            FROM lista_espera
            LEFT JOIN mesas ON mesas.id = lista_espera.mesa_id
            WHERE lista_espera.estado = 'En espera'
            ORDER BY lista_espera.fecha_registro ASC"
        );

        return $statement->fetchAll();
    }

    /**
     * Devuelve las últimas solicitudes atendidas o canceladas.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRecent(): array
    {
        $statement = $this->db->query(
            "SELECT
                lista_espera.id,
                lista_espera.nombres,
                lista_espera.telefono,
                lista_espera.personas,
                lista_espera.estado,
                lista_espera.fecha_registro,
                lista_espera.atendido_en,
                mesas.codigo AS mesa_codigo
            FROM lista_espera
            LEFT JOIN mesas ON mesas.id = lista_espera.mesa_id
            WHERE lista_espera.estado IN ('Atendido', 'Cancelado')
            ORDER BY COALESCE(
                lista_espera.atendido_en,
                lista_espera.fecha_registro
            ) DESC
            LIMIT 20"
        );

        return $statement->fetchAll();
    }

    /**
     * Devuelve todas las mesas libres disponibles.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAvailableTables(): array
{
    $statement = $this->db->query(
        "SELECT id, codigo, capacidad, ubicacion
         FROM mesas
         WHERE estado = 'Libre'
         ORDER BY capacidad ASC, codigo ASC"
    );

    return $statement->fetchAll();
}

    /**
     * Agrega un cliente a la lista de espera.
     */
    public function add(
        string $names,
        string $phone,
        int $people
    ): void {
        if ($names === '') {
            throw new RuntimeException('Ingresa el nombre del cliente.');
        }

        if ($phone === '') {
            throw new RuntimeException('Ingresa el celular del cliente.');
        }

        if ($people < 1 || $people > 20) {
            throw new RuntimeException(
                'La cantidad de personas debe estar entre 1 y 20.'
            );
        }

        $statement = $this->db->prepare(
            "INSERT INTO lista_espera (
                nombres,
                telefono,
                personas,
                estado
            ) VALUES (
                :nombres,
                :telefono,
                :personas,
                'En espera'
            )"
        );

        $statement->execute([
            'nombres' => $names,
            'telefono' => $phone,
            'personas' => $people,
        ]);
    }

    /**
     * Asigna una mesa libre compatible a la solicitud.
     */
    public function assignTable(int $waitingId, int $tableId): string
    {
        if ($waitingId <= 0 || $tableId <= 0) {
            throw new RuntimeException('La solicitud o mesa seleccionada no es válida.');
        }

        $this->db->beginTransaction();

        try {
            $waitingStatement = $this->db->prepare(
                "SELECT
                    id,
                    nombres,
                    personas,
                    estado
                FROM lista_espera
                WHERE id = :waiting_id
                FOR UPDATE"
            );

            $waitingStatement->execute([
                'waiting_id' => $waitingId,
            ]);

            $waiting = $waitingStatement->fetch();

            if ($waiting === false) {
                throw new RuntimeException('No se encontró la solicitud de espera.');
            }

            if ($waiting['estado'] !== 'En espera') {
                throw new RuntimeException(
                    'Esta solicitud ya fue atendida o cancelada.'
                );
            }

            $tableStatement = $this->db->prepare(
                "SELECT
                    id,
                    codigo,
                    capacidad,
                    estado
                FROM mesas
                WHERE id = :table_id
                FOR UPDATE"
            );

            $tableStatement->execute([
                'table_id' => $tableId,
            ]);

            $table = $tableStatement->fetch();

            if ($table === false) {
                throw new RuntimeException('No se encontró la mesa seleccionada.');
            }

            if ($table['estado'] !== 'Libre') {
                throw new RuntimeException(
                    'La mesa ya no se encuentra disponible.'
                );
            }

            if ((int) $table['capacidad'] < (int) $waiting['personas']) {
                throw new RuntimeException(
                    'La mesa seleccionada no tiene capacidad suficiente.'
                );
            }

            $updateWaiting = $this->db->prepare(
                "UPDATE lista_espera
                SET
                    estado = 'Atendido',
                    mesa_id = :mesa_id,
                    atendido_en = NOW()
                WHERE id = :waiting_id
                    AND estado = 'En espera'"
            );

            $updateWaiting->execute([
                'mesa_id' => $tableId,
                'waiting_id' => $waitingId,
            ]);

            if ($updateWaiting->rowCount() !== 1) {
                throw new RuntimeException(
                    'No fue posible actualizar la solicitud de espera.'
                );
            }

            $updateTable = $this->db->prepare(
                "UPDATE mesas
                SET estado = 'Ocupada'
                WHERE id = :table_id
                    AND estado = 'Libre'"
            );

            $updateTable->execute([
                'table_id' => $tableId,
            ]);

            if ($updateTable->rowCount() !== 1) {
                throw new RuntimeException(
                    'La mesa ya fue tomada por otro proceso.'
                );
            }

            $this->db->commit();

            return 'Mesa ' . $table['codigo']
                . ' asignada correctamente a '
                . $waiting['nombres'] . '.';
        } catch (Throwable $exception) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $exception;
        }
    }

    /**
     * Cancela una solicitud pendiente.
     */
    public function cancel(int $waitingId): void
    {
        if ($waitingId <= 0) {
            throw new RuntimeException('La solicitud seleccionada no es válida.');
        }

        $statement = $this->db->prepare(
            "UPDATE lista_espera
            SET estado = 'Cancelado'
            WHERE id = :waiting_id
                AND estado = 'En espera'"
        );

        $statement->execute([
            'waiting_id' => $waitingId,
        ]);

        if ($statement->rowCount() !== 1) {
            throw new RuntimeException(
                'La solicitud no existe o ya fue atendida.'
            );
        }
    }
}