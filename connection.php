<?php
/**
 * connection.php
 * Project: simple-crud-php-pdo
 * Description:
 *  - Handles database connection configuration.
 *  - Establishes a PDO connection to the MySQL database.
 *  - This file is included in all scripts requiring database access.
 *
 * PHP functions and methods used:
 * - PDO: https://www.php.net/manual/en/pdo.connections.php
 * - PDO::setAttribute: https://www.php.net/manual/en/pdo.setattribute.php
 * - Exception handling (try/catch): https://www.php.net/manual/en/language.exceptions.php
 */

$databaseHost     = "localhost";
$databaseName     = "test";
$databaseUsername = "root";
$databasePassword = "";

try {

  // Establish connection using PDO with DSN details
  $dbConn = new PDO(
    "mysql:host={$databaseHost};dbname={$databaseName}",
    $databaseUsername,
    $databasePassword
  );

  // Set the error mode attribute to exceptions for better debugging
  $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

  // Output the error message if the connection fails
  echo $e->getMessage();
}
?>
