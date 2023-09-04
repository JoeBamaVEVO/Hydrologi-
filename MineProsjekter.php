<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include "head.php" ?>
</head>
<body>
    <?php 
    if(!isset($_SESSION['idusers'])){
        header("location: index.php");
    }
    if(isset($_POST["newProject"])){
        mkdir($userDir . "/projects" . "/" . $_POST["newProjectName"], 777, true);
    }
    ?>
        <?php 
        $ProjectDir = $userDir . "/projects";
        $Projects = "";

        if(is_dir($ProjectDir)){
            if($dh = opendir($ProjectDir)){
                while(($Project = readdir($dh)) !== false){
                    if($Project != "." && $Project != ".."){
                        $Projects .= "<li><a href='beregn.php?project={$Project}'>{$Project}</a></li>";
                    }
                }
                closedir($dh);
            }
        }
        ?>
    <div class="MineProsjekter">
        <h1 class="header">Mine Prosjekter</h1>
        <ul>
            <?php echo $Projects; ?>
        </ul>
        <form method="POST">
            <input type="text" name="newProjectName">
            <input type="submit" name="newProject" value="+">
        </form>
</body>
</html>