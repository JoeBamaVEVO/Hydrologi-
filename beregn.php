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
<div class="container">
    <form>
        <h2>Hydrologi Program</h2>
        <div class="row mb-4">
            <div class="col-1">
                <label class="col-form-label "for="">Målestasjon</label>
            </div>
            <div class="col-2">
                <select class="form-control" name="Malestasjon">
                   <?php echo $Malestasjoner; ?>
                </select>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-1">
                <label class="col-form-label" for="AntallMålinger">Målinger</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="AntallMålinger" value="1">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-1">
                <label class="col-form-label" for="Qmiddel">Qmiddel</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="Qmiddel" value="1">
            </div>
            <small class="form-text col-1">m3/s km2</small>
        </div>
        <div class="row mb-4">
            <div class="col-1">
                <label class="col-form-label" for="FeltAreal">Felt Areal</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="FeltAreal" value="1">
            </div>
            <small class="form-text col-1">km2</small>
        </div>
        <div class="row mb-4">
            <div class="col-1 pt-0">
                <label class="col-form-label pt-0" for="SnaufjellsAndel">Snaufjells Andel</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="SnaufjellsAndel" value="1">
            </div>
            <small class="form-text col-1">%</small>
        </div>
        <div class="row mb-4">
            <div class="col-1 pt-0">
                <label class="col-form-label pt-0" for="EffSjøandel">Effektiv Sjøandel</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="EffSjøandel" value="1">
            </div>
            <small class="form-text col-1">%</small>
        </div>
        <div class="row mb-4">
            <div class="col-1 pt-0">
                <label class="col-form-label pt-0" for="MaxKvote">Max Kvote Felt</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="MaxKvote" value="1">
            </div>
            <small class="form-text col-1">m.o.h</small>
        </div>
        <div class="row mb-4">
            <div class="col-1 pt-0">
                <label class="col-form-label pt-0" for="MinKvote">Min Kvote Felt</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="MinKvote" value="1">
            </div>
            <small class="form-text col-1">m.o.h</small>
        </div>
    </form>
</div>


    <!-- <form method="POST">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="Malestasjon">Målestasjon</label>
            <select class="form-control" name="Malestasjon">
                <?php echo $Malestasjoner; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="SkalerValue">Skalerings Faktor</label>
            <input class="form-control" type="number" step="any" name="SkalerValue">
            <input class="form-control btn btn-primary"type="submit" name="btnSkaler" value="Skaler">
        </div>
    </form> -->
</body>
</html>

<?php
if(isset($_POST["btnSkaler"])){
    Skaler();
}
function Skaler(){
        $I = 0;
        $csv = 'malestasjoner/' . $_POST['Malestasjon'];
        $fileHandler = fopen($csv, "r");
        $fileWrite = fopen("Skalert_" . $_POST['Malestasjon'], "w");
        while(list($MaleDato, $MaleVerdi) = fgetcsv($fileHandler, 1024, ";")) {
            $SkalertVerdi = $MaleVerdi * $_POST['SkalerValue'];
            fwrite($fileWrite, $MaleDato . ",");
            fwrite($fileWrite, $SkalertVerdi . "\n");
            $I++;
        }
        echo "Antall linjer prossesert: " . $I;
        fclose($fileWrite);
        fclose($fileHandler);
    }
?>

