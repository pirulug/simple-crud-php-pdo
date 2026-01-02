# Simple CRUD PHP + MySQL usando PDO

Este proyecto es un ejemplo educativo de un sistema **CRUD (Create, Read, Update, Delete)** desarrollado con **PHP** y **MySQL** utilizando **PDO (PHP Data Objects)**.

El objetivo principal es **enseñar paso a paso** cómo conectar PHP con MySQL usando PDO, cómo trabajar con consultas preparadas y cómo manejar resultados con `PDO::FETCH_OBJ`.

- - -

## Características del proyecto

*   Conexión segura a MySQL usando PDO
*   Consultas preparadas (`prepare()`)
*   Uso de parámetros con `bindParam()`
*   Obtención de datos como objetos (`FETCH_OBJ`)
*   Separación clara entre HTML y PHP
*   Estructura simple y fácil de entender

- - -

## Requisitos

*   Servidor web (Apache recomendado)
*   PHP 7.4 o superior
*   MySQL o MariaDB
*   Conocimientos básicos de HTML y PHP

- - -

## Instalación y configuración

1.  Clonar o descargar el proyecto en tu equipo.
2.  Importar el archivo `database.sql` en MySQL.
3.  Editar el archivo `config.php` y configurar:
    *   Host
    *   Nombre de la base de datos
    *   Usuario
    *   Contraseña
4.  Colocar el proyecto en el directorio público del servidor.
5.  Iniciar Apache y MySQL.

- - -

## Uso del sistema

1.  Abrir el navegador y acceder a `index.php`.
2.  Agregar registros usando **Agregar nuevo registro**.
3.  Editar registros con el botón **Editar**.
4.  Eliminar registros con el botón **Eliminar**.
5.  Visualizar todos los registros en la tabla principal.

- - -

## Estructura de archivos

*   `add.html` – Formulario HTML para crear registros
*   `add.php` – Inserta datos en la base de datos (CREATE)
*   `config.php` – Conexión a MySQL usando PDO
*   `index.php` – Lista los registros (READ)
*   `edit.php` – Edita registros existentes (UPDATE)
*   `delete.php` – Elimina registros (DELETE)

- - -

## Conceptos enseñados

*   Uso correcto de PDO en PHP
*   Consultas SQL seguras
*   Flujo CRUD completo
*   Trabajo con objetos en PHP
*   Separación lógica entre vista y procesamiento

- - -

## Nota importante

Este proyecto es **educativo**. Antes de usarlo en producción se recomienda:

*   Validaciones más robustas
*   Manejo de errores con logs
*   Protección contra CSRF
*   Filtros y sanitización avanzada

- - -

## Objetivo final

Servir como base clara y comprensible para estudiantes que desean aprender cómo funciona un CRUD real en PHP usando PDO y buenas prácticas básicas.