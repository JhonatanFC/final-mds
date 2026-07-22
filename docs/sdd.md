# Documento de Diseño de Software (SDD)

Este documento describe el diseño técnico del producto final RMRS para el restaurante ficticio D'Barrio Broaster. Complementa el plan de gestión y el plan de calidad, y permite rastrear las necesidades de negocio hasta los componentes implementados.

## Arquitectura

RMRS implementa el patrón Modelo-Vista-Controlador (MVC) en tres capas lógicas:

```text
Navegador → Router → Middleware → Controller → Model/PDO → MySQL/MariaDB
                                            ↘ View → HTML/CSS/JS
```

La presentación se resuelve con vistas PHP/HTML, la lógica de aplicación reside en controladores y el acceso a datos se concentra en modelos que usan PDO. El despliegue académico es monolítico: Apache, PHP y MySQL/MariaDB se ejecutan en un mismo host XAMPP.

## Principios de diseño

- Responsabilidad única: cada controlador atiende un módulo de negocio.
- Separación de responsabilidades: las vistas no acceden a modelos ni a la base de datos.
- Acceso centralizado a datos: PDO evita conexiones duplicadas.
- Modularidad: los componentes se organizan por módulo y responsabilidad.

## Diseño modular

| Módulo | Objetivo | Reglas y validaciones clave | Seguridad |
|---|---|---|---|
| Login | Autenticar usuarios y crear sesión. | Credenciales válidas y sesión activa. | Hash de contraseña y sesión. |
| Usuarios | Gestionar cuentas y roles. | Rol único; usuario no duplicado. | Solo administrador. |
| Reservas | Registrar reserva pública con adelanto. | Fecha/hora, capacidad y voucher válidos. | Validación de entrada y archivo. |
| Recepción | Revisar pagos y confirmar llegada. | Solo solicitudes pendientes son revisables. | Rol autorizado y CSRF. |
| Mesas | Mantener disponibilidad del salón. | Estados libres, reservadas, ocupadas o limpieza. | Rol administrador/recepción. |
| Lista de espera | Registrar y asignar clientes sin mesa. | Orden FIFO y mesa disponible. | Rol recepción. |
| Productos/Categorías | Mantener catálogo. | Precio, categoría y estado obligatorios. | Rol administrador. |
| Pedidos | Registrar consumo por mesa. | Mesa válida, detalle y total calculado. | Rol mesero/administrador. |
| Caja/Cobros | Cerrar pedido y registrar pago. | Saldo = total − adelanto validado. | Consultas preparadas y monto válido. |
| Dashboard/Reportes | Consultar indicadores y ventas. | Filtros y agregados por fecha. | Rol gerente/administrador. |

## Modelo de datos y persistencia

El modelo relacional utiliza claves primarias autoincrementales y relaciones entre `clientes`, `reservas`, `pagos`, `mesas`, `lista_espera`, `productos`, `categorias`, `pedidos`, `detalle_pedido`, `caja`, `cobros`, `usuarios`, `empleados` y `roles`.

PDO centraliza las operaciones CRUD parametrizadas. Las operaciones que modifican más de una tabla, como el cierre de pedido y cobro, deben conservar consistencia mediante transacciones.

## Componentes técnicos

| Componente | Responsabilidad |
|---|---|
| `Controllers` | Orquestan petición, autorización, modelos y vistas. |
| `Models` | Persistencia y reglas de dominio mediante PDO. |
| `Views` | Renderizan HTML sin lógica de negocio. |
| `Router` | Resuelve rutas hacia controlador y acción. |
| `Session` | Mantiene autenticación y rol entre solicitudes. |
| `AuthMiddleware` | Protege acciones por sesión y rol. |
| `Security` | Gestiona token CSRF y escape de salida. |
| `Database` | Expone conexión PDO centralizada. |

## Navegación, seguridad y evolución

El recorrido principal es: Cliente → Reserva → Voucher → Recepción → Mesa → Pedido → Caja → Reporte. Cada transición representa un cambio persistido de estado.

Los controles de seguridad incluyen consultas preparadas con PDO, escape de salida para XSS, token CSRF, autenticación de sesión, autorización basada en roles y exclusión de credenciales/vouchers del repositorio.

La evolución futura puede incluir una SPA, caché de reportes, pruebas automatizadas, integración continua y separación física de servicios cuando el volumen de usuarios lo justifique.
