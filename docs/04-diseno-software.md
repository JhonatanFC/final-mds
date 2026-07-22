## Arquitectura del sistema

El Sistema de Gestión de Reservas y Operaciones del Restaurante D'Barrio Broaster implementa una arquitectura basada en el patrón **Modelo–Vista–Controlador (MVC)**, organizada en tres capas principales: presentación, lógica de negocio y acceso a datos. Esta arquitectura permite separar claramente las responsabilidades de cada componente, facilitando el mantenimiento, la escalabilidad y la evolución del sistema.

La aplicación fue desarrollada utilizando **PHP** como lenguaje del lado del servidor, ejecutándose sobre **Apache** mediante XAMPP y utilizando **MySQL/MariaDB** como sistema gestor de bases de datos. El acceso a la información se realiza mediante **PDO** y consultas preparadas, garantizando una comunicación segura y eficiente con la base de datos.

La arquitectura MVC permite que cada solicitud realizada por un usuario siga un flujo controlado desde la interfaz hasta la base de datos y regrese posteriormente con la información procesada, evitando el acoplamiento entre la interfaz gráfica y la lógica del negocio.

### Arquitectura lógica

La solución se divide en tres capas principales:

### Capa de Presentación (Vista)

Corresponde a todas las interfaces con las que interactúan los usuarios del sistema. Está desarrollada utilizando PHP, HTML, CSS, Bootstrap y JavaScript.

Esta capa tiene como responsabilidad:

- Mostrar la información al usuario.
- Capturar datos mediante formularios.
- Presentar reportes y mensajes del sistema.
- Enviar las solicitudes al controlador correspondiente.

Las vistas no contienen lógica de negocio ni realizan consultas directas a la base de datos.

### Capa de Lógica de Negocio (Controladores)

Los controladores representan el núcleo funcional del sistema.

Cada controlador recibe las solicitudes provenientes de las vistas, valida la información recibida, verifica los permisos del usuario autenticado y coordina la ejecución de las reglas del negocio.

Entre sus principales responsabilidades se encuentran:

- Gestionar reservas.
- Validar vouchers.
- Administrar mesas.
- Registrar pedidos.
- Procesar cobros.
- Administrar usuarios.
- Generar reportes.

Los controladores actúan como intermediarios entre las vistas y los modelos.

### Capa de Acceso a Datos (Modelos)

Los modelos encapsulan todas las operaciones relacionadas con la base de datos.

Cada modelo representa una entidad del sistema, como usuarios, reservas, mesas, pedidos o pagos, utilizando PDO para ejecutar operaciones CRUD mediante consultas parametrizadas.

Gracias a esta separación, cualquier cambio en la estructura de la base de datos puede realizarse sin afectar la interfaz de usuario ni la lógica del negocio.

### Flujo de funcionamiento de la arquitectura

Cada operación realizada dentro del sistema sigue el siguiente proceso:

1. El usuario realiza una acción desde el navegador (por ejemplo, registrar una reserva).
2. La solicitud HTTP es recibida por el Router del sistema.
3. El Router identifica el controlador correspondiente.
4. El Middleware verifica la sesión activa y los permisos del usuario.
5. El Controlador valida la información recibida y ejecuta las reglas del negocio.
6. El Controlador solicita la información necesaria al Modelo.
7. El Modelo realiza las consultas o actualizaciones mediante PDO.
8. La Base de Datos devuelve el resultado al Modelo.
9. El Modelo retorna la información al Controlador.
10. El Controlador envía los datos a la Vista.
11. La Vista genera la respuesta HTML que finalmente es presentada al usuario.

Este flujo garantiza una clara separación de responsabilidades, reduciendo el acoplamiento entre componentes y facilitando el mantenimiento del software.

### Diagrama general de la arquitectura

```text
                   Usuario
                      │
                      ▼
             Navegador Web
                      │
               Solicitud HTTP
                      │
                      ▼
               Router (index.php)
                      │
                      ▼
      Middleware (Sesión y Roles)
                      │
                      ▼
               Controladores
                      │
          ┌───────────┴───────────┐
          ▼                       ▼
      Modelos (PDO)           Vistas
          │                       ▲
          ▼                       │
    Base de Datos            Respuesta HTML
    MySQL / MariaDB               │
          ▲                       │
          └──────────────┬────────┘
                         ▼
                      Usuario
```

### Beneficios de la arquitectura MVC

La implementación del patrón MVC proporciona diversas ventajas para el desarrollo del sistema:

- Separación entre presentación, lógica de negocio y acceso a datos.
- Mayor organización del código fuente.
- Facilidad para realizar mantenimiento y corrección de errores.
- Reutilización de componentes entre diferentes módulos.
- Escalabilidad para incorporar nuevas funcionalidades.
- Mejor control de seguridad mediante autenticación, autorización y middleware.
- Acceso centralizado a la base de datos mediante PDO y consultas preparadas.
- Facilita el trabajo colaborativo entre los desarrolladores.
