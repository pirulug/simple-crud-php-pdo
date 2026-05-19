# PHP PDO CRUD for Beginners

[Leer en Español (Spanish version)](README-es.md)

Welcome to this beginner-friendly guide! This project is a simple, educational **CRUD (Create, Read, Update, Delete)** system built with **PHP** and **MySQL** using **PDO (PHP Data Objects)**. 

If you are new to backend web development, this guide will walk you through how PHP interacts with a database securely.

---

## What is CRUD?

CRUD stands for the four basic operations you can perform on any data set:
* **C**reate: Inserting new rows into the database.
* **R**ead: Fetching and displaying records.
* **U**pdate: Modifying existing database entries.
* **D**elete: Removing records.

---

## 1. Database Connection (`connection.php`)

To perform database operations, PHP must first connect to MySQL. We use **PDO (PHP Data Objects)** because it is secure, modern, and works with many database engines.

Here is the connection code:

```php
<?php
$databaseHost     = "localhost";
$databaseName     = "test";
$databaseUsername = "root";
$databasePassword = "";

try {
  // 1. Create a new PDO instance
  $dbConn = new PDO(
    "mysql:host={$databaseHost};dbname={$databaseName}",
    $databaseUsername,
    $databasePassword
  );

  // 2. Configure PDO to throw exceptions when an error occurs
  $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
  // 3. Catch errors to prevent raw connection details from leaking
  echo $e->getMessage();
}
?>
```

### Key Concepts for Beginners:
* `new PDO(...)`: Connects PHP to MySQL. The connection details are called the **DSN (Data Source Name)**.
* `try { ... } catch (PDOException $e) { ... }`: A block used to capture errors. If connection fails, the code inside the `catch` block runs. This prevents your database password from appearing on the webpage as an error.
* `setAttribute(...)`: Instructs PDO to alert us with an "Exception" whenever a database query fails. This makes debugging code much easier.

---

## 2. CREATE Operation (`create.php`)

This page handles both rendering the form and processing the user input. To add a user securely, we use **Prepared Statements**.

Here is how data is inserted:

```php
<?php
// Include the database connection
include_once("connection.php");

// 1. Check if the user clicked the submit button
if (isset($_POST["Submit"])) {
  $name  = $_POST["name"];
  $age   = $_POST["age"];
  $email = $_POST["email"];

  // 2. Simple validation
  if (!empty($name) && !empty($age) && !empty($email)) {

    // 3. Prepare an SQL statement with placeholders
    $query = "INSERT INTO users (name, age, email) VALUES (:name, :age, :email)";
    $stmt = $dbConn->prepare($query);

    // 4. Bind variables to placeholders securely
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":email", $email);

    // 5. Run the query
    $stmt->execute();
  }
}
?>
```

### Key Concepts for Beginners:
* `$_POST`: A special PHP variable (called a **superglobal**) that collects data submitted via an HTML form using the `"post"` method.
* **SQL Injection**: Inserting user inputs directly into an SQL statement is highly dangerous (e.g. `INSERT INTO users VALUES ('$name')`). Hackers can inject harmful database commands.
* **Prepared Statements (`prepare()`)**: We use placeholders (`:name`, `:age`, `:email`) instead of direct variables. The database compiles this query structure first, keeping it safe.
* `bindParam()`: Secures and sanitizes the user input before linking it to the query placeholders.

---

## 3. READ Operation (`read.php`)

This file acts as our main dashboard, fetching all user records from the database and displaying them in an HTML table.

Here is the data retrieval code:

```php
<?php
// Include database connection
include_once("connection.php");

// 1. Prepare the select query (newest records first)
$query = "SELECT * FROM users ORDER BY id DESC";
$stmt = $dbConn->prepare($query);

// 2. Execute the query
$stmt->execute();

// 3. Retrieve all results as a list of PHP Objects
$users = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
```

And here is how we display it in the HTML view:

