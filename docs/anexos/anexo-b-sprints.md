# Anexo B. Detalle de Sprints

## Introducción

El desarrollo del Sistema de Gestión de Reservas y Operaciones para el Restaurante D'Barrio Broaster se organizó mediante un enfoque de Scrum adaptado, con el propósito de dividir el trabajo en incrementos funcionales que permitieran construir el producto de manera ordenada y verificable. Cada sprint fue planificado con un objetivo específico, un conjunto de historias de usuario priorizadas y un incremento de software capaz de aportar valor al funcionamiento del sistema.

La secuencia de desarrollo respondió a la dependencia existente entre los diferentes módulos implementados. En primer lugar se estableció la base técnica del proyecto; posteriormente se desarrollaron las funcionalidades relacionadas con reservas y atención al cliente; luego se implementó la gestión de pedidos y productos; finalmente se incorporaron los procesos de caja y las herramientas de consulta para la gerencia.

## Sprint 0. Preparación de la base técnica

### Objetivo

Implementar la infraestructura inicial del sistema y establecer los componentes necesarios para soportar el desarrollo de los módulos funcionales.

### Historias de usuario

- HU-01. Inicio de sesión por roles.
- HU-02. Administración de usuarios.

### Actividades desarrolladas

- Configuración de la estructura inicial del proyecto.
- Organización de la arquitectura MVC.
- Configuración de la conexión con la base de datos.
- Implementación del módulo de autenticación.
- Gestión de sesiones de usuario.
- Administración de usuarios y perfiles de acceso.

### Entregables

- Arquitectura base del sistema.
- Inicio de sesión funcional.
- Administración de usuarios.
- Control de acceso basado en roles.

### Resultado del Sprint Review

Se verificó el correcto funcionamiento del acceso al sistema y la administración de usuarios, estableciendo la base necesaria para continuar con el desarrollo del resto de funcionalidades.

### Sprint Retrospective

Se concluyó que la organización modular del proyecto facilitaría la incorporación de nuevos componentes durante los siguientes incrementos, reduciendo el acoplamiento entre módulos.

---

## Sprint 1. Gestión de reservas y recepción

### Objetivo

Desarrollar las funcionalidades relacionadas con la reserva de mesas, la validación de pagos y la organización inicial de la atención al cliente.

### Historias de usuario

- HU-03. Registro de reservas.
- HU-04. Validación de vouchers.
- HU-05. Gestión de mesas.
- HU-06. Lista de espera.

### Actividades desarrolladas

- Implementación del registro de reservas.
- Carga y validación del voucher de adelanto.
- Confirmación de llegada del cliente.
- Gestión del estado de las mesas.
- Administración de la lista de espera.

### Entregables

- Módulo de reservas.
- Módulo de recepción.
- Gestión de mesas.
- Lista de espera funcional.

### Resultado del Sprint Review

El flujo correspondiente a la reserva de una mesa, la validación del adelanto y la asignación de disponibilidad fue validado satisfactoriamente.

### Sprint Retrospective

Se identificó la conveniencia de fortalecer las validaciones relacionadas con la disponibilidad de mesas y simplificar el proceso de recepción para reducir el tiempo de atención.

---

## Sprint 2. Gestión de productos y pedidos

### Objetivo

Implementar el catálogo de productos y permitir el registro de pedidos realizados por los clientes durante la atención en sala.

### Historias de usuario

- HU-07. Registro de pedidos.
- HU-08. Administración de productos y categorías.

### Actividades desarrolladas

- Gestión del catálogo de productos.
- Administración de categorías.
- Registro de pedidos.
- Actualización del estado de los pedidos.
- Asociación de pedidos con las mesas ocupadas.

### Entregables

- Administración de productos.
- Gestión de categorías.
- Módulo de pedidos.

### Resultado del Sprint Review

Se comprobó que el sistema registraba correctamente los pedidos asociados a cada mesa y actualizaba la información correspondiente durante la operación.

### Sprint Retrospective

Se acordó mejorar la organización visual del módulo de pedidos con el fin de facilitar su utilización por parte del personal operativo.

---

## Sprint 3. Caja y cobros

### Objetivo

Implementar el proceso de cierre de pedidos y el registro de los pagos realizados por los clientes.

### Historias de usuario

- HU-09. Registro de cobros.

### Actividades desarrolladas

- Registro del pago final.
- Aplicación automática del adelanto registrado en la reserva.
- Cálculo del saldo pendiente.
- Registro del método de pago.
- Actualización del estado del pedido.

### Entregables

- Módulo de caja.
- Registro de cobros.
- Cálculo automático del saldo final.

### Resultado del Sprint Review

Se verificó el funcionamiento correcto del proceso de cobro, considerando el descuento automático del adelanto y la generación del monto final correspondiente al consumo realizado.

### Sprint Retrospective

Se propuso reforzar las validaciones relacionadas con la consistencia de la información entre reservas, pedidos y cobros para minimizar posibles errores operativos.

---

## Sprint 4. Dashboard y reportes

### Objetivo

Implementar las funcionalidades orientadas al análisis de la información y al apoyo de la toma de decisiones por parte de la gerencia.

### Historias de usuario

- HU-10. Dashboard y reportes.

### Actividades desarrolladas

- Desarrollo del dashboard principal.
- Implementación de reportes operativos.
- Consolidación de indicadores.
- Integración de consultas para la gerencia.

### Entregables

- Dashboard gerencial.
- Reportes operativos.
- Indicadores consolidados.

### Resultado del Sprint Review

La información generada por el sistema permitió consultar el estado de la operación del restaurante mediante reportes e indicadores organizados para facilitar el análisis administrativo.

### Sprint Retrospective

Se concluyó que la arquitectura implementada facilita futuras ampliaciones del sistema y permite incorporar nuevos módulos sin afectar significativamente los componentes existentes.

## Resumen de la planificación

| Sprint | Objetivo principal | Resultado |
|:-------|:-------------------|:---------|
| Sprint 0 | Preparación de la base técnica y autenticación | Arquitectura MVC, autenticación y gestión de usuarios implementadas. |
| Sprint 1 | Reservas, recepción, mesas y lista de espera | Flujo de reservas completamente operativo. |
| Sprint 2 | Productos y pedidos | Registro y administración de pedidos implementados. |
| Sprint 3 | Caja y cobros | Proceso de pago y cálculo del saldo final implementados. |
| Sprint 4 | Dashboard y reportes | Consulta de indicadores y reportes gerenciales implementada. |

## Conclusión

La planificación mediante Scrum adaptado permitió desarrollar el sistema de forma incremental, asegurando que cada sprint generara un incremento funcional alineado con las necesidades operativas del restaurante. La organización del trabajo facilitó la validación continua del producto, mantuvo la trazabilidad entre los requisitos funcionales y los módulos implementados, y proporcionó una estructura adecuada para la documentación técnica presentada en el informe final.

**Fuente:** Elaboración propia con base en el Plan Integral de Desarrollo de Software.
