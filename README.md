# Sistema de Topico Institucional

Este proyecto consiste en un sistema web desarrollado para la gestión del Tópico de una institución educativa. Permite registrar atenciones médicas, insumos utilizados, procedimientos realizados y personal responsable. El sistema fue implementado utilizando PHP, MySQL, JavaScript y HTML, bajo la metodología ágil Extreme Programming (XP).

## Características

- **Gestión de inventario**: Control de insumos y su salida para diferentes atenciones.
- **Registro de atenciones**: Asocia pacientes, procedimientos y responsables en un solo lugar.
- **Notificaciones de Stock**: Alertas de inventario para mantener stock suficiente.
- **Impresión de reportes**: Generación de informes imprimibles para documentación y auditoría.

## Requisitos de instalación

- **PHP** 7.4 o superior
- **MySQL** 5.7 o superior
- Servidor web compatible con **Apache** y soporte para `.htaccess`
- Librerías adicionales: JavaScript (incluyendo SweetAlert para ventanas emergentes)

## Instalación

1. **Sube el proyecto al servidor**: Asegúrate de que todos los archivos están en el directorio raíz de tu servidor o en el directorio deseado.
2. **Configura la base de datos**:
   - Crea una base de datos en tu servidor y ejecuta los scripts de tablas incluidos en el proyecto.
   - Configura el archivo `conexion.php` (o el archivo de conexión) con tus credenciales de MySQL.
3. **Configura `.htaccess`**: Si no tienes HTTPS, comenta la línea que redirige a HTTPS.
4. **Prueba el sistema**: Accede a la URL del proyecto en tu navegador y verifica que todo funcione correctamente.

## Estructura del Proyecto

- `/admin`: Archivos de administración y gestión del sistema.
- `/assets`: Archivos de imágenes, CSS y JavaScript.
- `/includes`: Archivos de configuración y funciones comunes.
- `/index.php`: Página de inicio del sistema.
  
## Uso

Para registrar una nueva atención:
1. Dirígete a la sección "Registrar Atención".
2. Completa los detalles del paciente, insumos y procedimiento.
3. Guarda la atención para actualizar el inventario automáticamente.

## Soporte

Para preguntas o soporte técnico, contacta a [angelchoccaramos@gmail.com].

## Créditos

Este sistema fue desarrollado por [Angel Chocca Ramos].
