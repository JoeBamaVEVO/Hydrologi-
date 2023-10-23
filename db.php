<?php
include 'config.php';


// Create database connection
$mysqli = new mysqli($host, $user, $pass, $db);

// Check the connection
if (!$mysqli) {
    die("Database connection failed: ".  mysqli_connect_error());
}

?>
