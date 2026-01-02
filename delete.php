<?php
/**
 * ---------------------------------------------------------
 * delete.php
 * Proyecto: simple-crud-php-pdo
 * Descripción:
 *  - Elimina un registro de la tabla `users`
 *  - Ejemplo práctico de:
 *      • DELETE con PDO
 *      • Uso de parámetros con bindParam
 *      • Protección contra SQL Injection
 * ---------------------------------------------------------
 */

// Incluimos el archivo de conexión a la base de datos
include("config.php");

/**
 * ---------------------------------------------------------
 * OBTENER ID DESDE LA URL
 * ---------------------------------------------------------
 * - El ID se recibe mediante GET
 * - Ejemplo: delete.php?id=5
 */
$id = $_GET['id'];

/**
 * ---------------------------------------------------------
 * CONSULTA DELETE CON PARÁMETRO
 * ---------------------------------------------------------
 * - Se utiliza un marcador nombrado (:id)
 * - Evita inyección SQL
 */
$query = "DELETE FROM users WHERE id = :id";

/**
 * PREPARE
 * - Prepara la consulta SQL
 */
$stmt = $dbConn->prepare($query);

/**
 * BINDPARAM
 * - Asocia el valor del ID al parámetro :id
 */
$stmt->bindParam(':id', $id);

/**
 * EXECUTE
 * - Ejecuta la eliminación del registro
 */
$stmt->execute();

/**
 * ---------------------------------------------------------
 * REDIRECCIÓN
 * ---------------------------------------------------------
 * - Luego de eliminar el registro
 * - Se redirige al listado principal
 */
header("Location: index.php");
exit();
