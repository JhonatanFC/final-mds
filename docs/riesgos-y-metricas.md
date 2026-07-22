# Riesgos y métricas

## Registro de riesgos

| ID | Riesgo | Prob. | Impacto | Mitigación | Indicador |
|---|---|---|---|---|---|
| R-01 | Pérdida o inconsistencia de reservas. | Media | Alto | Transacciones, respaldos y pruebas de concurrencia. | Reservas duplicadas o sin mesa. |
| R-02 | Acceso de un rol a funciones no autorizadas. | Media | Alto | Middleware, revisión de rutas y pruebas por rol. | Ruta privada accesible con rol incorrecto. |
| R-03 | Exposición de credenciales o vouchers. | Media | Alto | `.gitignore`, plantilla local y revisión antes de cada push. | Secreto detectado en commit. |
| R-04 | Error en cálculo de adelanto o caja. | Media | Alto | Casos límite y pruebas automatizadas de cálculo. | Diferencia entre consumo y cierre. |
| R-05 | Retraso por falta de trazabilidad Scrum. | Alta | Medio | Issues, responsables, estimación y revisión semanal. | Historia sin issue, responsable o evidencia. |
| R-06 | Entorno difícil de reproducir. | Media | Medio | Instrucciones y script SQL único validado. | Instalación falla siguiendo README. |

## Métricas de control

| Indicador | Frecuencia | Responsable | Umbral de alerta |
|---|---|---|---|
| Cumplimiento del sprint | Fin de sprint | Scrum Master | Menos de 80% de historias aceptadas. |
| Defectos críticos abiertos | Diario durante pruebas | Equipo | Uno o más defectos críticos. |
| Casos de prueba aprobados | Fin de sprint | QA/equipo | Menos de 90%. |
| Historias con trazabilidad completa | Semanal | Scrum Master | Menos de 100%. |
| Tiempo de respuesta local p95 | Por versión | Desarrollo | Mayor a 2 segundos. |
| Riesgos altos sin mitigación | Semanal | Product Owner | Uno o más riesgos sin acción. |

Para sprints futuros, el burndown se alimentará con las tareas abiertas/cerradas de GitHub Projects. No se presentan valores históricos porque el repositorio todavía no existía.
