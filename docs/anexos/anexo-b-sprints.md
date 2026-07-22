# Anexo B. Detalle de Sprints

## Introducción

El desarrollo del **Sistema de Gestión de Reservas y Operaciones para el Restaurante D'Barrio Broaster** se planificó siguiendo un enfoque de **Scrum adaptado**, organizado en cinco sprints consecutivos. Cada sprint tuvo un objetivo específico, un conjunto de historias de usuario priorizadas y un incremento funcional verificable al finalizar el ciclo.

La planificación permitió desarrollar el sistema de forma incremental, validando progresivamente cada módulo y manteniendo la trazabilidad entre los requisitos del negocio, las historias de usuario y los componentes implementados.

---

# Sprint 0 – Preparación de la base técnica

## Objetivo

Implementar la infraestructura inicial del sistema y establecer los mecanismos de autenticación, autorización y administración de usuarios.

## Historias de usuario

- HU-01. Inicio de sesión por roles.
- HU-02. Administración de usuarios.

## Actividades realizadas

- Configuración inicial del proyecto.
- Organización de la arquitectura MVC.
- Configuración de la conexión con la base de datos.
- Implementación del módulo de autenticación.
- Gestión de sesiones.
- Administración de usuarios y roles.

## Entregables

- Arquitectura base del sistema.
- Login funcional.
- Gestión de usuarios.
- Control de acceso por roles.

## Resultado del Sprint Review

Se validó correctamente el funcionamiento del acceso al sistema y la administración básica de usuarios.

## Retrospectiva

Se identificó la necesidad de mantener una estructura modular desde el inicio para facilitar el desarrollo de los siguientes incrementos.

---

# Sprint 1 – Gestión de reservas y recepción

## Objetivo

Desarrollar los módulos relacionados con las reservas y la atención inicial del cliente.

## Historias de usuario

- HU-03. Registro de reservas.
- HU-04. Validación de vouchers.
- HU-05. Gestión de mesas.
- HU-06. Lista de espera.

## Actividades realizadas

- Registro de reservas.
- Carga y validación de vouchers.
- Administración de mesas.
- Confirmación de llegada.
- Gestión de lista de espera.

## Entregables

- Módulo de reservas.
- Recepción.
- Gestión de mesas.
- Lista de espera.

## Resultado del Sprint Review

El flujo desde la creación de la reserva hasta la asignación de mesa quedó completamente operativo.

## Retrospectiva

Se decidió mejorar las validaciones de disponibilidad y simplificar el proceso de recepción.

---

# Sprint 2 – Productos y pedidos

## Objetivo

Implementar la administración del catálogo y el registro de pedidos realizados por los clientes.

## Historias de usuario

- HU-07. Registro de pedidos.
- HU-08. Administración de productos y categorías.

## Actividades realizadas

- Gestión de productos.
- Gestión de categorías.
- Registro de pedidos.
- Actualización del estado de los pedidos.

## Entregables

- Catálogo de productos.
- Gestión de categorías.
- Módulo de pedidos.

## Resultado del Sprint Review

El sistema permitió registrar correctamente los pedidos asociados a cada mesa.

## Retrospectiva

Se propuso mejorar la organización visual del módulo de pedidos para facilitar su utilización por el personal operativo.

---

# Sprint 3 – Caja y cobros

## Objetivo

Implementar el proceso de cierre de pedidos y registro de pagos.

## Historias de usuario

- HU-09. Cobro del consumo.

## Actividades realizadas

- Registro del pago.
- Aplicación automática del adelanto.
- Cálculo del saldo pendiente.
- Registro del método de pago.

## Entregables

- Módulo de caja.
- Registro de cobros.

## Resultado del Sprint Review

El sistema realizó correctamente el cálculo del monto final considerando el adelanto registrado en la reserva.

## Retrospectiva

Se recomendó reforzar las validaciones para evitar inconsistencias entre reservas, pedidos y pagos.

---

# Sprint 4 – Dashboard y reportes

## Objetivo

Desarrollar las funcionalidades orientadas al seguimiento operativo y apoyo a la toma de decisiones.

## Historias de usuario

- HU-10. Dashboard y reportes.

## Actividades realizadas

- Implementación del dashboard.
- Generación de reportes.
- Consolidación de indicadores.

## Entregables

- Dashboard gerencial.
- Reportes operativos.

## Resultado del Sprint Review

La gerencia pudo consultar información consolidada sobre la operación del restaurante mediante reportes e indicadores.

## Retrospectiva

Se concluyó que la estructura modular implementada durante el proyecto facilita futuras ampliaciones y el mantenimiento del sistema.

---

# Resumen general

| Sprint | Objetivo principal | Estado |
|---------|--------------------|--------|
| Sprint 0 | Base técnica y autenticación | Finalizado |
| Sprint 1 | Reservas, recepción y mesas | Finalizado |
| Sprint 2 | Productos y pedidos | Finalizado |
| Sprint 3 | Caja y cobros | Finalizado |
| Sprint 4 | Dashboard y reportes | Finalizado |

---

**Fuente:** Elaboración propia a partir de la planificación Scrum del proyecto y del Plan Integral de Desarrollo de Software.
