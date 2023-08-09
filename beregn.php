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
    <form method="POST">
        <input type="submit" name="btnVis" value="VisData">
    </form>
    <form action="" method="POST">
        <input type="number" name="SkalerValue">
        <input type="submit" name="btnSkaler" value="Skaler">
    </form>
    <table class="table">
    <?php
    if(isset($_POST["btnVis"])){
        VisData();
    }

    if(isset($_POST["btnSkaler"])){
        Skaler();
        if(isset($_POST['SkalerValue'])){
        }
    }

        function VisData(){
            $I = 0;
            $csv = "CSV/SolielvaSkalert.csv";
            $fileHandler = fopen($csv, "r");
            while(list($MaleDato, $MaleVerdi) = fgetcsv($fileHandler, 1024, ";") and $I <= 1000) {
                #echo "<tbody>";
                #echo "<tr>";
                #echo "<td>$I</td>";
                #echo "<td>$MaleDato</td>";
                #echo "<td>$MaleVerdi</td>";
                #echo "</tr>";
                #echo "</tbody>";
                $I++;
            }
        } 

        function Skaler(){
            $I = 0;
            $csv = "CSV/SolielvaSkalert.csv";
            $fileHandler = fopen($csv, "r");
            $fileWrite = fopen("outputCSV/output.csv", "w");
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