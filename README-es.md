# CRUD en PHP con PDO para Principiantes

[Read in English (English version)](README.md)

¡Bienvenido a esta guía diseñada para principiantes! Este proyecto es un sistema **CRUD (Crear, Leer, Actualizar, Eliminar)** simple y educativo desarrollado con **PHP** y **MySQL** utilizando **PDO (PHP Data Objects)**.

Si estás dando tus primeros pasos en el desarrollo web backend, esta guía te enseñará de forma clara cómo interactúa PHP con una base de datos de manera segura.

---

## ¿Qué es CRUD?

CRUD hace referencia a las cuatro operaciones fundamentales que puedes realizar con los datos:
* **C**reate (Crear): Insertar nuevos registros en la base de datos.
* **R**ead (Leer): Obtener y mostrar registros existentes.
* **U**pdate (Actualizar): Modificar registros guardados.
* **D**elete (Eliminar): Borrar registros de la base de datos.

---

## 1. Conexión a la Base de Datos (`connection.php`)

Para realizar cualquier operación con la base de datos, PHP debe conectarse a MySQL. Usamos **PDO (PHP Data Objects)** porque es seguro, moderno y compatible con múltiples motores de bases de datos.

Este es el código de conexión:

```php
<?php
$databaseHost     = "localhost";
$databaseName     = "test";
$databaseUsername = "root";
$databasePassword = "";

try {
  // 1. Crear una nueva instancia de PDO
  $dbConn = new PDO(
    "mysql:host={$databaseHost};dbname={$databaseName}",
    $databaseUsername,
    $databasePassword
  );

  // 2. Configurar PDO para lanzar excepciones cuando ocurra un error
  $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
  // 3. Capturar errores para evitar la filtración de credenciales
  echo $e->getMessage();
}
?>
```

### Conceptos Clave para Principiantes:
* `new PDO(...)`: Conecta PHP con MySQL. Los detalles de la conexión se denominan **DSN (Data Source Name)**.
* `try { ... } catch (PDOException $e) { ... }`: Un bloque para capturar errores. Si la conexión falla, se ejecuta el código dentro de `catch`. Esto evita que tu contraseña de base de datos se muestre en el navegador como parte del error.
* `setAttribute(...)`: Le indica a PDO que nos alerte con una "Excepción" cada vez que una consulta falle, lo cual facilita mucho la depuración.

---

## 2. Operación CREAR (`create.php`)

Esta página muestra el formulario y procesa el envío de datos. Para agregar un usuario de forma segura, utilizamos **Consultas Preparadas**.

Así es como se insertan los datos:

```php
<?php
// Incluir la conexión a la base de datos
include_once("connection.php");

// 1. Verificar si el usuario presionó el botón de enviar
if (isset($_POST["Submit"])) {
  $name  = $_POST["name"];
  $age   = $_POST["age"];
  $email = $_POST["email"];

  // 2. Validación simple
  if (!empty($name) && !empty($age) && !empty($email)) {

    // 3. Preparar la consulta SQL con marcadores
    $query = "INSERT INTO users (name, age, email) VALUES (:name, :age, :email)";
    $stmt = $dbConn->prepare($query);

    // 4. Enlazar variables a los marcadores de forma segura
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":email", $email);

    // 5. Ejecutar la consulta
    $stmt->execute();
  }
}
?>
```

### Conceptos Clave para Principiantes:
* `$_POST`: Una variable especial de PHP (llamada **superglobal**) que recopila los datos enviados desde un formulario HTML mediante el método `"post"`.
* **Inyección SQL**: Insertar variables directamente en una consulta SQL es sumamente peligroso (ej. `INSERT INTO users VALUES ('$name')`). Los atacantes podrían inyectar comandos dañinos.
* **Consultas Preparadas (`prepare()`)**: Usamos marcadores de posición (`:name`, `:age`, `:email`) en lugar de variables directas. La base de datos compila primero la estructura de la consulta de forma segura.
* `bindParam()`: Asegura y limpia la entrada del usuario antes de vincularla a los marcadores de la consulta.

---

## 3. Operación LEER (`read.php`)

Este archivo es nuestro panel principal, el cual recupera todos los registros de usuarios y los presenta dentro de una tabla HTML.

Este es el código de obtención de datos:

```php
<?php
// Incluir la conexión a la base de datos
include_once("connection.php");

// 1. Preparar la consulta de selección (los más nuevos primero)
$query = "SELECT * FROM users ORDER BY id DESC";
$stmt = $dbConn->prepare($query);

// 2. Ejecutar la consulta
$stmt->execute();

// 3. Recuperar todos los resultados como una lista de Objetos PHP
$users = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
```

Y así es como los mostramos en HTML:

