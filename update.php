<?php
/**
 * update.php
 * Project: simple-crud-php-pdo
 * Description:
 *  - Edit an existing user record (UPDATE operation).
 *  - Handles two states:
 *      1) POST request: updates user information in the database.
 *      2) GET request: fetches existing user data to pre-populate the HTML form.
 *
 * PHP functions and methods used:
 * - isset: https://www.php.net/manual/en/function.isset.php
 * - empty: https://www.php.net/manual/en/function.empty.php
 * - exit: https://www.php.net/manual/en/function.exit.php
 * - PDO::prepare: https://www.php.net/manual/en/pdo.prepare.php
 * - PDOStatement::bindParam: https://www.php.net/manual/en/pdostatement.bindparam.php
 * - PDOStatement::execute: https://www.php.net/manual/en/pdostatement.execute.php
 * - PDOStatement::fetch: https://www.php.net/manual/en/pdostatement.fetch.php
 */

// Include database connection settings
include_once("config.php");

/**
 * =========================================================
 * PART 1: PROCESS DATA UPDATE (POST)
 * =========================================================
 */
if (isset($_POST["update"])) {

  // Capture the form parameters
  $id    = $_POST["id"];
  $name  = $_POST["name"];
  $age   = $_POST["age"];
  $email = $_POST["email"];

  // Perform fundamental check for empty inputs
  if (empty($name) || empty($age) || empty($email)) {

    if (empty($name)) {
      echo "<font color=\"red\">The Name field is empty.</font><br/>";
    }

    if (empty($age)) {
      echo "<font color=\"red\">The Age field is empty.</font><br/>";
    }

    if (empty($email)) {
      echo "<font color=\"red\">The Email field is empty.</font><br/>";
    }

  } else {

    // SQL update query with named parameters to safeguard against injection
    $sql = "UPDATE users SET name = :name, age = :age, email = :email WHERE id = :id";

    // Prepare the SQL statement
    $query = $dbConn->prepare($sql);

    // Bind parameters to the query
    $query->bindParam(":id", $id);
    $query->bindParam(":name", $name);
    $query->bindParam(":age", $age);
    $query->bindParam(":email", $email);

    // Run the update statement
    $query->execute();

    // Direct the user back to the list and terminate the script
    echo "<font color=\"green\">Data updated successfully.</font>";
    echo "<br/><a href=\"read.php\">View Results</a>";
    exit();
  }
}
?>

<?php
/**
 * =========================================================
 * PART 2: FETCH EXISTING RECORD FOR VIEW (GET)
 * =========================================================
 */

// Retrieve the ID parameter from the URL query parameters
$id = $_GET["id"];

// SQL command to retrieve specific user data
$query = "SELECT * FROM users WHERE id = :id";

// Prepare and run the select statement
$stmt = $dbConn->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();

// Fetch the single database record as an object
$user = $stmt->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit User (Update)</title>
</head>
<body>

  <!-- Link back to dashboard -->
  <a href="read.php">Back to Home</a>
  <br><br>

  <!--
    HTML Form prefilled with existing user details
  -->
  <form method="post" action="update.php">
    <table border="0">

      <tr>
        <td>Name</td>
        <td>
          <input type="text" name="name" value="<?= $user->name ?>">
        </td>
      </tr>

      <tr>
        <td>Age</td>
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
        <!-- Hidden input field to store the primary ID -->
        <td>
          <input type="hidden" name="id" value="<?= $user->id ?>">
        </td>
        <td>
          <input type="submit" name="update" value="Update User">
        </td>
      </tr>

    </table>
  </form>

</body>
</html>
