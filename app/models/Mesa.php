<?php

declare(strict_types=1);

/**
 * Gestiona el acceso a datos de mesas.
 */
final class Mesa extends Model
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $statement = $this->db->query(
            'SELECT id, codigo, capacidad, ubicacion, estado
             FROM mesas
             ORDER BY codigo ASC'
        );

        return $statement->fetchAll();
    }

    /**
     * @return array<string, mixed>|false
     */
    public function find(int $id): array|false
    {
        $statement = $this->db->prepare(
            'SELECT id, codigo, capacidad, ubicacion, estado
             FROM mesas
             WHERE id = :id
             LIMIT 1'
        );

        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function save(array $data): void
{
    if ((int) $data['id'] > 0) {
        $statement = $this->db->prepare(
            "UPDATE mesas
             SET codigo = :codigo,
                 capacidad = :capacidad,
                 ubicacion = :ubicacion,
                 estado = :estado
             WHERE id = :id"
        );

        $statement->execute($data);
        return;
    }

    $statement = $this->db->prepare(
        "INSERT INTO mesas (codigo, capacidad, ubicacion, estado)
         VALUES (:codigo, :capacidad, :ubicacion, :estado)"
    );

    $statement->execute([
        'codigo' => $data['codigo'],
        'capacidad' => $data['capacidad'],
        'ubicacion' => $data['ubicacion'],
        'estado' => $data['estado'],
    ]);
}

    /**
     * Elimina una mesa solo si no tiene reservas asociadas.
     */
    public function delete(int $id): void
    {
        $reservationStatement = $this->db->prepare(
            'SELECT COUNT(*) FROM reservas WHERE mesa_id = :id'
        );

        $reservationStatement->execute(['id' => $id]);

        if ((int) $reservationStatement->fetchColumn() > 0) {
            throw new RuntimeException(
                'No se puede eliminar una mesa que tiene reservas registradas.'
            );
        }

        $statement = $this->db->prepare(
            'DELETE FROM mesas WHERE id = :id'
        );

        $statement->execute(['id' => $id]);
    }
}