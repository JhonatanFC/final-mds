# Anexo E. Especificación de casos de uso

## Introducción

La presente especificación resume los principales casos de uso del Sistema de Gestión de Reservas y Operaciones para el Restaurante D'Barrio Broaster. Cada caso de uso representa una funcionalidad priorizada durante el desarrollo del proyecto y describe, de forma resumida, el actor involucrado, la condición necesaria para su ejecución, el flujo principal de interacción y el resultado esperado.

Esta especificación mantiene correspondencia con los diagramas de casos de uso presentados en el Anexo C, con el Product Backlog del Anexo A y con la matriz de trazabilidad del Anexo G, garantizando la consistencia entre los requisitos funcionales y las funcionalidades implementadas.

## Especificación resumida de casos de uso

| Caso de uso | Actor | Precondición | Flujo principal | Resultado |
|--------------|-------|--------------|-----------------|-----------|
| **CU-01. Registrar reserva** | Cliente | Mesa con capacidad disponible. | Completa los datos de la reserva, adjunta el comprobante de pago (voucher) y envía la solicitud. | La reserva queda registrada con estado pendiente y el adelanto asociado al proceso de validación. |
| **CU-02. Revisar pago** | Recepcionista | Existe una solicitud de reserva pendiente. | Consulta el voucher enviado por el cliente, verifica la información y acepta o rechaza el pago registrado. | El estado del pago se actualiza según el resultado de la validación realizada. |
| **CU-03. Confirmar llegada** | Recepcionista | La reserva ha sido validada y el cliente se encuentra presente. | Localiza la reserva correspondiente y confirma la llegada del cliente para iniciar la atención. | La mesa cambia a estado operativo y la reserva pasa al proceso de atención. |
| **CU-04. Registrar pedido** | Mesero | La mesa se encuentra ocupada y existen productos disponibles en el sistema. | Selecciona los productos solicitados, registra las cantidades y confirma el pedido. | El pedido queda registrado y se calcula el importe correspondiente al consumo. |
| **CU-05. Cobrar pedido** | Cajero(a) | El pedido se encuentra listo para su cobro. | Registra el método de pago utilizado por el cliente y aplica automáticamente el adelanto realizado durante la reserva. | El cobro queda registrado y la información de caja es actualizada. |
| **CU-06. Consultar reporte** | Gerente | El usuario ha iniciado sesión con un rol autorizado. | Selecciona el período de consulta y visualiza los indicadores y reportes disponibles. | El sistema presenta la información consolidada para apoyar la toma de decisiones. |

**Tabla 17. Especificación resumida de casos de uso.**

**Fuente:** Elaboración propia.

## Observación

La especificación presentada resume los casos de uso principales implementados en el sistema y sirve como referencia para comprender la interacción entre los diferentes actores y las funcionalidades desarrolladas. Cada caso de uso mantiene relación directa con los módulos implementados, los diagramas del Anexo C y los requisitos funcionales definidos durante la planificación del proyecto.
