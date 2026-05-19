<?php
/**
 * read.php
 * Project: simple-crud-php-pdo
 * Description:
 *  - Main dashboard of the CRUD application (READ operation).
 *  - Fetches and displays all user records from the database in descending order of ID.
 *
 * PHP functions and structures used:
 * - include_once: https://www.php.net/manual/en/function.include-once.php
 * - PDO::prepare: https://www.php.net/manual/en/pdo.prepare.php
 * - PDOStatement::execute: https://www.php.net/manual/en/pdostatement.execute.php
 * - PDOStatement::fetchAll: https://www.php.net/manual/en/pdostatement.fetchall.php
 */

// Include the database configuration file to establish the PDO connection ($dbConn)
include_once("connection.php");

// Formulate the SQL query to select all records from the "users" table ordered by the newest first
$query = "SELECT * FROM users ORDER BY id DESC";

// Prepare the SQL statement to prevent SQL injection
$stmt = $dbConn->prepare($query);

// Execute the prepared statement
$stmt->execute();

// Retrieve all records as objects (FETCH_OBJ)
$users = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Directory (Read)</title>
</head>
<body>

  <!-- Link to the CREATE form -->
  <a href="create.php">Add New User</a>
  <br><br>

  <!-- Table to display the list of users -->
  <table width="80%" border="0">

    <!-- Table header -->
    <tr bgcolor="#CCCCCC">
      <td>Name</td>
      <td>Age</td>
      <td>Email</td>
      <td>Actions</td>
    </tr>

    <?php
    /**
     * Loop through the retrieved users array.
     * Each $user represents a row in the "users" table as an object.
     *
     * Official documentation:
     * - foreach: https://www.php.net/manual/en/control-structures.foreach.php
     */
    foreach ($users as $user):
    ?>
      <tr>
        <!-- Access properties of the user object -->
        <td><?= $user->name ?></td>
        <td><?= $user->age ?></td>
        <td><?= $user->email ?></td>

        <!-- CRUD Actions: Update and Delete -->
        <td>
          <a href="update.php?id=<?= $user->id ?>">Edit</a> |
          <a href="delete.php?id=<?= $user->id ?>" onClick="return confirm('Are you sure you want to delete this record?')">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>

  </table>

</body>
</html>
