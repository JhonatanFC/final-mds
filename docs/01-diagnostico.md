# SECCIÓN 1. DIAGNÓSTICO DE LA ORGANIZACIÓN

## 1.1 Presentación de la organización

D'Barrio Broaster es un restaurante ficticio de comida peruana contemporánea, definido para este proyecto académico, ubicado en el distrito de El Tambo, Huancayo. Inició operaciones en 2019 y cuenta con 24 trabajadores distribuidos entre administración, recepción, salón, cocina, caja y limpieza. Atiende un promedio de 85 clientes por día laboral y 145 clientes por día durante fines de semana, con mayor demanda entre las 12:30 y las 15:30 horas, franja que concentra el mayor riesgo operativo por saturación de mesas y tiempos de espera. :contentReference[oaicite:0]{index=0}

La misión de la organización es brindar una experiencia gastronómica andina confiable, cercana y oportuna mediante una atención coordinada entre sala, cocina y caja. Su visión es consolidarse como un restaurante de referencia regional, reconocido por la calidad de su servicio y por el uso responsable de tecnología para atender y conocer mejor a sus clientes.

Desde la perspectiva de ingeniería de software, esta visión se traduce en un requisito no funcional explícito de trazabilidad de datos: cada reserva, pedido y cobro debe quedar registrado de forma consultable, permitiendo que la gerencia sustente sus decisiones operativas y comerciales con información consolidada en lugar de estimaciones informales. :contentReference[oaicite:1]{index=1}

### Tabla 1. Procesos core relevantes

| Proceso core | Situación actual simulada | Necesidad de soporte |
|--------------|---------------------------|----------------------|
| Reserva y recepción | Las solicitudes se realizan mediante llamadas telefónicas, redes sociales y aplicaciones de mensajería. | Registrar, validar y confirmar reservas con trazabilidad durante todo el proceso. |
| Atención en sala | La disponibilidad de mesas se comunica verbalmente entre recepción y el personal de atención. | Visualizar en tiempo real el estado de las mesas, la lista de espera y los pedidos asociados. |
| Cobro | El adelanto de la reserva y el consumo final se consolidan manualmente antes del cierre de la venta. | Calcular automáticamente el saldo pendiente, registrar el cobro y generar la evidencia correspondiente. |
| Gestión | La información administrativa se consolida mediante hojas de cálculo independientes. | Consultar indicadores, reportes e información de ventas para apoyar la toma de decisiones. |

**Tabla 1. Procesos core relevantes. Fuente: Elaboración propia.**

La lectura conjunta de estos cuatro procesos evidencia un patrón común: la información existe, pero se encuentra fragmentada en diferentes canales que no comparten datos entre sí. Como consecuencia, la disponibilidad de mesas, la validación de reservas, la atención de clientes, el registro de pedidos y la consolidación de los cobros dependen de verificaciones manuales, incrementando la probabilidad de errores, duplicidad de registros y retrasos durante las horas de mayor demanda.

A partir de este diagnóstico se identifica la necesidad de implementar un sistema de información que integre los procesos operativos del restaurante dentro de una única plataforma, permitiendo mantener la trazabilidad de las reservas, administrar la disponibilidad de mesas, registrar los pedidos, controlar el proceso de caja y generar información consolidada para apoyar la gestión administrativa. :contentReference[oaicite:2]{index=2}
## 1.2 Análisis del contexto organizacional

### a. Cultura organizacional

La organización presenta una cultura de servicio orientada al cliente y una toma de decisiones centralizada en la gerencia. El personal de recepción y caja comparte información durante el turno, pero no cuenta con una fuente única de datos, lo que genera dependencia de la comunicación verbal y del conocimiento tácito de cada colaborador.

