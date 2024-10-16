<?php
// Database connection details
$host = 'localhost';  // Database server feenix-mariadb.swin.edu.au
$user = 'root';               // Your database username your_username
$password = '';           // Your database password your_password
$dbname = 'your_database_name';        // The name of your database your_database_name

// Create a connection to the MySQL database
$conn = new mysqli($host, $user, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
