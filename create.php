<?php
/**
 * create.php
 * Project: simple-crud-php-pdo
 * Description:
 *  - Processes the HTML form data from create.html.
 *  - Inserts a new user record into the "users" table.
 *
 * PHP functions and methods used:
 * - isset: https://www.php.net/manual/en/function.isset.php
 * - empty: https://www.php.net/manual/en/function.empty.php
 * - PDO::prepare: https://www.php.net/manual/en/pdo.prepare.php
 * - PDOStatement::bindParam: https://www.php.net/manual/en/pdostatement.bindparam.php
 * - PDOStatement::execute: https://www.php.net/manual/en/pdostatement.execute.php
 */

// Include the database connection configuration
include_once("config.php");

// Verify if the form was actually submitted
if (isset($_POST["Submit"])) {

  // Capture the POST data fields
  $name  = $_POST["name"];
  $age   = $_POST["age"];
  $email = $_POST["email"];

  // Perform basic validation to ensure no field is empty
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

    // Provide a link to go back to the form page
    echo "<br/><a href=\"javascript:self.history.back();\">Go Back</a>";

  } else {

    // SQL statement with named placeholders to prevent SQL injection
    $query = "INSERT INTO users (name, age, email) VALUES (:name, :age, :email)";

    // Prepare the query using PDO
    $stmt = $dbConn->prepare($query);

    // Bind PHP variables to the SQL query placeholders
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":email", $email);

    // Execute the database insert action
    $stmt->execute();

    // Display a success message and direct the user to the dashboard
    echo "<font color=\"green\">Data added successfully.</font>";
    echo "<br/><a href=\"read.php\">View Results</a>";
  }
}
?>
