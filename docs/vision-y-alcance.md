# Visión y alcance

## Problema

La gestión manual de reservas, disponibilidad de mesas, pedidos y pagos en el restaurante ficticio D'Barrio Broaster produce duplicidad de información, tiempos de espera y poca visibilidad para la gerencia. RMRS centraliza la operación en una aplicación web con acceso según responsabilidades.

## Objetivo del producto

Brindar al restaurante una plataforma web que permita registrar y atender reservas, coordinar mesas y lista de espera, gestionar pedidos y caja, y consultar indicadores operativos.

## Actores

| Actor | Necesidad principal |
|---|---|
| Cliente | Registrar una reserva y recibir confirmación. |
| Recepción | Confirmar solicitudes, asignar mesas y controlar la espera. |
| Mesero | Consultar y actualizar pedidos. |
| Caja | Registrar pagos y cerrar consumos. |
| Administrador | Mantener mesas, productos y usuarios. |
| Gerente | Consultar dashboard y reportes. |

## Alcance incluido

- autenticación y autorización por rol;
- reservas públicas, confirmación y control de adelanto;
- recepción, mesas y lista de espera;
- pedidos y productos;
- caja y pagos;
- usuarios y empleados;
- reportes y dashboard gerencial.

## Fuera de alcance actual

- integración real con pasarela de pagos;
- notificaciones por SMS o correo;
- aplicación móvil nativa;
- facturación electrónica integrada con SUNAT;
- pruebas automatizadas y despliegue continuo.

## Reglas del negocio implementadas

- adelanto de reserva: S/ 30.00;
- tolerancia de llegada: 20 minutos;
- duración de bloqueo de mesa: 120 minutos;
- el adelanto se descuenta del consumo final.
