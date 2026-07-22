# Matriz de trazabilidad

| Requisito | Historia | Componente principal | Prueba sugerida |
|---|---|---|---|
| RF-01 Autenticación | HU-01 | `AuthController`, `Session`, `AuthMiddleware` | CP-01, CP-02 |
| RF-02 Usuarios y roles | HU-02 | `EmpleadoController`, `Usuario`, `Empleado` | CP-03 |
| RF-03 Crear reserva | HU-03 | `ReservaController`, `ReservaPublica` | CP-04, CP-05 |
| RF-04 Atender solicitud | HU-04 | `RecepcionController`, `Reserva` | CP-06 |
| RF-05 Gestionar mesas | HU-05 | `MesaController`, `Mesa` | CP-07 |
| RF-06 Lista de espera | HU-06 | `ListaEsperaController`, `ListaEspera` | CP-08 |
| RF-07 Gestionar pedidos | HU-07 | `PedidoController`, `Pedido` | CP-09 |
| RF-08 Gestionar productos | HU-08 | `ProductoController`, `Producto`, `Categoria` | CP-10 |
| RF-09 Registrar pago | HU-09 | `CajaController`, `Caja` | CP-11, CP-12 |
| RF-10 Adjuntar adelanto | HU-10 | `ReservaPublica`, vista de reserva | CP-13 |
| RF-11 Dashboard | HU-11 | `GerenciaController`, `Reporte` | CP-14 |
| RF-12 Reportes | HU-12 | `ReporteController`, `Reporte` | CP-15 |

La definición detallada de los casos CP-01 a CP-15 está en [calidad-y-pruebas.md](calidad-y-pruebas.md).
