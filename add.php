<?php
/**
 * ---------------------------------------------------------
 * add.php
 * Proyecto: simple-crud-php-pdo
 * Descripción:
 *  - Procesa el formulario de registro de usuarios
 *  - Inserta un nuevo registro en la tabla `users`
 *  - Ejemplo práctico de:
 *      • INSERT con PDO
 *      • Consultas preparadas
 *      • bindParam + execute
 * ---------------------------------------------------------
 */

// Incluimos el archivo de conexión a la base de datos
include_once("config.php");

/**
 * ---------------------------------------------------------
 * VERIFICAR ENVÍO DEL FORMULARIO
 * ---------------------------------------------------------
 * - El botón submit se llama "Submit"
 * - Solo se ejecuta si el formulario fue enviado
 */
if (isset($_POST['Submit'])) {

	// Capturamos los datos enviados por POST
	$name  = $_POST['name'];
	$age   = $_POST['age'];
	$email = $_POST['email'];

	/**
	 * ---------------------------------------------------------
	 * VALIDACIÓN BÁSICA
	 * ---------------------------------------------------------
	 * - Verifica que ningún campo esté vacío
	 * - Validación simple con fines educativos
	 */
	if (empty($name) || empty($age) || empty($email)) {

		if (empty($name)) {
			echo "<font color='red'>El campo Nombre está vacío.</font><br/>";
		}

		if (empty($age)) {
			echo "<font color='red'>El campo Edad está vacío.</font><br/>";
		}

		if (empty($email)) {
			echo "<font color='red'>El campo Email está vacío.</font><br/>";
		}

		/**
		 * Enlace para volver a la página anterior
		 */
		echo "<br/><a href='javascript:self.history.back();'>Volver</a>";

	} else {

		/**
		 * ---------------------------------------------------------
		 * CONSULTA INSERT CON PARÁMETROS
		 * ---------------------------------------------------------
		 * - Se utilizan marcadores nombrados
		 * - Evita inyección SQL
		 */
		$query = "INSERT INTO users (name, age, email)
		          VALUES (:name, :age, :email)";

		/**
		 * PREPARE
		 * - Prepara la consulta SQL
		 */
		$stmt = $dbConn->prepare($query);

		/**
		 * BINDPARAM
		 * - Enlaza variables PHP con los parámetros SQL
		 */
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':age', $age);
		$stmt->bindParam(':email', $email);

		/**
		 * EXECUTE
		 * - Ejecuta la inserción en la base de datos
		 */
		$stmt->execute();

		/**
		 * ---------------------------------------------------------
		 * MENSAJE DE ÉXITO
		 * ---------------------------------------------------------
		 * - Confirma que el registro fue insertado correctamente
		 */
		echo "<font color='green'>Datos agregados correctamente.</font>";
		echo "<br/><a href='index.php'>Ver resultados</a>";
	}
}
