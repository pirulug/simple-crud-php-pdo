<?php
/**
 * ---------------------------------------------------------
 * config.php
 * Proyecto: simple-crud-php-pdo
 * Descripción:
 *  - Archivo de configuración de la base de datos.
 *  - Se encarga de crear la conexión a MySQL usando PDO.
 *  - Este archivo se incluye en todos los scripts que
 *    necesiten acceder a la base de datos.
 * ---------------------------------------------------------
 */

/**
 * ---------------------------------------------------------
 * DATOS DE CONEXIÓN
 * ---------------------------------------------------------
 * Ajusta estos valores según tu entorno:
 *  - localhost      → servidor de base de datos
 *  - test           → nombre de la base de datos
 *  - root           → usuario de MySQL
 *  - ''             → contraseña (vacía en entornos locales)
 */
$databaseHost     = 'localhost';
$databaseName     = 'test';
$databaseUsername = 'root';
$databasePassword = '';

/**
 * ---------------------------------------------------------
 * BLOQUE TRY / CATCH
 * ---------------------------------------------------------
 * - try: intenta realizar la conexión a la base de datos
 * - catch: captura errores si la conexión falla
 * - PDOException es la excepción específica de PDO
 */
try {

	/**
	 * ---------------------------------------------------------
	 * CREACIÓN DEL OBJETO PDO
	 * ---------------------------------------------------------
	 * - Se crea una nueva instancia de PDO
	 * - DSN (Data Source Name) indica:
	 *      • tipo de base de datos (mysql)
	 *      • host (servidor)
	 *      • dbname (nombre de la base de datos)
	 *
	 * Documentación oficial:
	 * https://www.php.net/manual/es/pdo.connections.php
	 */
	$dbConn = new PDO(
		"mysql:host={$databaseHost};dbname={$databaseName}",
		$databaseUsername,
		$databasePassword
	);

	/**
	 * ---------------------------------------------------------
	 * CONFIGURACIÓN DE ATRIBUTOS PDO
	 * ---------------------------------------------------------
	 * - PDO::ATTR_ERRMODE define cómo PDO maneja los errores
	 * - PDO::ERRMODE_EXCEPTION:
	 *      • Lanza excepciones cuando ocurre un error
	 *      • Facilita la depuración y control de fallos
	 *
	 * Documentación:
	 * https://www.php.net/manual/es/pdo.setattribute.php
	 */
	$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

	/**
	 * ---------------------------------------------------------
	 * MANEJO DE ERRORES
	 * ---------------------------------------------------------
	 * - Si la conexión falla, se muestra el mensaje de error
	 * - En proyectos reales se recomienda:
	 *      • Registrar el error en un log
	 *      • No mostrar detalles sensibles al usuario final
	 */
	echo $e->getMessage();
}
