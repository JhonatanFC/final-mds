# SECCIÓN 5. PLAN DE CALIDAD DEL SOFTWARE

## Descripción

La calidad del Sistema de Gestión de Reservas y Operaciones para el Restaurante D'Barrio Broaster se planificó desde las primeras etapas del proyecto, incorporando actividades de verificación y validación durante el análisis, diseño, implementación y pruebas. Este enfoque permite detectar defectos de manera temprana, reducir el retrabajo y garantizar que cada incremento funcional cumpla los requisitos definidos para el producto. 

El plan de calidad adopta como referencia el modelo **ISO/IEC 25010**, priorizando aquellas características que tienen mayor impacto sobre la operación del restaurante y sobre la experiencia de los usuarios. Asimismo, integra un proceso de **Software Quality Assurance (SQA)** con enfoque **Shift Left**, trasladando las actividades de aseguramiento de la calidad hacia las primeras fases del ciclo de desarrollo para disminuir el costo de corrección de defectos y fortalecer la confiabilidad del sistema. 

## Componentes del plan de calidad

La estrategia de calidad desarrollada para el proyecto comprende los siguientes elementos:

- Perfil de calidad basado en ISO/IEC 25010.
- Plan de aseguramiento de la calidad (SQA).
- Aplicación del enfoque Shift Left.
- Estimación del costo de calidad.
- Matriz de pruebas funcionales.
- Validación del prototipo y de las interfaces de usuario. 

Estos componentes permiten establecer criterios objetivos para evaluar el cumplimiento de los requisitos funcionales y no funcionales, proporcionando evidencia verificable durante la ejecución del proyecto y antes de la entrega del producto final.

## Perfil de calidad

El perfil de calidad se construyó ponderando las ocho características definidas por ISO/IEC 25010 según su impacto sobre el contexto operativo del restaurante. Como resultado del análisis, las características con mayor prioridad corresponden a:

- Adecuación funcional.
- Fiabilidad.
- Seguridad.

Estas tres características concentran la mayor criticidad debido a que el sistema administra reservas, disponibilidad de mesas, pedidos, credenciales de usuarios, comprobantes de pago y procesos de cobro, cuya operación correcta resulta esencial para el funcionamiento del negocio. :contentReference[oaicite:4]{index=4}

## Aseguramiento de la calidad

El proceso SQA incorpora actividades de revisión desde el refinamiento de requisitos hasta la ejecución de pruebas funcionales. Entre ellas se incluyen la validación de criterios de aceptación, el análisis de riesgos, la revisión del modelo de datos, la evaluación del diseño de interfaces, la verificación del código fuente y la comprobación de los mecanismos de autenticación, autorización y protección frente a vulnerabilidades comunes.

Este enfoque favorece la detección temprana de errores, mejora la calidad de los incrementos entregados y reduce significativamente el costo asociado a correcciones realizadas en etapas posteriores del proyecto. 

## Validación del producto

La validación del sistema se realiza mediante una matriz de casos de prueba que cubre los requisitos funcionales priorizados y los riesgos identificados durante la planificación. Cada caso de prueba permite comprobar el comportamiento esperado de los principales módulos del sistema, asegurando la coherencia entre los requisitos del negocio, el diseño técnico y la implementación desarrollada.

Como complemento, el proyecto incorpora un prototipo de interfaces elaborado en Figma, utilizado para validar la navegación, la organización de la información y la experiencia de usuario antes de la implementación definitiva de las pantallas. :contentReference[oaicite:6]{index=6}

## Documentación complementaria

El desarrollo completo del Plan de Calidad del Software se encuentra documentado en **`05-calidad-iso-sqa.md`**, donde se presentan el perfil ISO/IEC 25010, el plan SQA con enfoque Shift Left, la estimación del costo de calidad, la matriz de pruebas funcionales y el registro del prototipo utilizado durante el proyecto. Esta documentación complementa el Documento de Diseño de Software y proporciona las evidencias técnicas que respaldan el aseguramiento de la calidad del producto. 