```php
<table width="80%" border="0">
  <tr bgcolor="#CCCCCC">
    <td>Name</td>
    <td>Age</td>
    <td>Email</td>
    <td>Actions</td>
  </tr>

  <?php foreach ($users as $user): ?>
    <tr>
      <!-- Access the properties of each record object -->
      <td><?= $user->name ?></td>
      <td><?= $user->age ?></td>
      <td><?= $user->email ?></td>
      <td>
        <a href="update.php?id=<?= $user->id ?>">Edit</a> |
        <a href="delete.php?id=<?= $user->id ?>">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
```

### Key Concepts for Beginners:
* `fetchAll(PDO::FETCH_OBJ)`: Tells PDO to return all database rows as a list of PHP **Objects**. This allows us to access properties directly using the arrow notation (`$user->name`).
* `foreach ($users as $user)`: A loop that processes every user object inside the database table individually.
* `<?= $user->name ?>`: A shorthand version of `<?php echo $user->name; ?>` used to display values quickly inside HTML templates.

---

## 4. UPDATE Operation (`update.php`)

To edit a user, we must:
1. Fetch the user's current data from the database using a **GET** parameter (`update.php?id=5`) to pre-fill the form.
2. Save changes to the database using a **POST** request when they click the update button.

### Part A: Fetching the User's Current Data (GET)
```php
<?php
// Retrieve the "id" from the URL address bar
$id = $_GET["id"];

// Fetch the user matching that specific ID
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $dbConn->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();

// fetch() obtains only a single row as an object
$user = $stmt->fetch(PDO::FETCH_OBJ);
?>
```

### Part B: Saving the Updated Data (POST)
```php
<?php
if (isset($_POST["update"])) {
  $id    = $_POST["id"];
  $name  = $_POST["name"];
  $age   = $_POST["age"];
  $email = $_POST["email"];

  // Prepare and execute the update command
  $sql = "UPDATE users SET name = :name, age = :age, email = :email WHERE id = :id";
  $query = $dbConn->prepare($sql);
  $query->bindParam(":id", $id);
  $query->bindParam(":name", $name);
  $query->bindParam(":age", $age);
  $query->bindParam(":email", $email);
  $query->execute();
}
?>
```

### Key Concepts for Beginners:
* `$_GET["id"]`: Collects data from the URL query string (e.g. `?id=5`).
* `fetch(PDO::FETCH_OBJ)`: Unlike `fetchAll`, `fetch` only retrieves one record. This is perfect since every user has a unique ID.
* `<input type="hidden" name="id" value="<?= $user->id ?>">`: We store the user's ID inside a hidden form input so `update.php` knows which exact row to modify on submit.

---

## 5. DELETE Operation (`delete.php`)

Deleting a record takes a unique ID via a GET parameter, deletes the matching row, and automatically redirects the user back to the dashboard.

Here is the code:

```php
<?php
// Include the database connection
include_once("connection.php");

// 1. Retrieve the user ID to delete
$id = $_GET["id"];

// 2. Prepare the delete statement
$query = "DELETE FROM users WHERE id = :id";
$stmt = $dbConn->prepare($query);
$stmt->bindParam(":id", $id);

// 3. Execute the deletion
$stmt->execute();

// 4. Redirect the user's browser back to read.php automatically
header("Location: read.php");
exit();
?>
```

### Key Concepts for Beginners:
* `DELETE FROM users WHERE id = :id`: Removes the record that matches the supplied ID. Leaving out `WHERE id = :id` would delete **every** user in your database!
* `header("Location: read.php")`: An HTTP response header that redirects the user to the list view immediately.
* `exit()`: Stops the execution of the PHP script right away to ensure no extra queries are run.

---

## Best Practices and Safe Development Notes
This project is made for **educational purposes**. When you start developing professional applications, always remember to add:
1. **Robust Validation**: Verify inputs (e.g. check if the email address is valid using `filter_var`).
2. **CSRF Protection**: Use security tokens in HTML forms to prevent malicious websites from submitting requests on behalf of your users.
3. **Password Hashing**: Never store plain passwords; always use `password_hash()` in PHP.