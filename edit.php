<?php
// including the database connection file
include_once ("config.php");

if (isset($_POST['update'])) {
	$id = $_POST['id'];

	$name  = $_POST['name'];
	$age   = $_POST['age'];
	$email = $_POST['email'];

	// checking empty fields
	if (empty($name) || empty($age) || empty($email)) {

		if (empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}

		if (empty($age)) {
			echo "<font color='red'>Age field is empty.</font><br/>";
		}

		if (empty($email)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}
	} else {
		//updating the table
		$sql   = "UPDATE users SET name=:name, age=:age, email=:email WHERE id=:id";
		$query = $dbConn->prepare($sql);

		$query->bindparam(':id', $id);
		$query->bindparam(':name', $name);
		$query->bindparam(':age', $age);
		$query->bindparam(':email', $email);
		$query->execute();

		// Alternative to above bindparam and execute
		// $query->execute(array(':id' => $id, ':name' => $name, ':email' => $email, ':age' => $age));

		//redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$query = "SELECT * FROM users WHERE id=:id";
$stmt  = $dbConn->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_OBJ);

// while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
// 	$name  = $row['name'];
// 	$age   = $row['age'];
// 	$email = $row['email'];
// }
?>
<html>

<head>
	<title>Edit Data</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br /><br />

	<form name="form1" method="post" action="edit.php">
		<table border="0">
			<tr>
				<td>Name</td>
				<td><input type="text" name="name" value="<?= $user->name ?>"></td>
			</tr>
			<tr>
				<td>Age</td>
				<td><input type="number" name="age" value="<?= $user->age ?>"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="email" name="email" value="<?= $user->email ?>"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value="<?= $user->id ?>"></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>

</html>