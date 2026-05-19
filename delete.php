<?php
/**
 * delete.php
 * Project: simple-crud-php-pdo
 * Description:
 *  - Deletes a user record from the "users" table (DELETE operation).
 *
 * PHP functions and methods used:
 * - include_once: https://www.php.net/manual/en/function.include-once.php
 * - header: https://www.php.net/manual/en/function.header.php
 * - exit: https://www.php.net/manual/en/function.exit.php
 * - PDO::prepare: https://www.php.net/manual/en/pdo.prepare.php
 * - PDOStatement::bindParam: https://www.php.net/manual/en/pdostatement.bindparam.php
 * - PDOStatement::execute: https://www.php.net/manual/en/pdostatement.execute.php
 */

// Include the database connection configuration
include_once("connection.php");

// Retrieve the ID of the record to delete from the GET parameter
$id = $_GET["id"];

// Delete query with named placeholder to avoid SQL injection
$query = "DELETE FROM users WHERE id = :id";

// Prepare the database delete statement
$stmt = $dbConn->prepare($query);

// Bind the ID parameter to the placeholder
$stmt->bindParam(":id", $id);

// Execute the statement to remove the record
$stmt->execute();

// Redirect back to the main dashboard (read.php)
header("Location: read.php");
exit();
?>
