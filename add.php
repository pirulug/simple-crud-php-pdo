<html>

<head>
	<title>Add Data</title>
</head>

<body>
	<?php
	//including the database connection file
	include_once ("config.php");

	if (isset($_POST['Submit'])) {
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

			//link to the previous page
			echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
		} else {
			// if all the fields are filled (not empty) 
	
			//insert data to database		
			$query   = "INSERT INTO users(name, age, email) VALUES(:name, :age, :email)";
			$stmt = $dbConn->prepare($query);

			$stmt->bindparam(':name', $name);
			$stmt->bindparam(':age', $age);
			$stmt->bindparam(':email', $email);
			$stmt->execute();

			// Alternative to above bindparam and execute
			// $stmt->execute(array(':name' => $name, ':email' => $email, ':age' => $age));
	
			//display success message
			echo "<font color='green'>Data added successfully.";
			echo "<br/><a href='index.php'>View Result</a>";
		}
	}
	?>
</body>

</html>