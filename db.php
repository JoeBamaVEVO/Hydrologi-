<?php
$host = 'localhost';
$user = 'KristianAdmin';
$pass = '5297Kris1234';
$db = 'utregningsprogram';

// Create database connection
$mysqli = new mysqli($host, $user, $pass, $db);

// Check the connection
if (!$mysqli) {
    die("Database connection failed: ".  mysqli_connect_error());
}

?>
