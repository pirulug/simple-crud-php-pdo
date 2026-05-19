<?php
/**
 * create.php
 * Project: simple-crud-php-pdo
 * Description:
 *  - Handles both the creation HTML form and form submission (CREATE operation).
 *  - If the form is submitted via POST, it validates inputs, binds parameters to prevent SQL injection,
 *    and inserts the new record.
 *  - Otherwise, it displays the HTML entry form.
 *
 * PHP functions and methods used:
 * - isset: https://www.php.net/manual/en/function.isset.php
 * - empty: https://www.php.net/manual/en/function.empty.php
 * - exit: https://www.php.net/manual/en/function.exit.php
 * - PDO::prepare: https://www.php.net/manual/en/pdo.prepare.php
 * - PDOStatement::bindParam: https://www.php.net/manual/en/pdostatement.bindparam.php
 * - PDOStatement::execute: https://www.php.net/manual/en/pdostatement.execute.php
 */

// Include the database connection settings
include_once("connection.php");

/**
 * =========================================================
 * PART 1: PROCESS FORM SUBMISSION (POST)
 * =========================================================
 */
if (isset($_POST["Submit"])) {

  // Capture the input values
  $name  = $_POST["name"];
  $age   = $_POST["age"];
  $email = $_POST["email"];

  // Perform fundamental validation
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

    // Provide a return path to the creation form
    echo "<br/><a href=\"javascript:self.history.back();\">Go Back</a>";

  } else {

    // SQL statement with named placeholders to prevent SQL injection
    $query = "INSERT INTO users (name, age, email) VALUES (:name, :age, :email)";

    // Prepare the statement
    $stmt = $dbConn->prepare($query);

    // Bind parameters to the query
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":email", $email);

    // Execute the database insert action
    $stmt->execute();

    // Display a success message, link back to the list, and exit
    echo "<font color=\"green\">Data added successfully.</font>";
    echo "<br/><a href=\"read.php\">View Results</a>";
    exit();
  }
}
?>

<!--
  =========================================================
  PART 2: DISPLAY FORM (GET / DEFAULT STATE)
  =========================================================
-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add User (Create)</title>
</head>
<body>

  <!-- Link back to the main directory -->
  <a href="read.php">Home</a>
  <br><br>

  <!--
    HTML Form pointing back to create.php
  -->
  <form action="create.php" method="post" name="form1">

    <table width="25%" border="0">

      <tr>
        <td>Name</td>
        <td>
          <input type="text" name="name">
        </td>
      </tr>

      <tr>
        <td>Age</td>
        <td>
          <input type="number" name="age">
        </td>
      </tr>

      <tr>
        <td>Email</td>
        <td>
          <input type="email" name="email">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>
          <input type="submit" name="Submit" value="Add User">
        </td>
      </tr>

    </table>

  </form>

</body>
</html>
