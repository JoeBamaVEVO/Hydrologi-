<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
	<?php 
    include '../setup/head.php';
	?>
</head>
<body>
    <div class="IndexContent">
        <div class="containerLogo">
            <img src="/Bilder/OdelskraftLogo.jpg" alt="OdelskraftLogo">    
        </div>
        <h1 class="align-self-center mb-4">Hydrologi Program</h1>
        <?php if (isset($_SESSION["idusers"])): ?>
            <a class="align-self-center"href="MineProsjekter.php"><button class="btn btn-primary">Mine Prosjekter</button></a>
        <?php else: ?>
            <a class="align-self-center mb-4"href="../Auth/login.php"><button type="button" class="btn btn-primary">login</button></a>
        <?php endif; ?>
    </div>
</body>
</html>