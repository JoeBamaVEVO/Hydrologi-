<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php include "head.php" ?>   
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

                header("Location: index.php");
                exit;
            } 
        }

        $is_invalid = true;
    }
?>
<body>
<div class="loginForm d-flex justify-content-center">
    <div class="d-flex flex-column">
        <h1 class="mb-4">Log Inn</h1>
        <?php if ($is_invalid) : ?>
            <em>Invalid email or password</em>
        <?php endif; ?>
        <form  class="d-flex flex-column " action="" method="POST" novalidate>
            <label for="email">Email</label>
            <input class="mb-4"type="email" name="email" value="<?= htmlspecialchars( $_POST["email"] ?? "")  ?>">
            <label for="password">password</label>
            <input class="mb-4"type="password" name="password">
            <input class="mb-4"type="submit" name="submit" value="Submit">
        </form>
        <p>Ingen bruker? registrer deg <a href="/signup.php">her</a></p>
    </div>
</div>
</body>
</html>  