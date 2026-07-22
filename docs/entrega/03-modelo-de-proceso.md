# Sección 2. Selección y justificación del modelo de proceso

## 2.1 Evaluación de alternativas

Para seleccionar el modelo de proceso más adecuado para el desarrollo del **Sistema de Gestión de Reservas y Operaciones para el Restaurante D'Barrio Broaster**, se realizó una evaluación comparativa entre los modelos **Cascada**, **Incremental** y **Scrum**, aplicando un enfoque de decisión multicriterio. La evaluación consideró el contexto organizacional identificado durante el diagnóstico, la naturaleza del producto y la necesidad de validar progresivamente los módulos implementados.

La valoración se realizó mediante una escala de 1 a 5, donde **5 representa la mayor adecuación** al proyecto.

| Criterio | Cascada | Incremental | Scrum | Justificación |
|-----------|:--------:|:-----------:|:------:|---------------|
| Claridad de requisitos iniciales | 3 | 4 | 4 | Las reglas principales son conocidas, pero la interacción entre módulos puede refinarse durante el desarrollo. |
| Tolerancia al riesgo técnico | 2 | 4 | 4 | Los procesos de pago, validación de vouchers y disponibilidad de mesas requieren validación temprana. |
| Compatibilidad con el equipo | 3 | 4 | 4 | El equipo puede trabajar mediante entregas incrementales y aprendizaje continuo. |
| Documentación del proyecto | 5 | 4 | 4 | El proyecto requiere evidencias, métricas y documentación académica durante todo el desarrollo. |
| Entrega de valor | 2 | 4 | 5 | Cada módulo funcional puede desarrollarse, demostrarse y validarse de manera independiente. |
| **Total** | **15** | **20** | **21** | **Scrum presenta la mayor adecuación al contexto del proyecto.** |

**Tabla 4. Comparación de modelos candidatos. Fuente: Elaboración propia.**

La comparación evidencia que Scrum obtiene la mayor puntuación debido a su capacidad para gestionar entregas incrementales, reducir el riesgo técnico y permitir la validación continua de los módulos funcionales por parte de los usuarios involucrados durante el desarrollo. :contentReference[oaicite:1]{index=1}

---

## 2.2 Modelo seleccionado: Scrum adaptado

Como resultado del análisis comparativo, se seleccionó **Scrum adaptado** como modelo de desarrollo del proyecto.

La elección responde a la necesidad de organizar el trabajo mediante objetivos de corto plazo, desarrollar incrementos funcionales y obtener retroalimentación continua durante la implementación del sistema.

La adaptación incorpora los artefactos y evidencias exigidos por el proyecto académico sin modificar los principios fundamentales de Scrum, manteniendo los pilares de **transparencia, inspección y adaptación** durante todo el proceso de desarrollo. :contentReference[oaicite:2]{index=2}

### Roles Scrum adaptados

| Rol Scrum | Asignación | Responsabilidad |
|------------|------------|-----------------|
| Product Owner | Gerente del restaurante (representado) | Priorizar el valor del producto y validar los incrementos desarrollados. |
| Scrum Master | Integrante del equipo | Facilitar los eventos Scrum, coordinar el trabajo y eliminar impedimentos. |
| Developers | Integrantes del equipo | Analizar, diseñar, implementar, probar y documentar las funcionalidades del sistema. |

**Tabla 5. Roles Scrum adaptados. Fuente: Elaboración propia.** :contentReference[oaicite:3]{index=3}

### Modelos descartados

El modelo **Cascada** fue descartado debido a que concentra la validación del producto al finalizar el desarrollo, incrementando el riesgo de detectar tardíamente cambios relacionados con reservas, recepción, mesas, pedidos y caja.

El modelo **Incremental** representa una alternativa técnicamente viable; sin embargo, Scrum proporciona una estructura de trabajo más adecuada mediante eventos definidos, revisiones periódicas y mejora continua, facilitando la priorización del Product Backlog y la validación constante del producto desarrollado. :contentReference[oaicite:4]{index=4}

---

## 2.3 Plan de aplicación del modelo

La aplicación del modelo Scrum se organiza mediante una planificación incremental compuesta por **cinco sprints**, desarrollados de forma secuencial.

La secuencia considera las dependencias técnicas entre los módulos del sistema, iniciando con la infraestructura básica y continuando con los procesos principales del negocio hasta completar las funcionalidades administrativas y de gestión.

Cada sprint comprende actividades de planificación, desarrollo, pruebas, revisión del incremento y retrospectiva, permitiendo mantener la trazabilidad entre los requisitos definidos en el Product Backlog, las funcionalidades implementadas y las evidencias generadas durante el proyecto. 

La planificación detallada de los sprints, el Product Backlog, la matriz de trazabilidad y las evidencias asociadas se presentan en los anexos correspondientes del proyecto.
