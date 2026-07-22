<?php

declare(strict_types=1);

/**
 * Clase base para todos los modelos.
 */
abstract class Model
{
    protected PDO $db;

    /**
     * Inicializa la conexión de datos del modelo.
     */
    public function __construct()
    {
        $this->db = Database::connection();
    }
}
