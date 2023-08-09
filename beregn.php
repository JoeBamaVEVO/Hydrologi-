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
<body>
    <?php 
        $MaleDir = "malestasjoner";
        $Malestasjoner = "";

        if(is_dir($MaleDir)){
            if($dh = opendir($MaleDir)){
                while(($Malestasjon = readdir($dh)) !== false){
                    if($Malestasjon != "." && $Malestasjon != ".."){
                        $Malestasjoner .= "<option value='{$Malestasjon}'>{$Malestasjon}</option>";
                    }
                }
                closedir($dh);
            }
        }
    ?>
    <form action="" method="POST">
        <select name="Malestasjon">
            <?php echo $Malestasjoner; ?>
        </select>
        <input type="number" step="any" name="SkalerValue">
        <input type="submit" name="btnSkaler" value="Skaler">
    </form>
    <table class="table">
    <?php

    if(isset($_POST["btnSkaler"])){
        Skaler();
        if(isset($_POST['SkalerValue'])){
        }
    }

        function Skaler(){
            $I = 0;
            $csv = 'malestasjoner/' . $_POST['Malestasjon'];
            $fileHandler = fopen($csv, "r");
            $fileWrite = fopen("Skalert_" . $_POST['Malestasjon'], "w");
            while(list($MaleDato, $MaleVerdi) = fgetcsv($fileHandler, 1024, ";")) {
                $SkalertVerdi = $MaleVerdi * $_POST['SkalerValue'];
                #echo "<tbody>";
                #echo "<tr>";
                #echo "<td>$I</td>";
                #echo "<td>$MaleDato</td>";
                #echo "<td>$MaleVerdi</td>";
                #echo "<td>$SkalertVerdi</td>";
                #echo "</tr>";
                #echo "</tbody>";
                fwrite($fileWrite, $MaleDato . ",");
                fwrite($fileWrite, $SkalertVerdi . "\n");
                $I++;
            }
            fclose($fileWrite);
            fclose($fileHandler);
        }

    ?>
    </table>
    
</body>
</html>