La dirección valora los procedimientos cuando estos reducen reclamos y tiempos de espera; por ello, acepta la documentación mínima necesaria para capacitar y controlar el uso del sistema, sin exigir artefactos formales adicionales que no aporten valor operativo directo. Este rasgo cultural condiciona el diseño de las interfaces del sistema (Sección 4.7), las cuales priorizan la simplicidad, la facilidad de uso y la retroalimentación inmediata para los usuarios operativos. :contentReference[oaicite:0]{index=0}

### b. Madurez del equipo de TI

El restaurante no dispone de un área de Tecnologías de la Información propia. El soporte relacionado con equipos informáticos y conectividad se realiza mediante servicios externos, mientras que los usuarios operativos poseen conocimientos básicos sobre el uso de navegadores web, hojas de cálculo y aplicaciones móviles.

El equipo de desarrollo del proyecto asume la configuración del entorno de desarrollo, el modelado de datos, la implementación del sistema y la ejecución de las pruebas correspondientes.

Esta condición hace necesario trabajar mediante entregas pequeñas, validaciones frecuentes y documentación clara, permitiendo que los usuarios representativos participen en la revisión de cada incremento desarrollado. Este escenario constituye uno de los principales argumentos para la selección de Scrum adaptado como modelo de proceso, debido a que facilita incorporar retroalimentación continua durante todo el desarrollo del proyecto. :contentReference[oaicite:1]{index=1}

### c. Naturaleza del producto

El producto corresponde a una aplicación web transaccional con un nivel de criticidad medio–alto, debido a que administra información relacionada con reservas, disponibilidad de mesas, datos personales de clientes, adelantos, vouchers, pedidos y procesos de cobro.

Un error en cualquiera de estos procesos puede provocar conflictos en la asignación de mesas, pérdidas económicas, inconsistencias en los registros de caja o una experiencia negativa para los clientes.

Por este motivo, las reglas relacionadas con la capacidad de las mesas, el estado de las reservas, los cálculos de pago y la autorización por roles deben verificarse antes de la entrega de cada incremento funcional.

Esta criticidad también justifica la priorización de las características de **adecuación funcional**, **fiabilidad** y **seguridad** dentro del perfil de calidad definido para el proyecto conforme al modelo ISO/IEC 25010. :contentReference[oaicite:2]{index=2}

### d. Restricciones de negocio

Las principales restricciones consideradas durante el desarrollo del proyecto se resumen en la siguiente tabla.

| Restricción | Supuesto considerado | Implicación para el proyecto |
|-------------|----------------------|------------------------------|
| Plazo | 16 semanas académicas distribuidas en cinco incrementos. | Priorizar los módulos esenciales antes de implementar mejoras complementarias. |
| Presupuesto | S/ 2 200 estimados. | Utilizar herramientas de software libre y un entorno de despliegue local. |
| Disponibilidad de usuarios | Validaciones realizadas fuera de los horarios de mayor demanda. | Programar Sprint Review breves y orientadas a la validación funcional. |
| Datos sensibles | Información de clientes, pagos y vouchers. | Aplicar autenticación, autorización por roles, protección CSRF y control de acceso a la información. |

**Tabla 2. Restricciones de negocio. Fuente: Elaboración propia.**

Las restricciones identificadas constituyen criterios transversales para todas las decisiones técnicas del proyecto. Cualquier modificación relacionada con el alcance, la arquitectura o el desarrollo del sistema debe mantener coherencia con estas condiciones.

En particular, la protección de los datos sensibles motiva la incorporación de mecanismos de autenticación, autorización basada en roles, validación de sesiones, protección CSRF y exclusión de información confidencial del repositorio del proyecto, aspectos desarrollados posteriormente en el diseño de seguridad del sistema. :contentReference[oaicite:3]{index=3}
## 1.3 Identificación de la necesidad

El problema central de la organización es la falta de integración entre los procesos de reserva, atención en recepción, gestión de mesas, registro de pedidos y proceso de cobro. Cuando estas actividades se administran mediante canales independientes, el personal invierte tiempo verificando información, se incrementa el riesgo de duplicidad de registros y la gerencia no dispone de indicadores consolidados para la toma de decisiones.

