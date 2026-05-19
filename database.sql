-- Create a new database named "test" if it does not already exist.
CREATE DATABASE IF NOT EXISTS test;

-- Select and switch to the "test" database for subsequent table creation.
USE test;

-- Create the "users" table to store user records.
CREATE TABLE IF NOT EXISTS users (
  -- "id" is an integer, cannot be NULL, automatically increments on new inserts, and serves as the primary key.
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,

  -- "name" stores the user's name as a variable character string up to 100 characters and cannot be empty.
  name VARCHAR(100) NOT NULL,

  -- "age" stores the user's age as a 3-digit integer and cannot be empty.
  age INT(3) NOT NULL,

  -- "email" stores the user's email address up to 100 characters and cannot be empty.
  email VARCHAR(100) NOT NULL
);