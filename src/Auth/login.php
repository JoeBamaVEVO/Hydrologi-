<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php
	include "../setup/head.php" 
	?> 
</head>
<?php 

$is_invalid = false;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
        $sqlLogin = sprintf("SELECT * FROM users  WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));

        $result = $mysqli->query($sqlLogin);

        $user = $result->fetch_assoc();

        if ($user) {
            if (password_verify($_POST["password"], $user["passwordHash"])) {
                
                session_start();

                session_regenerate_id();

                $_SESSION["idusers"] = $user["idusers"];

                if(!file_exists("users/" . $_SESSION["idusers"] . "-" . $user["fname"]. "/projects")) {
                    mkdir("users/" . $_SESSION["idusers"] . "-" . $user["fname"]. "/projects", 777, true);
                }

                header("Location: ../Frontend/index.php");
                exit;

            } 
        }

        $is_invalid = true;
    }
?>
<body>
    <div class="formCard">
        <h1 class="header">Log Inn</h1>
        <?php if ($is_invalid) : ?>
            <em>Invalid email or password</em>
        <?php endif; ?>
        <form  class="loginForm" action="" method="POST" novalidate>
            <label for="email">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars( $_POST["email"] ?? "")  ?>">
            <label for="password">password</label>
            <input type="password" name="password">
            <input type="submit" name="submit" value="Submit">
        </form>
        <p class="textcenter">Ingen bruker? registrer deg <a href="./signup.php">her</a></p>
    </div>
</div>
</body>
</html>  