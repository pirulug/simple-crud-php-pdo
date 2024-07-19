<?php
//including the database connection file
include_once ("config.php");

//fetching data in descending order (lastest entry first)
$query = ("SELECT * FROM users ORDER BY id DESC");
$stmt  = $dbConn->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<html>

<head>
	<title>Homepage</title>
</head>

<body>
	<a href="add.html">Add New Data</a><br /><br />

	<table width='80%' border=0>

		<tr bgcolor='#CCCCCC'>
			<td>Name</td>
			<td>Age</td>
			<td>Email</td>
			<td>Update</td>
		</tr>
		<?php foreach ($users as $user): ?>
			<tr>
				<td><?= $user->name ?></td>
				<td><?= $user->age ?></td>
				<td><?= $user->email ?></td>
				<td>
					<a href="edit.php?id=<?= $user->id ?>">Edit</a> |
					<a href="delete.php?id=<?= $user->id ?>" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</body>

</html>