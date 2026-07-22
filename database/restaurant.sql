USE restaurante;

CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    dni CHAR(8) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    correo VARCHAR(150) NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT uq_clientes_dni UNIQUE (dni),
    INDEX idx_clientes_nombre (apellidos, nombres)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS mesas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20) NOT NULL,
    capacidad TINYINT UNSIGNED NOT NULL,
    ubicacion VARCHAR(100) NOT NULL,
    estado ENUM('libre', 'reservada', 'ocupada', 'limpieza', 'mantenimiento')
        NOT NULL DEFAULT 'libre',
    bloqueada_hasta DATETIME NULL,
    observaciones VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT uq_mesas_codigo UNIQUE (codigo),
    CONSTRAINT chk_mesas_capacidad CHECK (capacidad > 0),
    INDEX idx_mesas_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(30) NOT NULL,
    cliente_id INT NOT NULL,
    mesa_id INT NOT NULL,
    usuario_id INT NULL,

    fecha_hora DATETIME NOT NULL,
    hora_limite DATETIME NOT NULL,
    bloqueo_hasta DATETIME NOT NULL,
    cantidad_personas TINYINT UNSIGNED NOT NULL,

    adelanto DECIMAL(10,2) NOT NULL DEFAULT 30.00,
    estado_pago ENUM('pendiente', 'validado', 'rechazado')
        NOT NULL DEFAULT 'pendiente',
    estado ENUM(
        'PENDIENTE_VALIDACION',
        'CONFIRMADA',
        'EN_CURSO',
        'FINALIZADA',
        'EXPIRADA',
        'CANCELADA'
    ) NOT NULL DEFAULT 'PENDIENTE_VALIDACION',

    observaciones VARCHAR(500) NULL,
    fecha_llegada DATETIME NULL,
    fecha_expiracion DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT uq_reservas_codigo UNIQUE (codigo),
    CONSTRAINT chk_reservas_personas CHECK (cantidad_personas > 0),
    CONSTRAINT chk_reservas_adelanto CHECK (adelanto = 30.00),

    CONSTRAINT fk_reservas_cliente
        FOREIGN KEY (cliente_id) REFERENCES clientes(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,

    CONSTRAINT fk_reservas_mesa
        FOREIGN KEY (mesa_id) REFERENCES mesas(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,

    CONSTRAINT fk_reservas_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON UPDATE CASCADE ON DELETE SET NULL,

    INDEX idx_reservas_fecha_estado (fecha_hora, estado),
    INDEX idx_reservas_mesa_fecha (mesa_id, fecha_hora)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT NOT NULL,
    usuario_id INT NULL,

    tipo ENUM('adelanto', 'consumo') NOT NULL DEFAULT 'adelanto',
    metodo_pago ENUM('yape', 'plin', 'efectivo', 'tarjeta') NOT NULL,
    monto DECIMAL(10,2) NOT NULL DEFAULT 30.00,
    numero_operacion VARCHAR(100) NOT NULL,
    voucher VARCHAR(255) NULL,
    estado_validacion ENUM('pendiente', 'validado', 'rechazado')
        NOT NULL DEFAULT 'pendiente',
    observaciones VARCHAR(255) NULL,
    fecha_pago DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT chk_pagos_monto CHECK (monto > 0),

    CONSTRAINT fk_pagos_reserva
        FOREIGN KEY (reserva_id) REFERENCES reservas(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,

    CONSTRAINT fk_pagos_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON UPDATE CASCADE ON DELETE SET NULL,

    INDEX idx_pagos_reserva (reserva_id),
    INDEX idx_pagos_estado (estado_validacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS lista_espera (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NULL,
    dni CHAR(8) NULL,
    telefono VARCHAR(20) NOT NULL,
    cantidad_personas TINYINT UNSIGNED NOT NULL,
    fecha_hora_ingreso DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('esperando', 'notificado', 'asignado', 'cancelado')
        NOT NULL DEFAULT 'esperando',
    mesa_id INT NULL,
    observaciones VARCHAR(500) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT chk_espera_personas CHECK (cantidad_personas > 0),

    CONSTRAINT fk_espera_mesa
        FOREIGN KEY (mesa_id) REFERENCES mesas(id)
        ON UPDATE CASCADE ON DELETE SET NULL,

    INDEX idx_espera_fifo (estado, fecha_hora_ingreso)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO mesas (codigo, capacidad, ubicacion) VALUES
('M01', 2, 'Salón principal'),
('M02', 2, 'Salón principal'),
('M03', 4, 'Salón principal'),
('M04', 4, 'Salón principal'),
('M05', 4, 'Terraza'),
('M06', 6, 'Terraza'),
('M07', 6, 'Salón principal'),
('M08', 8, 'Área familiar');