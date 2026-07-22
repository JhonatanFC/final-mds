USE restaurante;

INSERT IGNORE INTO usuarios (rol_id, nombres, correo, password, estado)
SELECT id, 'Recepción RMRS', 'recepcion@restaurant.com', MD5('Recepcion2026!'), 1
FROM roles
WHERE nombre = 'Recepcion';

INSERT IGNORE INTO usuarios (rol_id, nombres, correo, password, estado)
SELECT id, 'Mesero RMRS', 'mesero@restaurant.com', MD5('Mesero2026!'), 1
FROM roles
WHERE nombre = 'Mesero';

INSERT IGNORE INTO usuarios (rol_id, nombres, correo, password, estado)
SELECT id, 'Cajera RMRS', 'caja@restaurant.com', MD5('Caja2026!'), 1
FROM roles
WHERE nombre = 'Cajera';

INSERT IGNORE INTO usuarios (rol_id, nombres, correo, password, estado)
SELECT id, 'Gerente RMRS', 'gerente@restaurant.com', MD5('Gerente2026!'), 1
FROM roles
WHERE nombre = 'Gerente';