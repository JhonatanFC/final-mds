# SECCIÓN 2. SELECCIÓN Y JUSTIFICACIÓN DEL MODELO DE PROCESO

## Descripción

La selección del modelo de proceso constituye una decisión estratégica que determina la forma en que el equipo planifica, desarrolla, valida y controla la construcción del Sistema de Gestión de Reservas y Operaciones para el Restaurante D'Barrio Broaster.

Con el propósito de seleccionar el enfoque más adecuado para las características del proyecto, se evaluaron distintos modelos de desarrollo considerando el contexto organizacional, la naturaleza del producto, la necesidad de interacción con usuarios representativos y el nivel de riesgo asociado a los procesos críticos del restaurante.

El análisis se realizó mediante una evaluación multicriterio, permitiendo justificar técnicamente la adopción de Scrum adaptado como modelo de desarrollo para el proyecto. :contentReference[oaicite:1]{index=1}

---

## 2.1 Evaluación de alternativas

Antes de seleccionar el modelo de desarrollo se compararon tres alternativas ampliamente utilizadas en proyectos de ingeniería de software:

- Modelo Cascada.
- Modelo Incremental.
- Marco de trabajo Scrum.

La comparación considera cinco criterios de evaluación derivados del contexto del restaurante y de las necesidades identificadas durante el diagnóstico organizacional.

### Tabla 4. Comparación de modelos candidatos

| Criterio | Cascada | Incremental | Scrum | Justificación |
|----------|---------:|------------:|-------:|---------------|
| Claridad de requisitos iniciales | 3 | 4 | 4 | Las reglas principales son conocidas, pero la interacción puede refinarse. |
| Tolerancia al riesgo técnico | 2 | 4 | 4 | Pagos, vouchers y disponibilidad requieren validación temprana. |
| Compatibilidad con el equipo | 3 | 4 | 4 | El equipo puede aprender mediante entregas pequeñas. |
| Documentación del cliente | 5 | 4 | 4 | Se requiere evidencia, pero no exceso de documentos rígidos. |
| Entrega de valor | 2 | 4 | 5 | Cada módulo puede mostrarse de manera funcional. |
| **Total** | **15** | **20** | **21** | **Scrum obtiene la mayor adecuación contextual.** |

**Tabla 4. Comparación de modelos candidatos. Fuente: Elaboración propia.**

Los resultados muestran que Scrum alcanza la mayor puntuación debido a su capacidad para gestionar cambios, validar funcionalidades mediante incrementos y reducir el riesgo asociado a procesos críticos como reservas, recepción, asignación de mesas, pedidos y cobros.

La diferencia más importante respecto a Cascada se encuentra en la posibilidad de validar continuamente el funcionamiento del sistema. En un entorno donde varios procesos dependen unos de otros, retrasar la retroalimentación hasta el final del proyecto incrementaría significativamente el riesgo de rediseños, retrabajo y errores funcionales.

Por su parte, el modelo Incremental representa una alternativa técnicamente viable; sin embargo, Scrum incorpora eventos claramente definidos que permiten planificar, inspeccionar y adaptar el trabajo de forma continua durante todo el ciclo de desarrollo. :contentReference[oaicite:2]{index=2}

---

## 2.2 Modelo seleccionado: Scrum adaptado

Como resultado del análisis comparativo se seleccionó **Scrum adaptado** como modelo de proceso para el desarrollo del sistema.

La elección responde a la necesidad de organizar el proyecto mediante objetivos de corto plazo, desarrollar funcionalidades completas por incrementos y validar cada módulo junto con representantes del restaurante antes de continuar con la siguiente iteración.

La adaptación realizada no modifica los principios fundamentales de Scrum establecidos por Schwaber y Sutherland (2020). Por el contrario, conserva los roles, eventos y artefactos esenciales del marco de trabajo e incorpora la documentación exigida por el proyecto académico, incluyendo:

- Product Backlog.
- Historias de usuario.
- Criterios de aceptación.
- Sprint Planning.
- Sprint Review.
- Sprint Retrospective.
- Registro de riesgos.
- Matriz de trazabilidad.
- Casos de prueba.
- Evidencias de validación.
- Métricas de seguimiento del proyecto.

Esta adaptación permite mantener los principios de transparencia, inspección y adaptación propios de Scrum sin descuidar la documentación requerida para sustentar técnica y académicamente el proyecto. :contentReference[oaicite:3]{index=3}

### Roles Scrum adaptados

| Rol Scrum | Asignación simulada | Responsabilidad |
|-----------|---------------------|-----------------|
| Product Owner | Gerente del restaurante (representado) | Prioriza el valor del producto y acepta los incrementos desarrollados. |
| Scrum Master | Integrante 1 del equipo | Facilita los eventos Scrum, elimina impedimentos y supervisa la correcta aplicación del proceso. |
| Developers | Integrantes del equipo | Analizan, diseñan, implementan, prueban y documentan cada incremento funcional. |

**Tabla 5. Roles Scrum adaptados. Fuente: Elaboración propia.**

La asignación de responsabilidades favorece la comunicación permanente entre los participantes del proyecto y permite validar progresivamente los módulos funcionales antes de avanzar hacia nuevos desarrollos. :contentReference[oaicite:4]{index=4}

---

## 2.3 Plan de aplicación del modelo

La implementación del proyecto se organiza mediante cinco Sprints de dos semanas cada uno, permitiendo construir el sistema de forma incremental y mantener una revisión permanente del avance.

Cada Sprint incorpora actividades de planificación, desarrollo, pruebas, revisión funcional y retrospectiva, garantizando que cada incremento entregue funcionalidades completamente verificables.

La planificación general del proyecto comprende los siguientes incrementos:

- **Sprint 0:** Preparación del entorno de desarrollo, definición del Product Backlog y configuración inicial del proyecto.
- **Sprint 1:** Implementación de la autenticación, gestión de usuarios y configuración básica del sistema.
- **Sprint 2:** Desarrollo del módulo de reservas, recepción y administración de mesas.
- **Sprint 3:** Implementación de productos, pedidos, lista de espera y flujo operativo del restaurante.
- **Sprint 4:** Desarrollo del módulo de caja, reportes gerenciales, validaciones finales y preparación para la entrega del producto.

Cada incremento finaliza únicamente cuando las historias de usuario cumplen sus criterios de aceptación, las pruebas funcionales han sido ejecutadas satisfactoriamente y la Sprint Review valida el funcionamiento del módulo desarrollado.

La aplicación de Scrum adaptado permite mantener una trazabilidad continua entre las necesidades del negocio, el Product Backlog, las historias de usuario, los artefactos de diseño, las pruebas realizadas y el producto implementado, reduciendo el riesgo de desviaciones durante el desarrollo del proyecto y fortaleciendo la calidad del resultado final. :contentReference[oaicite:5]{index=5}
