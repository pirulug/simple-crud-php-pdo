<?php
/**
 * ---------------------------------------------------------
 * edit.php
 * Proyecto: simple-crud-php-pdo
 * Descripción:
 *  - Permite editar un registro existente de la tabla `users`.
 *  - Cumple dos funciones:
 *      1) Procesar el formulario (UPDATE)
 *      2) Obtener los datos actuales del usuario (SELECT)
 * ---------------------------------------------------------
 */

// Incluimos el archivo de conexión PDO
include_once("config.php");

/**
 * =========================================================
 * PARTE 1: PROCESAR ACTUALIZACIÓN (UPDATE)
 * =========================================================
 * - Se ejecuta cuando el formulario es enviado por POST
 * - El botón submit se llama "update"
 */
if (isset($_POST['update'])) {

	// Obtenemos el ID del registro a actualizar
	$id = $_POST['id'];

	// Recibimos los datos del formulario
	$name  = $_POST['name'];
	$age   = $_POST['age'];
	$email = $_POST['email'];

	/**
	 * ---------------------------------------------------------
	 * VALIDACIÓN BÁSICA
	 * ---------------------------------------------------------
	 * - Verifica que ningún campo esté vacío
	 * - Este ejemplo es intencionalmente simple para enseñanza
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

	} else {

		/**
		 * ---------------------------------------------------------
		 * CONSULTA UPDATE CON PARÁMETROS
		 * ---------------------------------------------------------
		 * - Se utilizan marcadores nombrados (:name, :age, etc.)
		 * - Evita inyección SQL
		 */
		$sql = "UPDATE users 
		        SET name = :name, 
		            age = :age, 
		            email = :email 
		        WHERE id = :id";

		/**
		 * PREPARE
		 * - Prepara la consulta SQL
		 */
		$query = $dbConn->prepare($sql);

		/**
		 * BINDPARAM
		 * - Asocia variables PHP con los parámetros SQL
		 * - bindParam enlaza por referencia
		 */
		$query->bindParam(':id', $id);
		$query->bindParam(':name', $name);
		$query->bindParam(':age', $age);
		$query->bindParam(':email', $email);

		/**
		 * EXECUTE
		 * - Ejecuta la consulta preparada
		 */
		$query->execute();

		/**
		 * ---------------------------------------------------------
		 * REDIRECCIÓN
		 * ---------------------------------------------------------
		 * - Una vez actualizado el registro
		 * - Mensaje de éxito y enlace al listado
		 * - Enlace para volver a la página principal (index.php)
		 * - Se usa exit() para asegurar que no se ejecute código adicional
		 */

		echo "<font color='green'>Datos actualizados correctamente.</font>";
		echo "<br/><a href='index.php'>Ver resultados</a>";
		exit();
	}
}
?>

<?php
/**
 * =========================================================
 * PARTE 2: OBTENER DATOS ACTUALES (SELECT)
 * =========================================================
 * - Se ejecuta cuando se accede a edit.php?id=XX
 * - Recupera los datos del usuario para mostrarlos en el formulario
 */

// Obtenemos el ID desde la URL (GET)
$id = $_GET['id'];

/**
 * CONSULTA SELECT CON PARÁMETRO
 */
$query = "SELECT * FROM users WHERE id = :id";

/**
 * PREPARE + BINDPARAM + EXECUTE
 */
$stmt = $dbConn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();

/**
 * FETCH CON PDO::FETCH_OBJ
 * - Devuelve un solo registro como objeto
 */
$user = $stmt->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Editar usuario</title>
</head>

<body>

	<a href="index.php">Volver al inicio</a>
	<br><br>

	<!--
		Formulario de edición
		- Los campos se rellenan con los datos actuales del usuario
	-->
	<form method="post" action="edit.php">
		<table border="0">

			<tr>
				<td>Nombre</td>
				<td>
					<input type="text" name="name" value="<?= $user->name ?>">
				</td>
			</tr>

			<tr>
				<td>Edad</td>
				<td>
					<input type="number" name="age" value="<?= $user->age ?>">
				</td>
			</tr>

			<tr>
				<td>Email</td>
				<td>
					<input type="email" name="email" value="<?= $user->email ?>">
				</td>
			</tr>

			<tr>
				<!-- ID oculto para identificar el registro -->
				<td>
					<input type="hidden" name="id" value="<?= $user->id ?>">
				</td>
				<td>
					<input type="submit" name="update" value="Actualizar">
				</td>
			</tr>

		</table>
	</form>

</body>
</html>
