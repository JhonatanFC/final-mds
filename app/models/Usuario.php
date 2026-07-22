<?php

declare(strict_types=1);

/**
 * Modelo de usuarios y autenticación.
 */
final class Usuario extends Model
{
    /**
     * Busca a un usuario activo por correo, incluyendo su rol.
     *
     * @return array<string, mixed>|false
     */
    public function findActiveByEmail(string $email): array|false
    {
        $statement = $this->db->prepare(
            'SELECT
                usuarios.id,
                usuarios.rol_id,
                usuarios.nombres,
                usuarios.correo,
                usuarios.password,
                usuarios.estado,
                roles.nombre AS rol_nombre
            FROM usuarios
            INNER JOIN roles ON roles.id = usuarios.rol_id
            WHERE usuarios.correo = :correo
              AND usuarios.estado = 1
            LIMIT 1'
        );

        $statement->execute(['correo' => $email]);

        return $statement->fetch();
    }

    /**
     * Verifica la contraseña y convierte automáticamente un hash MD5 heredado.
     *
     * @param array<string, mixed> $user
     */
    public function verifyPassword(array $user, string $password): bool
    {
        $storedHash = (string) $user['password'];

        if (password_verify($password, $storedHash)) {
            return true;
        }

        /*
         * Compatibilidad temporal con el administrador creado inicialmente
         * mediante MD5. Tras acceder correctamente, se reemplaza por bcrypt.
         */
        if (hash_equals($storedHash, md5($password))) {
            $this->updatePasswordHash((int) $user['id'], password_hash($password, PASSWORD_DEFAULT));
            return true;
        }

        return false;
    }

    /**
     * Actualiza la contraseña usando un hash seguro de PHP.
     */
    private function updatePasswordHash(int $userId, string $passwordHash): void
    {
        $statement = $this->db->prepare(
            'UPDATE usuarios SET password = :password WHERE id = :id'
        );

        $statement->execute([
            'id' => $userId,
            'password' => $passwordHash,
        ]);
    }
}