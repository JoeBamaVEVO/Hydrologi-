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
    <div class="container-fluid ms-0 ps-0">
        <div class="container-fluid float-start border ms-0 ps-0" style="min-height: 100%; max-width: 25%;" >
            <h2>Mine Prosjekter</h2>
            <div class="list-group">
                <?php 
                $ProjectDir = $userDir . "/projects";
                $Projects = "";

                if(is_dir($ProjectDir)){
                    if($dh = opendir($ProjectDir)){
                        while(($Project = readdir($dh)) !== false){
                            if($Project != "." && $Project != ".."){
                                $Projects .= "<a href='beregn.php?project={$Project}' class='list-group-item list-group-item-action'>{$Project}</a>";
                            }
                        }
                        closedir($dh);
                    }
                }
                echo $Projects;
                ?>
            </div>
            <form action="" method="POST">
                <input name="newProjectName" type="text">
                <button class="btn btn-primary float-end" type="submit" alt="" name="newProject"> 
                    <p class="mb-0"><img src="/Bilder/Svg/plus-circle-fill.svg" alt=""></p>
                </button> 
            </form>
        </div>
    </div>
</body>
</html>|