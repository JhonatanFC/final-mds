# Arquitectura

RMRS usa una arquitectura MVC implementada en PHP.

```text
Navegador
   |
public/index.php -> Router -> Middleware
                           |
                       Controller
                      /          \
                  Model          View
                    |              |
               MySQL/PDO       HTML/CSS/JS
```

## Componentes

- `public/`: punto de entrada y recursos estáticos.
- `routes/`: definición de rutas web.
- `app/controllers/`: coordinación de solicitudes y respuestas.
- `app/models/`: acceso a datos y reglas del dominio.
- `app/views/`: interfaces por módulo y rol.
- `app/core/`: router, base MVC, sesiones, seguridad y validación.
- `app/middleware/`: control de autenticación y autorización.
- `config/`: configuración general y conexión a base de datos.
- `database/`: scripts SQL de instalación y datos de demostración.

## Controles de seguridad observables

- consultas mediante PDO;
- hash y verificación de contraseñas;
- tokens CSRF;
- sesiones y autorización por roles;
- escape de salida en funciones auxiliares.

La seguridad debe validarse con los casos definidos en `calidad-y-pruebas.md`; la presencia del control en código no sustituye su prueba.
