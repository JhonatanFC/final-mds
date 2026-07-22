# Evidencia funcional del producto final

Fecha de línea base técnica: **21 de julio de 2026**.

## Módulos implementados

| Módulo | Capacidades observables | Rutas principales | Evidencia de código |
|---|---|---|---|
| Reserva pública | Solicitud, validación, adelanto, voucher y confirmación. | `/reservar` | `ReservaController`, `ReservaPublica`, `reservas/crear.php` |
| Recepción | Consulta de reservas, revisión de pago, llegada y voucher. | `/recepcion`, `/recepcion/solicitudes` | `RecepcionController`, `Reserva` |
| Mesas | Alta, edición y eliminación; estado y capacidad. | `/mesas` | `MesaController`, `Mesa`, `admin/mesas.php` |
| Lista de espera | Registro, asignación de mesa y cancelación. | `/lista-espera` | `ListaEsperaController`, `ListaEspera` |
| Productos | Productos, categorías e imagen de producto. | `/productos` | `ProductoController`, `Producto`, `Categoria` |
| Pedidos | Creación y actualización de estado. | `/pedidos` | `PedidoController`, `Pedido` |
| Caja | Cargos pendientes, cobro y resumen diario. | `/caja` | `CajaController`, `Caja` |
| Usuarios | Alta de empleados/usuarios y cambio de estado. | `/usuarios` | `EmpleadoController`, `Empleado`, `Usuario` |
| Gerencia | Indicadores y reportes diarios/semanales. | `/gerencia`, `/reportes` | `GerenciaController`, `ReporteController`, `Reporte` |
| Seguridad | Sesión, roles, CSRF, escape de salida y PDO. | Transversal | `Session`, `Security`, `AuthMiddleware`, `Database` |

## Roles identificados en el producto

| Rol | Operación que sustenta |
|---|---|
| Cliente | Registra una reserva y adjunta el voucher del adelanto. |
| Recepción | Revisa pagos, confirma llegada y administra solicitudes. |
| Mesero | Registra y actualiza pedidos. |
| Cajero/a | Registra cobros y consulta el resumen de caja. |
| Administrador | Mantiene mesas, productos, categorías, usuarios y empleados. |
| Gerente | Consulta indicadores y reportes. |

## Reglas de negocio verificables

| Regla | Fuente técnica |
|---|---|
| El adelanto configurado es S/ 30.00. | `config/config.php` (`RESERVATION_ADVANCE`). |
| La tolerancia de llegada es 20 minutos. | `config/config.php` (`RESERVATION_TOLERANCE_MINUTES`). |
| La reserva bloquea mesa durante 120 minutos. | `config/config.php` (`RESERVATION_DURATION_MINUTES`). |
| El adelanto se considera al calcular el pago final. | `Caja::chargeOrder()` y `CajaController`. |
| Un voucher debe ser revisado por recepción. | `RecepcionController::reviewPayment()` y `Reserva::reviewPayment()`. |

## Arquitectura y datos

- Arquitectura MVC en PHP: `public` → rutas → controlador → modelo → vista.
- Persistencia MySQL/MariaDB mediante PDO.
- Tablas principales: `reservas`, `clientes`, `mesas`, `pagos`, `lista_espera`, `productos`, `categorias`, `pedidos`, `detalle_pedido`, `caja`, `cobros`, `usuarios`, `empleados` y `roles`.
- Script de instalación disponible: `database/restaurante.sql`.

## Evidencia pendiente que debe adjuntar el grupo

- Capturas reales de cada módulo en ejecución.
- Diagramas finales elaborados en CorelDRAW, con título y fuente “Elaboración propia”.
- Archivo Excel de backlog, sprints y métricas.
- Resultados de pruebas firmados o validados por el equipo.
