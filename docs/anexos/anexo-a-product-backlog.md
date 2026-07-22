# Anexo A. Product Backlog resumido

El Product Backlog reúne las historias de usuario priorizadas para el desarrollo del **Sistema de Gestión de Reservas y Operaciones del Restaurante D'Barrio Broaster**.

Las historias se distribuyeron en cinco sprints, considerando la dependencia entre los módulos y el valor que cada incremento aporta al funcionamiento del sistema. El estado presentado corresponde al producto documentado en el informe final.

## Product Backlog

| ID | Historia de usuario | Prioridad | Sprint | Estado |
|---|---|---:|---:|---|
| HU-01 | Como usuario, quiero iniciar sesión según mi rol para acceder únicamente a las funciones que me corresponden. | Alta | Sprint 0 | Terminado |
| HU-02 | Como administrador, quiero gestionar usuarios y empleados para mantener actualizadas sus cuentas y roles de acceso. | Alta | Sprint 0 | Terminado |
| HU-03 | Como cliente, quiero registrar una reserva con adelanto para solicitar una mesa y adjuntar la evidencia del pago. | Alta | Sprint 1 | Terminado |
| HU-04 | Como recepcionista, quiero revisar los pagos y confirmar la llegada del cliente para controlar correctamente el estado de cada reserva. | Alta | Sprint 1 | Terminado |
| HU-05 | Como administrador, quiero gestionar las mesas para controlar su capacidad, ubicación y estado de disponibilidad. | Alta | Sprint 1 | Terminado |
| HU-06 | Como recepcionista, quiero gestionar la lista de espera para registrar y atender ordenadamente a los clientes que no disponen de una mesa inmediata. | Media | Sprint 1 | Terminado |
| HU-07 | Como mesero, quiero registrar y actualizar pedidos para controlar el consumo realizado en cada mesa. | Alta | Sprint 2 | Terminado |
| HU-08 | Como administrador, quiero gestionar productos y categorías para mantener actualizado el catálogo utilizado en los pedidos. | Alta | Sprint 2 | Terminado |
| HU-09 | Como cajero, quiero registrar el cobro aplicando el adelanto de la reserva para calcular correctamente el saldo final del pedido. | Alta | Sprint 3 | Terminado |
| HU-10 | Como gerente, quiero consultar el dashboard y los reportes para conocer los indicadores operativos y apoyar la toma de decisiones. | Media | Sprint 4 | Terminado |

## Distribución por sprint

### Sprint 0: Base técnica y control de acceso

Incluye las historias **HU-01** y **HU-02**. Su propósito fue establecer la arquitectura base del sistema, la autenticación, la gestión de usuarios y el control de acceso según roles.

### Sprint 1: Reservas y recepción

Incluye las historias **HU-03**, **HU-04**, **HU-05** y **HU-06**. Este incremento permitió registrar reservas, revisar adelantos, confirmar la llegada de clientes, administrar mesas y controlar la lista de espera.

### Sprint 2: Productos y pedidos

Incluye las historias **HU-07** y **HU-08**. Su objetivo fue implementar la gestión del catálogo de productos y categorías, así como el registro y actualización de pedidos asociados a las mesas.

### Sprint 3: Caja y cobros

Incluye la historia **HU-09**. Este incremento permitió registrar el pago final del consumo, aplicar el adelanto previamente validado y calcular el saldo correspondiente.

### Sprint 4: Dashboard y reportes

Incluye la historia **HU-10**. Su propósito fue consolidar la información operativa del sistema mediante indicadores y reportes orientados a la gerencia.

## Relación con la documentación

El detalle de los objetivos, incrementos, resultados de Sprint Review y acciones de mejora de cada sprint se encuentra en el documento [Anexo B. Detalle de sprints](./anexo-b-sprints.md).

La correspondencia entre requisitos, historias de usuario, componentes del sistema, casos de prueba y evidencias se desarrolla en el documento [Anexo G. Matriz de trazabilidad](./anexo-g-trazabilidad.md).

---

**Fuente:** Elaboración propia a partir del Product Backlog del proyecto.
