-- ---------------------------------------------------------
-- database.sql
-- Proyecto: simple-crud-php-pdo
-- Descripción:
--  - Crea la base de datos `test`
--  - Crea la tabla `users`
--  - Estructura utilizada por todo el CRUD en PHP (PDO)
-- ---------------------------------------------------------

-- Crear la base de datos
CREATE DATABASE test;

-- Seleccionar la base de datos
USE test;

-- ---------------------------------------------------------
-- Tabla: users
-- ---------------------------------------------------------
-- Esta tabla almacena los datos básicos de los usuarios
-- que serán gestionados por el CRUD.
--
-- Campos:
--  id    → Identificador único (clave primaria)
--  name  → Nombre del usuario
--  age   → Edad del usuario
--  email → Correo electrónico
-- ---------------------------------------------------------
CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  age INT(3) NOT NULL,
  email VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
);
