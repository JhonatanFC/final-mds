# Anexo A. Product Backlog

## Introducción

El Product Backlog constituye el registro de los requisitos funcionales priorizados para el desarrollo del Sistema de Gestión de Reservas y Operaciones del Restaurante D'Barrio Broaster. Su elaboración permitió organizar el trabajo del equipo siguiendo un enfoque incremental basado en Scrum adaptado, estableciendo el orden de implementación de cada módulo de acuerdo con las necesidades del negocio y las dependencias existentes entre las funcionalidades.

Cada historia de usuario representa una necesidad identificada durante el diagnóstico organizacional y mantiene correspondencia con los módulos implementados en el sistema, el diseño arquitectónico, la matriz de trazabilidad y los casos de prueba documentados en el informe final.

## Historias de usuario priorizadas

| ID | Historia de usuario | Prioridad | Sprint | Estado |
|:--|:--|:--:|:--:|:--:|
| HU-01 | Como usuario, deseo iniciar sesión para acceder únicamente a las funciones correspondientes a mi rol dentro del sistema. | Alta | Sprint 0 | Finalizado |
| HU-02 | Como administrador, deseo gestionar usuarios y roles para mantener el control de acceso de la aplicación. | Alta | Sprint 0 | Finalizado |
| HU-03 | Como cliente, deseo registrar una reserva adjuntando el comprobante del adelanto para solicitar una mesa. | Alta | Sprint 1 | Finalizado |
| HU-04 | Como recepcionista, deseo validar el voucher y confirmar la llegada del cliente para habilitar la atención. | Alta | Sprint 1 | Finalizado |
| HU-05 | Como administrador, deseo administrar las mesas y su disponibilidad para organizar correctamente la atención. | Alta | Sprint 1 | Finalizado |
| HU-06 | Como recepcionista, deseo gestionar la lista de espera para atender ordenadamente a los clientes cuando no existan mesas disponibles. | Media | Sprint 1 | Finalizado |
| HU-07 | Como mesero, deseo registrar y actualizar pedidos para controlar el consumo realizado por cada mesa. | Alta | Sprint 2 | Finalizado |
| HU-08 | Como administrador, deseo administrar productos y categorías para mantener actualizado el catálogo del restaurante. | Alta | Sprint 2 | Finalizado |
| HU-09 | Como cajero, deseo registrar el cobro del consumo aplicando automáticamente el adelanto realizado durante la reserva. | Alta | Sprint 3 | Finalizado |
| HU-10 | Como gerente, deseo consultar indicadores y reportes para apoyar la toma de decisiones operativas y administrativas. | Media | Sprint 4 | Finalizado |

## Priorización del Product Backlog

La priorización se realizó considerando el valor que cada funcionalidad aporta al proceso operativo del restaurante y las dependencias técnicas existentes entre los diferentes módulos del sistema. En consecuencia, las funcionalidades relacionadas con autenticación, administración de usuarios y control de acceso fueron implementadas inicialmente, ya que constituyen la base para el funcionamiento del resto de componentes.

Posteriormente se desarrollaron los módulos encargados de la gestión de reservas, recepción, mesas y lista de espera, permitiendo controlar el flujo inicial de atención al cliente. Una vez consolidada esta etapa, se incorporaron las funcionalidades destinadas a la administración del catálogo de productos y al registro de pedidos, continuando con el módulo de caja para el procesamiento de pagos y finalizando con el desarrollo del dashboard y los reportes gerenciales.

Esta planificación permitió entregar incrementos funcionales al finalizar cada sprint, facilitando la validación continua del sistema y manteniendo la trazabilidad entre los requisitos del negocio y los componentes implementados.

## Relación con el proyecto

Las historias de usuario incluidas en este Product Backlog se encuentran directamente relacionadas con el plan de aplicación de Scrum descrito en la Sección 2 del informe, el diseño modular presentado en la Sección 4 y la matriz de trazabilidad desarrollada en el Anexo G. De esta manera, cada requisito funcional puede seguirse desde su definición inicial hasta su implementación dentro del sistema, garantizando la consistencia entre la documentación y el producto desarrollado.

**Fuente:** Elaboración propia.
