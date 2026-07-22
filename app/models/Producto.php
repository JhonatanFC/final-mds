<?php

declare(strict_types=1);

final class Producto extends Model
{
    public function all(): array
    {
        return $this->db->query(
            'SELECT
                productos.id,
                productos.nombre,
                productos.descripcion,
                productos.imagen,
                productos.precio,
                productos.stock,
                productos.activo,
                categorias.id AS categoria_id,
                categorias.nombre AS categoria_nombre
             FROM productos
             INNER JOIN categorias ON categorias.id = productos.categoria_id
             ORDER BY categorias.nombre, productos.nombre'
        )->fetchAll();
    }

    public function find(int $id): array|false
    {
        $statement = $this->db->prepare(
            'SELECT * FROM productos WHERE id = :id'
        );

        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    public function save(array $data): void
{
    if ((int) $data['id'] > 0) {
        $statement = $this->db->prepare(
            'UPDATE productos
             SET categoria_id = :categoria_id,
                 nombre = :nombre,
                 descripcion = :descripcion,
                 imagen = :imagen,
                 precio = :precio,
                 stock = :stock,
                 activo = :activo
             WHERE id = :id'
        );

        $statement->execute($data);
        return;
    }

    $statement = $this->db->prepare(
        'INSERT INTO productos (
            categoria_id, nombre, descripcion, imagen, precio, stock, activo
         ) VALUES (
            :categoria_id, :nombre, :descripcion, :imagen, :precio, :stock, :activo
         )'
    );

    $statement->execute([
        'categoria_id' => $data['categoria_id'],
        'nombre' => $data['nombre'],
        'descripcion' => $data['descripcion'],
        'imagen' => $data['imagen'],
        'precio' => $data['precio'],
        'stock' => $data['stock'],
        'activo' => $data['activo'],
    ]);
}

    public function delete(int $id): void
    {
        $statement = $this->db->prepare(
            'SELECT COUNT(*) FROM detalle_pedido WHERE producto_id = :id'
        );

        $statement->execute(['id' => $id]);

        if ((int) $statement->fetchColumn() > 0) {
            throw new RuntimeException('No puedes eliminar un producto que tiene pedidos.');
        }

        $statement = $this->db->prepare(
            'DELETE FROM productos WHERE id = :id'
        );

        $statement->execute(['id' => $id]);
    }

        /**
     * Devuelve los productos disponibles para el menú público.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getPublicMenu(): array
{
    $statement = $this->db->query(
        "SELECT
            productos.id,
            productos.nombre,
            productos.descripcion,
            productos.imagen,
            productos.precio,
            productos.stock,
            categorias.nombre AS categoria
        FROM productos
        INNER JOIN categorias
            ON categorias.id = productos.categoria_id
        WHERE productos.activo = 1
          AND productos.stock > 0
          AND categorias.activo = 1
        ORDER BY categorias.nombre ASC, productos.nombre ASC"
    );

    return $statement->fetchAll();
}
}