# Anexo F. Diccionario de datos resumido

## Introducción

El presente diccionario de datos resume las principales entidades utilizadas por el Sistema de Gestión de Reservas y Operaciones para el Restaurante D'Barrio Broaster. Su finalidad es documentar la estructura lógica de la información administrada por el sistema, facilitando la comprensión de las relaciones existentes entre los diferentes módulos implementados.

Cada entidad representa un conjunto de datos necesario para soportar los procesos de reservas, atención al cliente, gestión de pedidos, cobros, administración y generación de reportes. Esta información complementa el modelo relacional presentado en el Documento de Diseño de Software y mantiene correspondencia con los módulos descritos en la Sección 4. :contentReference[oaicite:1]{index=1}

## Diccionario de datos

| Entidad | Campos principales | Propósito | Relación relevante |
|----------|--------------------|-----------|--------------------|
| **clientes** | id, nombres, apellidos, dni, teléfono | Identifica al solicitante de una reserva. | Un cliente puede registrar una o varias reservas. |
| **reservas** | id, cliente_id, mesa_id, fecha, hora, personas, estado | Controla el proceso de reserva y la atención del cliente. | Se relaciona con clientes, mesas y pagos. |
| **pagos** | reserva_id, método, monto, voucher, estado | Registra el adelanto realizado por el cliente y su validación. | Cada pago corresponde a una reserva registrada. |
| **mesas** | id, número, capacidad, ubicación, estado | Administra la disponibilidad de las mesas del restaurante. | Una mesa puede estar asociada a una reserva y posteriormente a un pedido. |
| **lista_espera** | id, cliente, personas, hora_ingreso, estado | Gestiona los clientes que esperan disponibilidad de una mesa. | Se genera cuando no existen mesas disponibles para una nueva reserva o atención. |
| **categorias** | id, nombre, descripción | Clasifica los productos ofrecidos por el restaurante. | Una categoría agrupa múltiples productos. |
| **productos** | id, categoria_id, nombre, precio, estado | Administra el catálogo de productos disponibles para la venta. | Cada producto pertenece a una categoría y puede formar parte de varios pedidos. |
| **pedidos** | id, mesa_id, usuario_id, fecha, total, estado | Registra el consumo realizado por una mesa durante la atención. | Se relaciona con mesas y con el detalle de pedidos. |
| **detalle_pedidos** | pedido_id, producto_id, cantidad, precio_unitario, subtotal | Almacena el detalle de cada producto solicitado dentro de un pedido. | Depende directamente de pedidos y productos. |
| **caja** | id, pedido_id, subtotal, adelanto, total_pagar, método_pago, fecha | Consolida la información económica correspondiente al cierre de una venta. | Se genera a partir del pedido registrado y del adelanto asociado a la reserva. |
| **usuarios** | id, nombres, usuario, contraseña, rol, estado | Administra las cuentas de acceso al sistema. | Controla la autenticación y la autorización mediante roles. |

**Tabla 18. Diccionario de datos resumido.**

**Fuente:** Elaboración propia.

## Observación

El presente diccionario resume las entidades principales utilizadas durante el desarrollo del sistema y mantiene correspondencia con el modelo relacional descrito en el Documento de Diseño de Software. La estructura presentada facilita la comprensión de la organización de los datos y de las relaciones existentes entre los diferentes módulos funcionales implementados en la aplicación. 