La necesidad identificada consiste en implementar un sistema web que permita integrar todos los procesos operativos del restaurante dentro de una única plataforma, convirtiendo cada operación en información trazable y disponible para los diferentes usuarios autorizados. De esta manera, la coordinación verbal entre recepción, salón, caja y administración es reemplazada por un registro centralizado que refleja en tiempo real el estado de cada proceso. :contentReference[oaicite:0]{index=0}

Como resultado del diagnóstico organizacional, se establecen los siguientes requisitos funcionales de alto nivel para el sistema:

- Reserva pública con registro de datos del cliente, fecha, horario, cantidad de personas y comprobante del adelanto.
- Módulo de recepción para validar pagos, confirmar la llegada del cliente, consultar solicitudes y visualizar los vouchers registrados.
- Gestión de mesas considerando capacidad, ubicación física y estado de disponibilidad.
- Administración de lista de espera para clientes cuando no exista disponibilidad inmediata de mesas.
- Gestión del catálogo de productos y categorías utilizadas durante la atención.
- Registro de pedidos con detalle de productos, cantidades, estados y cálculo automático del importe.
- Módulo de caja y cobros que permita aplicar automáticamente el descuento correspondiente al adelanto registrado y administrar los diferentes métodos de pago.
- Dashboard gerencial y generación de reportes para apoyar el seguimiento de la operación y la toma de decisiones. :contentReference[oaicite:1]{index=1}

Cada uno de estos ocho requerimientos representa una necesidad funcional del negocio y constituye la base para la elaboración del Product Backlog del proyecto. Posteriormente, dichos requerimientos son descompuestos en historias de usuario y asociados a los módulos funcionales definidos dentro del Documento de Diseño de Software (SDD), garantizando la trazabilidad entre las necesidades identificadas, el diseño técnico y la implementación del sistema. Esta relación se documenta de manera consolidada en la Matriz de Trazabilidad incluida en el Anexo G del informe. :contentReference[oaicite:2]{index=2}

## Usuarios clave y roles

La identificación de los usuarios que interactúan con el sistema permite establecer responsabilidades claras durante la operación del restaurante y constituye la base para el diseño del modelo de autorización implementado en la aplicación.

| Usuario | Responsabilidad dentro del sistema | Valor esperado |
|----------|------------------------------------|----------------|
| Cliente | Solicita reservas y registra el comprobante del adelanto. | Confirmación de la reserva y reducción de la incertidumbre durante la atención. |
| Recepcionista | Valida el adelanto, confirma la llegada del cliente, administra mesas y lista de espera. | Atención ordenada, rápida y con información actualizada. |
| Mesero | Registra y actualiza los pedidos realizados por cada mesa. | Disminución de errores durante la comunicación con cocina y caja. |
| Cajero(a) | Registra el cobro final y aplica automáticamente el descuento correspondiente al adelanto. | Cierre consistente de las ventas y control de los pagos. |
| Administrador | Gestiona usuarios, mesas, productos y parámetros generales del sistema. | Información operativa actualizada y administración centralizada. |
| Gerente | Consulta indicadores, reportes y estadísticas de la operación. | Toma de decisiones sustentada en información consolidada. |

**Tabla 3. Usuarios clave y roles. Fuente: Elaboración propia.**

La matriz de usuarios constituye el fundamento del modelo de control de acceso basado en roles (RBAC) implementado en el sistema. Cada uno de los perfiles definidos dispone únicamente de los permisos necesarios para ejecutar las funciones propias de su responsabilidad, limitando el acceso a módulos y operaciones que no correspondan a su rol. Esta estrategia fortalece la seguridad de la aplicación y contribuye a prevenir accesos no autorizados, riesgo identificado previamente dentro del Plan de Gestión de Riesgos del proyecto. :contentReference[oaicite:3]{index=3}
