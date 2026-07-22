<?php

declare(strict_types=1);

final class Categoria extends Model
{
    public function all(): array
    {
        return $this->db->query(
            'SELECT id, nombre, descripcion, activo
             FROM categorias
             ORDER BY nombre'
        )->fetchAll();
    }

    public function find(int $id): array|false
    {
        $statement = $this->db->prepare(
            'SELECT id, nombre, descripcion, activo
             FROM categorias WHERE id = :id'
        );

        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    public function save(array $data): void
{
    if ((int) $data['id'] > 0) {
        $statement = $this->db->prepare(
            'UPDATE categorias
             SET nombre = :nombre, descripcion = :descripcion, activo = :activo
             WHERE id = :id'
        );

        $statement->execute($data);
        return;
    }

    $statement = $this->db->prepare(
        'INSERT INTO categorias (nombre, descripcion, activo)
         VALUES (:nombre, :descripcion, :activo)'
    );

    $statement->execute([
        'nombre' => $data['nombre'],
        'descripcion' => $data['descripcion'],
        'activo' => $data['activo'],
    ]);
}

    public function delete(int $id): void
    {
        $statement = $this->db->prepare(
            'SELECT COUNT(*) FROM productos WHERE categoria_id = :id'
        );

        $statement->execute(['id' => $id]);

        if ((int) $statement->fetchColumn() > 0) {
            throw new RuntimeException('No puedes eliminar una categoría con productos.');
        }

        $statement = $this->db->prepare(
            'DELETE FROM categorias WHERE id = :id'
        );

        $statement->execute(['id' => $id]);
    }
}