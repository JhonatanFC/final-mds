# Product Backlog

Escala de prioridad: **Alta**, **Media**, **Baja**. El estado se determinó por evidencia presente en el código al 21 de julio de 2026.

| ID | Historia de usuario | Prioridad | Sprint | Estado | Evidencia |
|---|---|---:|---:|---|---|
| HU-01 | Como usuario, quiero iniciar sesión para acceder según mi rol. | Alta | 0 | Terminado | `AuthController.php`, `AuthMiddleware.php` |
| HU-02 | Como administrador, quiero gestionar usuarios y empleados. | Alta | 0 | Terminado | `EmpleadoController.php`, `admin/usuarios.php` |
| HU-03 | Como cliente, quiero registrar una reserva indicando fecha, hora y personas. | Alta | 1 | Terminado | `ReservaController.php`, `reservas/crear.php` |
| HU-04 | Como recepción, quiero revisar y confirmar solicitudes de reserva. | Alta | 1 | Terminado | `RecepcionController.php`, `recepcion/solicitudes.php` |
| HU-05 | Como administrador, quiero gestionar mesas y su disponibilidad. | Alta | 1 | Terminado | `MesaController.php`, `admin/mesas.php` |
| HU-06 | Como recepción, quiero gestionar una lista de espera. | Media | 1 | Terminado | `ListaEsperaController.php`, `recepcion/lista_espera.php` |
| HU-07 | Como mesero, quiero registrar y consultar pedidos. | Alta | 2 | Terminado | `PedidoController.php`, `meseros/pedidos.php` |
| HU-08 | Como administrador, quiero mantener productos y categorías. | Alta | 2 | Terminado | `ProductoController.php`, `admin/productos.php` |
| HU-09 | Como caja, quiero registrar el pago y cerrar el consumo. | Alta | 3 | Terminado | `CajaController.php`, `caja/index.php` |
| HU-10 | Como gerente, quiero consultar dashboard y reportes para tomar decisiones. | Media | 4 | Terminado | `GerenciaController.php`, `ReporteController.php`, vistas de gerencia |
| HU-11 | Como cliente, quiero recibir notificaciones por correo o SMS. | Baja | Futuro | Pendiente | No implementado |
| HU-12 | Como administrador, quiero pruebas automáticas en cada cambio. | Media | Futuro | Pendiente | No existe suite automatizada |

## Criterios de aceptación resumidos

- HU-01: credenciales válidas crean sesión; un rol no autorizado no accede a módulos restringidos.
- HU-03: no se guarda una reserva inválida; una reserva válida genera confirmación.
- HU-04: recepción puede consultar el detalle y cambiar el estado permitido.
- HU-05: se pueden crear y actualizar mesas sin duplicar su identificador.
- HU-07: el pedido conserva sus productos, cantidades y estado.
- HU-09: el total y el adelanto se reflejan en el saldo final.
- HU-10: únicamente gerencia autorizada consulta indicadores y reportes agregados.