```php
<table width="80%" border="0">
  <tr bgcolor="#CCCCCC">
    <td>Nombre</td>
    <td>Edad</td>
    <td>Email</td>
    <td>Acciones</td>
  </tr>

  <?php foreach ($users as $user): ?>
    <tr>
      <!-- Acceder a las propiedades de cada registro tipo objeto -->
      <td><?= $user->name ?></td>
      <td><?= $user->age ?></td>
      <td><?= $user->email ?></td>
      <td>
        <a href="update.php?id=<?= $user->id ?>">Editar</a> |
        <a href="delete.php?id=<?= $user->id ?>">Eliminar</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
```

### Conceptos Clave para Principiantes:
* `fetchAll(PDO::FETCH_OBJ)`: Le indica a PDO que devuelva todas las filas como una lista de **Objetos** de PHP. Esto nos permite usar la sintaxis de flecha (`$user->name`).
* `foreach ($users as $user)`: Un bucle que recorre y procesa cada objeto de usuario de la tabla de forma individual.
* `<?= $user->name ?>`: Sintaxis abreviada de `<?php echo $user->name; ?>` para imprimir valores directamente en el HTML.

---

## 4. Operación ACTUALIZAR (`update.php`)

Para editar un registro debemos:
1. Obtener la información actual mediante una petición **GET** (`update.php?id=5`) para pre-rellenar el formulario.
2. Guardar los cambios mediante una petición **POST** al presionar el botón de actualizar.

### Parte A: Obtener Datos Actuales (GET)
```php
<?php
// Obtener el "id" desde la barra de direcciones (URL)
$id = $_GET["id"];

// Buscar al usuario que coincida con ese ID
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $dbConn->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();

// fetch() obtiene un único registro como objeto
$user = $stmt->fetch(PDO::FETCH_OBJ);
?>
```

### Parte B: Guardar los Cambios (POST)
```php
<?php
if (isset($_POST["update"])) {
  $id    = $_POST["id"];
  $name  = $_POST["name"];
  $age   = $_POST["age"];
  $email = $_POST["email"];

  // Preparar y ejecutar la instrucción de actualización
  $sql = "UPDATE users SET name = :name, age = :age, email = :email WHERE id = :id";
  $query = $dbConn->prepare($sql);
  $query->bindParam(":id", $id);
  $query->bindParam(":name", $name);
  $query->bindParam(":age", $age);
  $query->bindParam(":email", $email);
  $query->execute();
}
?>
```

### Conceptos Clave para Principiantes:
* `$_GET["id"]`: Recopila información de los parámetros de la URL (ej. `?id=5`).
* `fetch(PDO::FETCH_OBJ)`: A diferencia de `fetchAll`, `fetch` recupera una sola fila, lo cual es ideal ya que cada ID es único.
* `<input type="hidden" name="id" value="<?= $user->id ?>">`: Guardamos el ID en un campo oculto del formulario para que `update.php` sepa exactamente qué fila debe modificar.

---

## 5. Operación ELIMINAR (`delete.php`)

Eliminar un usuario requiere recibir su ID mediante GET, borrar la fila correspondiente y redirigir automáticamente al panel de control.

Código de eliminación:

```php
<?php
// Incluir la conexión a la base de datos
include_once("connection.php");

// 1. Obtener el ID del usuario a eliminar
$id = $_GET["id"];

// 2. Preparar la consulta de eliminación
$query = "DELETE FROM users WHERE id = :id";
$stmt = $dbConn->prepare($query);
$stmt->bindParam(":id", $id);

// 3. Ejecutar la instrucción
$stmt->execute();

// 4. Redirigir al usuario al dashboard automáticamente
header("Location: read.php");
exit();
?>
```

### Conceptos Clave para Principiantes:
* `DELETE FROM users WHERE id = :id`: Elimina la fila que coincida con el ID especificado. ¡Si olvidas la cláusula `WHERE id = :id` borrarás **todos** los usuarios de tu base de datos!
* `header("Location: read.php")`: Redirige de inmediato el navegador del usuario a la vista principal.
* `exit()`: Detiene la ejecución del script PHP en el acto para evitar procesamientos adicionales innecesarios.

---

## Notas de Seguridad y Buenas Prácticas
Este proyecto tiene un enfoque puramente **educativo**. En una aplicación profesional, te recomendamos implementar:
1. **Validación Robusta**: Validar y comprobar formatos (ej. verificar si el email es correcto usando `filter_var`).
2. **Protección CSRF**: Usar tokens de seguridad en los formularios para evitar peticiones maliciosas externas en nombre del usuario.
3. **Encriptación de Contraseñas**: Nunca guardes contraseñas en texto plano; usa siempre `password_hash()` de PHP.
