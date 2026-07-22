# Plan y evidencia de sprints

La siguiente línea base organiza el incremento existente. Las fechas históricas no se inventan; el repositorio inicia su trazabilidad formal el 21 de julio de 2026.

| Sprint | Objetivo | Historias | Incremento verificable |
|---:|---|---|---|
| 0 | Preparar arquitectura, datos y seguridad base. | HU-01, HU-02 | MVC, conexión PDO, sesiones, roles y usuarios. |
| 1 | Permitir reservar y coordinar la atención inicial. | HU-03 a HU-06 | Reservas, recepción, mesas y lista de espera. |
| 2 | Gestionar productos y pedidos del servicio. | HU-07, HU-08 | Productos, categorías y pedidos. |
| 3 | Controlar adelantos, pagos y cierre de consumo. | HU-09, HU-10 | Caja, pagos y comprobantes. |
| 4 | Entregar información para decisiones gerenciales. | HU-11, HU-12 | Dashboard y reportes. |

## Plantilla para cada sprint futuro

1. Objetivo del sprint.
2. Historias seleccionadas y estimación.
3. Criterios de aceptación.
4. Tareas técnicas y responsables.
5. Evidencia: issue, rama, commits, PR y capturas.
6. Resultado de pruebas.
7. Sprint Review: aceptado/rechazado y observaciones.
8. Retrospectiva: mantener, mejorar y acción concreta.

## Retrospectiva de la línea base

### Mantener

- separación MVC y control de acceso por roles;
- consultas con PDO y medidas CSRF;
- módulos alineados con el flujo operativo del restaurante.

### Mejorar

- incorporar pruebas automatizadas;
- reemplazar configuración fija de URL por variables de entorno;
- eliminar archivos vacíos y consolidar scripts SQL;
- usar issues y pull requests para la trazabilidad.

### Acción del siguiente sprint

Crear una suite mínima de pruebas para autenticación, reservas y cálculo de caja, y ejecutarla en GitHub Actions.
