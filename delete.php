<?php
//including the database connection file
include ("config.php");

//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table
$query = "DELETE FROM users WHERE id=:id";
$stmt  = $dbConn->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();

//redirecting to the display page (index.php in our case)
header("Location:index.php");
