# Sección 5. Plan de calidad del software

## Descripción

Esta sección establece el plan de calidad aplicado al **Sistema de Gestión de Reservas y Operaciones para el Restaurante D'Barrio Broaster**. Su propósito es definir los criterios de calidad del producto, las actividades de aseguramiento de la calidad (SQA), el costo estimado de la calidad, la planificación de las pruebas funcionales y los mecanismos de validación utilizados durante el desarrollo.

El plan de calidad se fundamenta en el modelo **ISO/IEC 25010** y en la estrategia **Shift Left**, integrando actividades de prevención, revisión y verificación desde las primeras etapas del proyecto para reducir riesgos y mejorar la calidad del producto final. :contentReference[oaicite:1]{index=1}

---

# 5.1 Perfil de calidad ISO/IEC 25010

El perfil de calidad se elaboró considerando las ocho características definidas por la norma **ISO/IEC 25010**, priorizadas según su impacto sobre la operación del restaurante y las necesidades identificadas durante el diagnóstico organizacional.

| Característica | Objetivo | Justificación | Métrica |
|----------------|:--------:|---------------|---------|
| Adecuación funcional | 5/5 | El flujo completo de reserva, pedido y cobro debe ejecutarse correctamente. | Porcentaje de casos funcionales aprobados. |
| Eficiencia de desempeño | 4/5 | Recepción y caja operan durante periodos de mayor demanda. | Percentil 95 menor a 2 segundos en entorno local. |
| Compatibilidad | 3/5 | El sistema está orientado al uso en navegadores de escritorio. | Flujos críticos aprobados en Chrome y Firefox. |
| Usabilidad | 4/5 | Participan usuarios operativos con diferentes niveles de experiencia. | Tareas críticas completadas sin asistencia. |
| Fiabilidad | 5/5 | Los errores afectan directamente reservas, mesas y cobros. | Defectos críticos registrados por jornada de pruebas. |
| Seguridad | 5/5 | El sistema administra credenciales, pagos y datos personales. | Rutas privadas protegidas respecto al total de rutas evaluadas. |
| Mantenibilidad | 4/5 | La arquitectura MVC facilita el mantenimiento modular del sistema. | Validación de sintaxis en PHP y aislamiento de cambios por módulo. |
| Portabilidad | 3/5 | El entorno de despliegue previsto utiliza XAMPP. | Instalación satisfactoria siguiendo la guía del repositorio. |

**Tabla 12. Perfil de calidad ISO/IEC 25010. Fuente: Elaboración propia.** :contentReference[oaicite:2]{index=2}

Las características de **adecuación funcional**, **fiabilidad** y **seguridad** reciben la mayor prioridad debido a su impacto directo en la operación del sistema, mientras que compatibilidad y portabilidad mantienen una prioridad menor al no formar parte del alcance principal del proyecto. :contentReference[oaicite:3]{index=3}

---

# 5.2 Plan SQA con enfoque Shift Left

El aseguramiento de la calidad se desarrolla mediante una estrategia **Shift Left**, incorporando actividades de revisión y validación desde las primeras etapas del ciclo de desarrollo para detectar defectos de manera temprana.

| Actividad SQA | Etapa | Responsable | Técnica o herramienta | Shift Left |
|---------------|-------|-------------|-----------------------|:----------:|
| Revisión de criterios de aceptación | Refinamiento | Product Owner y equipo | Product Backlog y planificación | Sí |
| Análisis de riesgos de roles y pagos | Diseño | Equipo de desarrollo | Lista de verificación de riesgos | Sí |
| Revisión del modelo de datos | Diseño | Developers | Script SQL y modelo de datos | Sí |
| Validación del diseño de interfaz | Diseño | Product Owner y usuarios | Prototipo Figma | Sí |
| Validación de sintaxis y revisión de código | Construcción | Developers | `php -l` y revisión técnica | Sí |
| Ejecución de pruebas funcionales | Pruebas | Equipo de pruebas | Matriz de casos de prueba | No |
| Validación de autorización y CSRF | Pruebas | Equipo de pruebas | Matriz actor–ruta | No |
| Pruebas de regresión y Sprint Review | Cierre del sprint | Equipo y Product Owner | Lista de verificación y demostración | No |

**Tabla 13. Plan SQA con enfoque Shift Left. Fuente: Elaboración propia.** :contentReference[oaicite:4]{index=4}

---

# 5.3 Costo de calidad estimado

El costo de la calidad se distribuye entre actividades de prevención, evaluación y corrección, priorizando la detección temprana de defectos para disminuir el impacto de errores durante las etapas finales del proyecto.

La estimación considera el principio **1–10–100**, que establece que prevenir un defecto resulta significativamente menos costoso que corregirlo durante la operación del sistema.

Los valores detallados y la distribución del costo forman parte de la planificación económica del proyecto presentada en el informe. :contentReference[oaicite:5]{index=5}

---

# 5.4 Matriz de pruebas funcionales

La matriz de pruebas funcionales define los casos de prueba necesarios para verificar el cumplimiento de los requisitos funcionales priorizados del sistema.

Las pruebas contemplan escenarios relacionados con:

- Autenticación y control de acceso.
- Gestión de reservas.
- Validación de vouchers.
- Recepción y asignación de mesas.
- Gestión de productos y pedidos.
- Proceso de caja y cobros.
- Dashboard y reportes gerenciales.

Los resultados obtenidos permiten validar el correcto funcionamiento de los módulos implementados y respaldan la evidencia funcional del producto final. :contentReference[oaicite:6]{index=6}

---

# 5.5 Prototipo y diseño de interfaz

El diseño de la interfaz de usuario se documenta mediante el prototipo elaborado para el sistema y constituye una referencia para la implementación de las pantallas principales.

El prototipo facilita la validación temprana de la navegación, la organización de los módulos y la interacción entre los diferentes perfiles de usuario antes de la implementación definitiva del sistema. :contentReference[oaicite:7]{index=7}

---

## Correspondencia con el informe

El contenido de este documento corresponde a la **Sección 5. Plan de Calidad del Software** del informe académico y establece los criterios utilizados para asegurar la calidad del producto durante su desarrollo, validación y entrega final.

---

**Proyecto:** Sistema de Gestión de Reservas y Operaciones para el Restaurante D'Barrio Broaster

**Documento relacionado:** Sección 5. Plan de Calidad del Software
