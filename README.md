# Simple PHP-MySQL CRUD (Add, Edit, Delete, View) using PDO

## Introduction
This is a simple PHP and MySQL CRUD (Create, Read, Update, Delete) application using PDO (PHP Data Objects) for database interaction. It allows users to perform basic operations like adding, editing, deleting, and viewing data from a MySQL database.

## Prerequisites
- Web server (e.g., Apache)
- PHP (>=5.3.0)
- MySQL database server
- Knowledge of HTML, PHP, and MySQL

## Setup
1. Clone or download the project files to your local machine.
2. Import the `database.sql` file into your MySQL database to create the necessary database and tables.
3. Update the `config.php` file with your database connection details (hostname, database name, username, and password).
4. Place the project files in your web server's document root directory.
5. Ensure that your web server and MySQL server are running.

## Usage
1. Open your web browser and navigate to the project directory.
2. You can add new data by clicking on the "Add New Data" link on the homepage (`index.php`).
3. To edit existing data, click on the "Edit" link next to the respective entry on the homepage.
4. To delete data, click on the "Delete" link next to the respective entry on the homepage (a confirmation dialog will appear).
5. The homepage (`index.php`) displays a table with all existing data, including options to edit or delete each entry.

## Files
- `add.html`: HTML form to add new data.
- `add.php`: PHP script to handle the addition of new data to the database.
- `config.php`: PHP script containing database connection settings.
- `database.sql`: SQL script to create the necessary database and tables.
- `delete.php`: PHP script to handle the deletion of data from the database.
- `edit.php`: PHP script to handle the editing of existing data.
- `index.php`: Homepage displaying existing data and options to add, edit, or delete entries.

## Note
- This application uses PDO for database interaction, which provides a secure and efficient way to access databases in PHP.
- Ensure that you have proper error handling and security measures in place before deploying this application in a production environment.
