# Calidad y pruebas

## Estrategia Shift Left

| Actividad SQA | Etapa | Responsable | Técnica/herramienta | Shift Left |
|---|---|---|---|---|
| Revisar criterios de aceptación | Refinamiento | Product Owner y equipo | Checklist | Sí |
| Modelar amenazas básicas | Diseño | Desarrollo | Revisión de roles, CSRF y entradas | Sí |
| Revisar esquema y restricciones | Diseño | Desarrollo | MySQL/phpMyAdmin | Sí |
| Validar sintaxis PHP | Construcción | Desarrollo | `php -l` | Sí |
| Revisar código por pares | Construcción | Equipo | Pull request | Sí |
| Ejecutar pruebas funcionales | Pruebas | QA/equipo | Casos CP-01 a CP-15 | No |
| Probar autorización por roles | Pruebas | QA/equipo | Matriz actor-ruta | No |
| Registrar defectos y regresión | Cierre | Equipo | GitHub Issues | No |

## Casos funcionales

Estado inicial: **Pendiente** hasta ejecutarlos en el entorno XAMPP y adjuntar evidencia.

| ID | Escenario | Resultado esperado | Estado |
|---|---|---|---|
| CP-01 | Iniciar sesión con credenciales válidas. | Acceso al dashboard del rol. | Pendiente |
| CP-02 | Acceder a una ruta sin rol autorizado. | Acceso rechazado o redirección. | Pendiente |
| CP-03 | Crear usuario con datos válidos. | Usuario almacenado con rol asignado. | Pendiente |
| CP-04 | Registrar reserva válida. | Reserva y confirmación generadas. | Pendiente |
| CP-05 | Registrar reserva con datos incompletos. | Validación impide el registro. | Pendiente |
| CP-06 | Confirmar solicitud desde recepción. | Estado actualizado correctamente. | Pendiente |
| CP-07 | Cambiar disponibilidad de mesa. | Nuevo estado visible para recepción. | Pendiente |
| CP-08 | Incorporar cliente a lista de espera. | Registro consultable y ordenado. | Pendiente |
| CP-09 | Crear pedido con productos. | Detalle y total persistidos. | Pendiente |
| CP-10 | Crear o actualizar producto. | Catálogo actualizado sin pérdida de datos. | Pendiente |
| CP-11 | Cerrar consumo con adelanto. | Adelanto descontado del total. | Pendiente |
| CP-12 | Registrar pago inválido. | Operación rechazada sin alterar caja. | Pendiente |
| CP-13 | Subir formato de voucher no permitido. | Archivo rechazado. | Pendiente |
| CP-14 | Consultar dashboard como gerente. | Indicadores cargados y acceso permitido. | Pendiente |
| CP-15 | Consultar reporte con filtros. | Datos coherentes con la base. | Pendiente |

## Perfil ISO/IEC 25010 priorizado

| Característica | Objetivo | Métrica |
|---|---:|---|
| Adecuación funcional | 90% | Casos funcionales aprobados / ejecutados. |
| Eficiencia de desempeño | 85% | 95% de páginas responde en menos de 2 s en red local. |
| Compatibilidad | 80% | Operación correcta en Chrome y Firefox actuales. |
| Usabilidad | 85% | 85% de tareas críticas completadas sin ayuda. |
| Fiabilidad | 90% | Menos de 1 fallo crítico por jornada de prueba. |
| Seguridad | 90% | 100% de rutas privadas protegidas por rol y CSRF. |
| Mantenibilidad | 85% | 100% de PHP sin errores de sintaxis; módulos separados por MVC. |
| Portabilidad | 80% | Instalación reproducible en XAMPP siguiendo README. |

Características críticas: adecuación funcional, fiabilidad y seguridad.
