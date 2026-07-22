# Plantilla de gestión, sprints y métricas

Usar esta estructura para la **Sección 3**. El Excel de planificación debe ser la fuente principal de los valores, fechas y responsables.

## 3.1 Macroplan de incrementos

| Incremento | Objetivo verificable | Módulos asociados | Entregable de cierre | Duración / fechas |
|---|---|---|---|---|
| Base técnica | Arquitectura, base de datos, sesión, roles y seguridad. | MVC, usuarios, autenticación. | Sistema con acceso por roles. | **[POR CONFIRMAR]** |
| Atención inicial | Registrar y gestionar una reserva. | Reserva, recepción, mesas, lista de espera. | Flujo reserva → llegada/mesa. | **[POR CONFIRMAR]** |
| Operación de sala | Registrar oferta y consumo. | Productos, categorías, pedidos. | Pedido activo con estado. | **[POR CONFIRMAR]** |
| Cobro | Procesar el consumo y adelanto. | Caja, cobros, pagos/vouchers. | Cobro con total, adelanto y saldo. | **[POR CONFIRMAR]** |
| Control gerencial | Visualizar información de gestión. | Dashboard y reportes. | Indicadores y reporte consultable. | **[POR CONFIRMAR]** |

## 3.2 Recursos y estimación

| Elemento | Dato que debe completar el equipo |
|---|---|
| Equipo y roles | **[POR CONFIRMAR]** |
| Capacidad por sprint | **[POR CONFIRMAR: horas o story points]** |
| Esfuerzo total | Suma de los valores del Excel. |
| Presupuesto | **[POR CONFIRMAR: supuesto de costo/hora, licencias y hosting]** |
| Herramientas | PHP, MySQL/MariaDB, XAMPP, GitHub, CorelDRAW y **[otros reales]**. |

## 3.3 Registro de riesgos propuesto

| ID | Riesgo | Prob. | Impacto | Mitigación | Disparador |
|---|---|---|---|---|---|
| R-01 | Reserva duplicada o mesa asignada incorrectamente. | Media | Alto | Validar capacidad/estado; prueba de escenarios límite. | Dos reservas para la misma mesa/franja. |
| R-02 | Pago o voucher no validado correctamente. | Media | Alto | Revisión por recepción y prueba de aceptación/rechazo. | Cobro sin adelanto válido. |
| R-03 | Acceso no autorizado por rol. | Media | Alto | Middleware, matriz de rutas y prueba por rol. | Usuario visualiza un módulo restringido. |
| R-04 | Diferencia en cálculo de caja. | Media | Alto | Pruebas con adelanto, sin adelanto y saldo cero. | Total de caja no coincide con pedido/cobro. |
| R-05 | Documentación y producto no coinciden. | Alta | Medio | Usar este catálogo como fuente y revisión cruzada. | Módulo mencionado no existe o falta uno real. |
| R-06 | Datos personales expuestos en GitHub público. | Media | Alto | Ignorar vouchers, credenciales, logs y datos reales. | Archivo sensible aparece en `git status`. |

El grupo debe ajustar la probabilidad e impacto con su propio criterio y explicar al menos los cinco riesgos seleccionados.

## 3.4 Sistema de métricas

| Indicador | Fórmula | Frecuencia | Responsable | Umbral de alerta |
|---|---|---|---|---|
| Cumplimiento del sprint | Historias aceptadas / historias comprometidas × 100 | Fin de sprint | Scrum Master | < 80% |
| Casos de prueba aprobados | Casos aprobados / casos ejecutados × 100 | Fin de sprint | QA/equipo | < 90% |
| Defectos críticos abiertos | Conteo de defectos críticos sin cerrar | Diario en pruebas | Equipo | ≥ 1 |
| Trazabilidad completa | Historias con evidencia / historias del sprint × 100 | Semanal | Scrum Master | < 100% |
| Variación de esfuerzo | (Esfuerzo real − planificado) / planificado × 100 | Fin de sprint | Equipo | > 20% |

Si el docente solicita EVM, usar PV, EV y AC solo si cuentan con un presupuesto y cronograma base real. Para Scrum, las métricas anteriores, velocity y burndown son equivalentes más coherentes.
