# Anexo F. Diccionario de datos resumido

| Entidad | Propósito | Campos representativos |
|---|---|---|
| Usuario | Acceso y roles | id, nombre, correo, contraseña, rol |
| Reserva | Reserva y adelanto | id, cliente, fecha, hora, personas, estado |
| Mesa | Disponibilidad del salón | id, número, capacidad, estado |
| Pedido | Consumo del cliente | id, mesa, usuario, total, estado |
| Producto | Carta del restaurante | id, nombre, precio, categoría, stock |
| Venta | Cobro y comprobante | id, pedido, total, método de pago, fecha |

El modelo de datos y sus relaciones se presentan en el [SDD](../sdd.md).
