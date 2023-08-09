<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include "head.php" ?>
</head>
<body>
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-column">
            <div class="mb-4">
                <img src="/Bilder/OdelskraftLogo.jpg" alt="OdelskraftLogo">    
            </div>
            <h2 class="align-self-center mb-4">Hydrologi Program</h2>
            <?php if (isset($_SESSION["idusers"])): ?>
                <a class="align-self-center"href="beregn.php"><button class="btn btn-primary">Hydrologi Program</button></a>
            <?php else: ?>
                <a class="align-self-center mb-4"href="login.php"><button type="button" class="btn btn-primary">login</button></a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>