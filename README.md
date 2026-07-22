# RMRS - Sistema de Gestión y Reservas para Restaurante

Proyecto académico del curso **Metodología de Desarrollo de Software**. RMRS es una aplicación web para administrar reservas, mesas, lista de espera, pedidos, caja, productos, usuarios y reportes del restaurante ficticio **D'Barrio Broaster**.

## Integrantes

- Kieffer Gonzales Chavez
- Jhonatan Fernandez Coronel

## Funcionalidades principales

- Reserva pública con confirmación y adelanto.
- Recepción, asignación de mesas y lista de espera.
- Gestión de mesas, productos, usuarios y empleados.
- Registro y seguimiento de pedidos.
- Caja, pagos y comprobantes.
- Dashboard de gerencia y reportes.
- Autenticación, autorización por roles y protección CSRF.

## Tecnologías

- PHP 8, MySQL y PDO.
- Arquitectura MVC.
- Apache/XAMPP.
- HTML, CSS y JavaScript.

## Documentación Scrum

La documentación del proceso está en [`docs/`](docs/README.md):

- visión, alcance y actores;
- Product Backlog e historias de usuario;
- planificación y evidencia de cada sprint;
- matriz de trazabilidad;
- estrategia de pruebas y calidad;
- riesgos, métricas y retrospectiva;
- Definition of Ready y Definition of Done.
- Documento de Diseño de Software (SDD).

> La línea base Scrum fue reconstruida el 21 de julio de 2026 a partir del producto funcional entregado. No pretende sustituir el historial real de reuniones o commits anterior a la creación del repositorio.

## Instalación local con XAMPP

1. Clonar el repositorio dentro de `htdocs/restaurant-system`.
2. Iniciar Apache y MySQL.
3. Crear la base `restaurante` e importar `database/restaurante.sql`.
4. Copiar `config/database.local.example.php` como `config/database.local.php` y ajustar las credenciales.
5. Abrir `http://localhost/restaurant-system/public`.

```bash
git clone <URL_DEL_REPOSITORIO> restaurant-system
cd restaurant-system
cp config/database.local.example.php config/database.local.php
```

## Validación rápida

```bash
find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
```

Las pruebas funcionales propuestas y sus resultados pendientes de ejecución están descritos en [`docs/calidad-y-pruebas.md`](docs/calidad-y-pruebas.md).

## Datos sensibles

No se versionan credenciales locales, logs, archivos cargados ni vouchers. El repositorio solo incluye una plantilla de configuración.

## Licencia

Uso académico. Consulte el archivo [`LICENSE`](LICENSE).
