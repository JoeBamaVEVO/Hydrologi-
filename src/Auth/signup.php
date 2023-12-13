<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
	include "head.php" 
	?>
</head>
<?php
if(isset($_POST['submit'])) {

    if (empty($_POST["email"]) || empty($_POST["password"])) {
        print(" Please fill out all fields ");
    }
    if ( !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        print(" Invalid email ");
    }
    
    $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Inserting into the database with prepared statements
    $sqlRegister = "INSERT INTO users (email, passwordHash, fname, lname) VALUES (?, ?, ?, ?)";
    
    $stmt = $mysqli->stmt_init();
    
    if ( ! $stmt->prepare($sqlRegister)) {
        die("SQL error: "  . $mysqli->error);
    }
    
    $stmt->bind_param("ssss", $_POST["email"], $passwordHash,  $_POST["fname"], $_POST["lname"]);
    

    try {
        if ($stmt->execute()) {
            session_start();
            session_regenerate_id();
            $_SESSION["idusers"] = $mysqli->insert_id;
            mkdir("Users/" . $_SESSION["idusers"] . "-" . $_POST["fname"]. "/projects", 777, true);
            header("Location: index.php");
            exit();
        } else {
            print("Error registering user");
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            print("Error: This email is already registered");
        } else {
            print("Error registering user");
        }
    } 


    
}
?>
<body>
<div class="formCard">
    <h1 class="header">Opprett En Konto</h1>
    <form class="loginForm action="" method="POST" novalidate>
        <label for="fname">First Name</label>
        <input type="text" name="fname">
        <label for="Lname">Last Name</label>
        <input type="text" name="lname">
        <label for="email">Email</label>
        <input type="email" name="email">
        <label for="password">password</label>
        <input type="password" name="password">
        <input type="submit" name="submit" value="Submit">
    </form>
</div>
</body>
</html>