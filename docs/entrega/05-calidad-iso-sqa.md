# Plantilla de calidad ISO 25010 y SQA

Usar esta estructura para la **Sección 4**. Los objetivos son propuestas de calidad: el equipo debe completarlos con resultados de prueba reales.

## 4.1 Perfil ISO/IEC 25010

| Característica | Nivel objetivo | Justificación ligada al sistema | Métrica verificable |
|---|---:|---|---|
| Adecuación funcional | 5/5 | Las reservas, atención, pedidos y cobros deben ejecutar el flujo previsto. | % de casos funcionales aprobados. |
| Eficiencia de desempeño | 4/5 | Recepción y caja se usan durante atención al cliente. | p95 de respuesta local menor a **[definir]** segundos. |
| Compatibilidad | 3/5 | El sistema web debe operar en navegadores del entorno definido. | Flujos críticos aprobados en Chrome y Firefox. |
| Usabilidad | 4/5 | Participan usuarios no técnicos: cliente, recepción, caja y mesero. | % de tareas críticas completadas sin ayuda. |
| Fiabilidad | 5/5 | Errores en mesa, reserva o cobro afectan la operación. | Defectos críticos por jornada de prueba. |
| Seguridad | 5/5 | Trata credenciales, DNI, teléfono, pagos y vouchers. | % de rutas privadas probadas con control de rol/CSRF. |
| Mantenibilidad | 4/5 | El sistema contiene módulos independientes sobre MVC. | % de archivos PHP sin error de sintaxis y cambios aislados por módulo. |
| Portabilidad | 3/5 | Debe instalarse en entorno Apache/PHP/MySQL de XAMPP. | Instalación exitosa siguiendo README. |

Características críticas recomendadas: adecuación funcional, fiabilidad y seguridad. El grupo debe justificar la elección en el contexto de su organización.

## 4.2 Actividades SQA y Shift Left

| # | Actividad | Etapa | Responsable | Técnica/herramienta | Shift Left | Evidencia esperada |
|---:|---|---|---|---|---|---|
| 1 | Refinar criterios de aceptación. | Antes del sprint | PO + equipo | Backlog/Excel | Sí | Historia aprobada. |
| 2 | Revisar riesgos de roles, pagos y datos. | Diseño | Equipo | Checklist de amenazas | Sí | Registro de riesgos. |
| 3 | Revisar modelo de datos y reglas. | Diseño | Desarrollo | Script SQL/diagrama | Sí | Observaciones resueltas. |
| 4 | Revisar interfaz y flujos en CorelDRAW. | Diseño | PO + usuarios | Prototipo y feedback | Sí | Capturas/comentarios. |
| 5 | Validar sintaxis y revisión de código. | Construcción | Desarrollo | `php -l`, GitHub PR | Sí | Salida de validación/revisión. |
| 6 | Ejecutar casos funcionales. | Pruebas | QA/equipo | Matriz de pruebas | No | Resultado por CP. |
| 7 | Probar autorización y CSRF. | Pruebas | QA/equipo | Matriz actor-ruta | No | Evidencia de acceso denegado. |
| 8 | Regresión antes de demo. | Cierre de sprint | Equipo | Checklist de módulo | No | Acta de Sprint Review. |

## 4.3 Costo de calidad

No asignar montos sin sustento. Calcular en el Excel una distribución como la siguiente y justificarla con 1-10-100:

| Categoría | Ejemplos en RMRS | % propuesto | Monto real |
|---|---|---:|---:|
| Prevención | Refinamiento, revisión de diseño, validación temprana y capacitación. | **[definir]** | **[calcular]** |
| Detección | Pruebas funcionales, revisión de código y demo. | **[definir]** | **[calcular]** |
| Corrección | Defectos encontrados tras revisión/demo. | **[definir]** | **[calcular]** |

La regla 1-10-100 se presenta como fundamento de decisión: detectar y prevenir antes de la entrega cuesta menos que corregir un defecto en operación. No debe presentarse como una medición real si no hay datos.
