# Anexo G. Matriz de trazabilidad

## Introducción

La matriz de trazabilidad establece la relación entre los requisitos funcionales definidos durante el análisis, las historias de usuario priorizadas en el Product Backlog, los componentes desarrollados dentro del sistema, los casos de prueba ejecutados y las evidencias generadas durante la implementación.

Este instrumento permite verificar que cada requisito planteado en el proyecto ha sido desarrollado, probado y documentado, garantizando la consistencia entre las diferentes etapas del proceso de ingeniería de software. Asimismo, facilita el seguimiento de los entregables y proporciona un mecanismo de control para validar que las funcionalidades implementadas responden a las necesidades identificadas durante el levantamiento de requisitos.

## Matriz de trazabilidad

| Requisito funcional | Historia de usuario | Componente implementado | Caso de prueba | Evidencia |
|----------------------|---------------------|--------------------------|----------------|-----------|
| **RF-01. Autenticación** | **HU-01** | AuthController, Session, Middleware | **CP-01, CP-02** | Inicio de sesión y control de acceso por roles. |
| **RF-02. Gestión de reservas** | **HU-03** | ReservaController, ReservaPublica | **CP-03, CP-04** | Registro de reservas y confirmación del proceso. |
| **RF-03. Recepción** | **HU-04** | RecepcionController, Reserva | **CP-05, CP-06** | Validación del voucher y confirmación de llegada del cliente. |
| **RF-04. Gestión de mesas y lista de espera** | **HU-05, HU-06** | Mesa, ListaEspera | **CP-07** | Administración de capacidad y disponibilidad de mesas. |
| **RF-05. Gestión de pedidos** | **HU-07** | PedidoController, Pedido | **CP-08** | Registro y seguimiento de pedidos activos. |
| **RF-06. Caja y cobros** | **HU-09** | CajaController, Caja | **CP-09** | Cálculo del saldo pendiente y registro del cobro final. |
| **RF-07. Reportes gerenciales** | **HU-10** | Reporte, GerenciaController | **CP-10** | Dashboard e informes gerenciales generados correctamente. |

**Tabla 19. Matriz de trazabilidad.**

**Fuente:** Elaboración propia.

## Observación

La matriz de trazabilidad evidencia la correspondencia entre los requisitos funcionales, las historias de usuario, los componentes implementados y los casos de prueba ejecutados durante el desarrollo del sistema. Esta relación asegura que cada funcionalidad desarrollada puede ser identificada, validada y respaldada mediante evidencia técnica, fortaleciendo la calidad de la documentación y la verificabilidad del producto final.
