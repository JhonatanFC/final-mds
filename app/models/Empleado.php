<?php

declare(strict_types=1);

final class Empleado extends Model
{
    public function getAll(): array
    {
        $statement = $this->db->query(
            "SELECT
                usuarios.id,
                usuarios.nombres,
                usuarios.correo,
                usuarios.estado,
                usuarios.creado,
                roles.nombre AS rol
            FROM usuarios
            INNER JOIN roles ON roles.id = usuarios.rol_id
            ORDER BY usuarios.id DESC"
        );

        return $statement->fetchAll();
    }

    public function getRoles(): array
    {
        $statement = $this->db->query(
            "SELECT id, nombre
             FROM roles
             ORDER BY nombre ASC"
        );

        return $statement->fetchAll();
    }

    public function create(
        int $roleId,
        string $names,
        string $email,
        string $password
    ): void {
        if ($roleId <= 0) {
            throw new RuntimeException('Selecciona un rol válido.');
        }

        if (mb_strlen($names) < 3) {
            throw new RuntimeException('Ingresa nombres válidos.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Ingresa un correo válido.');
        }

        if (mb_strlen($password) < 6) {
            throw new RuntimeException('La contraseña debe tener como mínimo 6 caracteres.');
        }

        $statement = $this->db->prepare(
            "INSERT INTO usuarios (
                rol_id,
                nombres,
                correo,
                password,
                estado
            ) VALUES (
                :rol_id,
                :nombres,
                :correo,
                :password,
                1
            )"
        );

        try {
            $statement->execute([
                'rol_id' => $roleId,
                'nombres' => $names,
                'correo' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') {
                throw new RuntimeException('El correo ya está registrado.');
            }

            throw $exception;
        }
    }

    public function toggleStatus(int $employeeId): void
    {
        if ($employeeId <= 0) {
            throw new RuntimeException('El empleado no es válido.');
        }

        $statement = $this->db->prepare(
            "UPDATE usuarios
             SET estado = CASE WHEN estado = 1 THEN 0 ELSE 1 END
             WHERE id = :id"
        );

        $statement->execute(['id' => $employeeId]);

        if ($statement->rowCount() === 0) {
            throw new RuntimeException('No se encontró el empleado solicitado.');
        }
    }
}