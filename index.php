<?php
/**
 * index.php
 *
 * Redirects the user automatically to read.php (the main dashboard of our CRUD).
 * We use the "header()" function to send a raw HTTP header for the redirect,
 * and "exit" to terminate the current script execution immediately.
 *
 * Official documentation links:
 * - header(): https://www.php.net/manual/en/function.header.php
 * - exit: https://www.php.net/manual/en/function.exit.php
 */

header("Location: read.php");
exit;
?>
