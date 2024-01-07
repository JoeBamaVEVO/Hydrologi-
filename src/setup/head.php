<?php 
include "db.php";
if(!isset($_SESSION)) 
	{ 
	 session_start(); 
    }
if(isset($_SESSION['idusers'])){
	$userID = $_SESSION["idusers"];
	$sql = "SELECT * FROM users WHERE idusers = $userID";
	$result = $mysqli->query($sql);
	$user = $result->fetch_assoc();
	$userDir = "../../users/" . $_SESSION["idusers"] . "-" . $user["fname"];
}
include "../Frontend/navbar.php";
?>

<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> -->
<link rel="stylesheet" href="../style.css">


