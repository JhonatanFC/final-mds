# SECCIÓN 4. DOCUMENTO DE DISEÑO DE SOFTWARE

## Descripción

El Documento de Diseño de Software (Software Design Document – SDD) reúne las decisiones arquitectónicas, estructurales y técnicas adoptadas para el desarrollo del Sistema de Gestión de Reservas y Operaciones del Restaurante D'Barrio Broaster. Su propósito es establecer una guía de referencia para la implementación, mantenimiento y evolución del producto, asegurando que cada componente responda a los requisitos funcionales y no funcionales definidos durante las etapas de análisis y planificación. :contentReference[oaicite:1]{index=1}

El diseño del sistema se basa en una arquitectura en capas utilizando el patrón **Modelo–Vista–Controlador (MVC)**, permitiendo separar la lógica de negocio, la presentación y el acceso a datos. Esta organización facilita la mantenibilidad del código, la reutilización de componentes y la incorporación de nuevas funcionalidades sin afectar el comportamiento del resto de la aplicación. :contentReference[oaicite:2]{index=2}

La solución se implementa utilizando **PHP** como lenguaje del lado del servidor, **Apache** como servidor web ejecutado sobre XAMPP y **MySQL/MariaDB** como sistema gestor de base de datos. La persistencia de la información se realiza mediante **PDO** y consultas parametrizadas, reduciendo el riesgo de inyección SQL y fortaleciendo la seguridad de la aplicación. :contentReference[oaicite:3]{index=3}

El sistema integra los procesos de reserva pública, validación de pagos mediante vouchers, recepción de clientes, administración de mesas, gestión de lista de espera, registro de pedidos, control de caja, administración de usuarios y generación de reportes gerenciales, garantizando la trazabilidad entre los procesos del negocio y los módulos implementados. :contentReference[oaicite:4]{index=4}

## Contenido del Documento de Diseño de Software

El SDD desarrolla de manera estructurada los principales componentes técnicos del sistema:

- Arquitectura general del sistema.
- Principios de diseño arquitectónico aplicados.
- Diseño modular y organización de responsabilidades.
- Modelo de base de datos.
- Diseño de componentes.
- Diseño de navegación.
- Diseño de interfaces de usuario.
- Diseño de seguridad.
- Diseño de persistencia.
- Diseño de calidad.
- Diseño de flujo de datos.
- Diseño de despliegue.
- Estrategias de escalabilidad y mantenibilidad. :contentReference[oaicite:5]{index=5}

Cada uno de estos elementos se encuentra documentado siguiendo un enfoque coherente con la arquitectura seleccionada y mantiene la trazabilidad con los requisitos del negocio, el Product Backlog y las historias de usuario desarrolladas durante los diferentes Sprints del proyecto. :contentReference[oaicite:6]{index=6}

## Arquitectura del sistema

La arquitectura del sistema organiza los componentes de la aplicación mediante una estructura MVC que distribuye claramente las responsabilidades entre presentación, lógica de negocio y acceso a datos.

El flujo general de procesamiento inicia con la solicitud realizada por el usuario desde la interfaz web. Posteriormente, el sistema valida la sesión activa y los permisos asociados al rol del usuario antes de ejecutar la lógica correspondiente. Los controladores coordinan la operación solicitada, los modelos administran la interacción con la base de datos mediante PDO y las vistas presentan la información procesada al usuario final. Este esquema reduce el acoplamiento entre componentes y facilita la evolución del sistema durante futuras iteraciones. :contentReference[oaicite:7]{index=7}

## Diseño técnico

El diseño técnico prioriza la modularidad, la reutilización de componentes y la separación de responsabilidades. Cada módulo funcional implementa únicamente las operaciones relacionadas con su dominio, favoreciendo la mantenibilidad y simplificando las actividades de prueba y depuración.

Asimismo, el diseño incorpora mecanismos de autenticación, autorización basada en roles, protección CSRF, validación de entradas, control de sesiones y escape de salida, alineando la implementación con las recomendaciones de seguridad para aplicaciones web transaccionales. :contentReference[oaicite:8]{index=8}

## Documentación complementaria

El desarrollo completo del Documento de Diseño de Software se encuentra disponible en el archivo **`sdd.md`**, donde se describen en detalle todos los componentes técnicos, la arquitectura, los módulos funcionales, el modelo de datos, las interfaces, la seguridad, la persistencia, el despliegue y las estrategias de mantenimiento del sistema.

Los diagramas de arquitectura, casos de uso, actividades, modelo de dominio y flujo general del sistema se presentan en el **Anexo C**, complementando la documentación técnica del proyecto y proporcionando la representación gráfica del diseño implementado. :contentReference[oaicite:9]{index=9}
