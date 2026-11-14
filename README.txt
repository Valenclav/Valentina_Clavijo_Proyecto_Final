# CINECENTRO
Sistema de gestión de usuarios

Proyecto:Trabajo Práctico Final de Informática  
Curso:4.º Año  
Institución:Instituto Sagrado Corazón 
Profesor:Alan Acosta

1. Descripción del proyecto

CineCentro es una página web de un cine que cuenta con un sistema de registro, inicio de sesión y administración de usuarios.
Los usuarios pueden crear una cuenta, iniciar sesión y consultar sus datos personales. También existe un panel administrativo para gestionar las cuentas.

2. Tecnologías utilizadas

- HTML para la estructura de las páginas.
- CSS para el diseño.
- PHP para la programación.
- MySQL para guardar los datos.
- PDO para conectar PHP con la base de datos.
- XAMPP para ejecutar el proyecto localmente.
- Visual Studio Code para escribir el código.

3. Instalación y ejecución

1. Instalar XAMPP.
2. Copiar la carpeta `CineTickets` dentro de la carpeta `htdocs`.
3. Abrir XAMPP e iniciar Apache y MySQL.
4. Entrar a phpMyAdmin desde el navegador.
5. Crear o importar la base de datos utilizando el archivo `cinecentro.sql`, ubicado en la carpeta `base_de_datos`.
6. Revisar los datos de conexión en `conexion.php`.
7. Abrir el navegador y entrar a:
`http://localhost/CineTickets/`

 4. Funcionalidades

- Registro de usuarios.
- Inicio y cierre de sesión.
- Panel personal.
- Panel administrativo.
- Búsqueda de usuarios.
- Edición de datos.
- Archivado de cuentas.
- Reactivación de usuarios.

5. Seguridad

- Contraseñas protegidas con `password_hash()`.
- Verificación de contraseñas con `password_verify()`.
- Consultas preparadas mediante PDO.
- Control de sesiones.
- Verificación de permisos de administrador.
- Validación de datos y protección de formularios.

6. Base de datos
La base de datos se llama `cinecentro` y contiene la tabla `usuarios`, donde se almacenan los datos de las cuentas.

7. Objetivo
El objetivo fue aplicar los conocimientos aprendidos durante el año y desarrollar un sistema web que permita registrar, consultar y administrar usuarios.