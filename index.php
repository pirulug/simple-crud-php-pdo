<?php
/**
 * ---------------------------------------------------------
 * index.php
 * Proyecto: simple-crud-php-pdo
 * Descripción:
 *  - Archivo principal del sistema (homepage).
 *  - Muestra el listado de usuarios almacenados en la base de datos.
 *  - Ejemplo práctico de:
 *      • Conexión a MySQL con PDO
 *      • Consultas preparadas (prepare)
 *      • Ejecución de consultas (execute)
 *      • Obtención de resultados como objetos (FETCH_OBJ)
 * ---------------------------------------------------------
 */

// Incluimos el archivo de configuración donde se crea la conexión PDO
// Normalmente aquí se define $dbConn como instancia de PDO.
include_once("config.php");

/**
 * ---------------------------------------------------------
 * CONSULTA SQL
 * ---------------------------------------------------------
 * - Selecciona todos los registros de la tabla `users`
 * - Ordena los resultados de forma descendente por `id`
 *   (el último registro ingresado se muestra primero)
 */
$query = "SELECT * FROM users ORDER BY id DESC";

/**
 * ---------------------------------------------------------
 * PREPARE
 * ---------------------------------------------------------
 * - prepare() crea una consulta preparada
 * - Previene inyección SQL
 * - Permite reutilizar la consulta
 */
$stmt = $dbConn->prepare($query);

/**
 * ---------------------------------------------------------
 * EXECUTE
 * ---------------------------------------------------------
 * - execute() ejecuta la consulta preparada
 * - En este caso no se envían parámetros, pero sigue siendo buena práctica
 */
$stmt->execute();

/**
 * ---------------------------------------------------------
 * FETCHALL + PDO::FETCH_OBJ
 * ---------------------------------------------------------
 * - fetchAll() obtiene todos los registros
 * - PDO::FETCH_OBJ devuelve cada fila como un OBJETO
 *   Ejemplo de acceso:
 *      $user->name
 *      $user->email
 */
$users = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Página principal</title>
</head>

<body>

	<!-- Enlace para ir al formulario de registro -->
	<a href="add.html">Agregar nuevo registro</a>
	<br><br>

	<!-- Tabla donde se muestran los usuarios -->
	<table width="80%" border="0">

		<!-- Encabezado de la tabla -->
		<tr bgcolor="#CCCCCC">
			<td>Nombre</td>
			<td>Edad</td>
			<td>Email</td>
			<td>Acciones</td>
		</tr>

		<?php
		/**
		 * ---------------------------------------------------------
		 * RECORRIDO DE RESULTADOS
		 * ---------------------------------------------------------
		 * - foreach recorre el arreglo de objetos
		 * - Cada $user representa una fila de la tabla `users`
		 */
		foreach ($users as $user):
		?>
			<tr>
				<!-- Accedemos a las propiedades del objeto -->
				<td><?= $user->name ?></td>
				<td><?= $user->age ?></td>
				<td><?= $user->email ?></td>

				<!-- Acciones CRUD: Editar y Eliminar -->
				<td>
					<a href="edit.php?id=<?= $user->id ?>">Editar</a> |
					<a href="delete.php?id=<?= $user->id ?>"
					   onClick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">
						Eliminar
					</a>
				</td>
			</tr>
		<?php endforeach; ?>

	</table>

</body>
</html>
