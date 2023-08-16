<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
    $value = 150;
	include "head.php";
    if(!isset($_SESSION['idusers'])){            // Skjekker om du logget inn
        header("location: index.php");
    }
    $project = $_GET['project']
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
    <form method="POST" class="align-center">
        <h2 class="mb-4 text-center">Hydrologi Program</h2>
        <div class="row mb-4">
            <div class="col-2">
                <label class="col-form-label d-flex justify-content-end "for="Malestasjon">Målestasjon</label>
            </div>
            <div class="col-2">
                <select class="form-control" name="Malestasjon">
                    <option value="Opt1" disabled selected>Velg Målestasjon</option>
                    <?php echo $Malestasjoner; ?>
                </select>
            </div>
            <div class="col-5">
                <label class="col-form-label  d-flex justify-content-end" for="">Prosjekt</label>
            </div>
            <div class="col-2">
                <?php echo '<input class="form-control" type="text" name="" value="' . $project . '">'; ?>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-2">
                <label class="col-form-label d-flex justify-content-end" for="AntallMålinger">Antall Målinger</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="AntallMålinger" value="1">
            </div>
            <div class="col-5">
                <label class="col-form-label  d-flex justify-content-end" for="AntallMålinger">Antall Målinger</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="AntallMålinger" value="1">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-2">
                <label class="col-form-label d-flex justify-content-end" for="Qmiddel">Qmiddel</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="Qmiddel" value="1">
            </div>
            <small class="form-text col-1">m3/s km2</small>
            <div class="col-4">
                <label class="col-form-label  d-flex justify-content-end" for="">Qmiddel</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="" value="1">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-2">
                <label class="col-form-label d-flex justify-content-end" for="FeltAreal">Felt Areal</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="FeltAreal" value="1">
            </div>
            <small class="form-text col-1">km2</small>
            <div class="col-4">
                <label class="col-form-label  d-flex justify-content-end" for="">Felt Areal</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="" value="1">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-2 pt-0">
                <label class="col-form-label d-flex justify-content-end pt-0" for="SnaufjellsAndel">Snaufjellsandel</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="SnaufjellsAndel" value="1">
            </div>
            <small class="form-text col-1">%</small>
            <div class="col-4">
                <label class="col-form-label  d-flex justify-content-end" for="">Snaufjellsandel</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="" value="1">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-2 pt-0">
                <label class="col-form-label d-flex justify-content-end pt-0" for="EffSjøandel">Effektiv Sjøandel</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="EffSjøandel" value="1">
            </div>
            <small class="form-text col-1">%</small>
            <div class="col-4">
                <label class="col-form-label  d-flex justify-content-end" for="">Effektiv Sjøandel</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="" value="1">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-2 pt-0">
                <label class="col-form-label d-flex justify-content-end pt-0" for="MaxKvote">Max Kvote Felt</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="MaxKvote" value="1">
            </div>
            <small class="form-text col-1">m.o.h</small>
            <div class="col-4">
                <label class="col-form-label  d-flex justify-content-end" for="">Max Kvote Felt</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="" value="1">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-2 pt-0">
                <label class="col-form-label d-flex justify-content-end pt-0" for="MinKvote">Min Kvote Felt</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="MinKvote" value="1">
            </div>
            <small class="form-text col-1">m.o.h</small>
            <div class="col-4">
                <label class="col-form-label  d-flex justify-content-end" for="">Min Kvote Felt</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="" value="1">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-9 pt-0">
                <label class="col-form-label d-flex justify-content-end" for="">Feltlengde</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="" value="1">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-9 pt-0">
                <label class="col-form-label d-flex justify-content-end">Sjøandel</label>
            </div>
            <div class="col-2">
                <input class="form-control" type="number" name="" value="1">
            </div>
        </div>
        <div class="row mb-4">
        <button name="hentMetadata" type="submit" class="ms-5 col-2 btn btn-primary">
                Hent Metadata
            </button>
            <button name="lagreMetadata" type="submit" class="ms-5 col-2 btn btn-primary">
                Lagre Metadata
            </button>
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
// Skjekker om knappene blir trykket på
if(isset($_POST["btnSkaler"])){
    Skaler();
}
if(isset($_POST["lagreMetadata"])){
    LagreMetadata($userDir, $project);
}
if(isset($_POST["hentMetadata"])){
    HentMetadata($userDir, $project);
}

function HentMetadata($userDir, $project){
    $Malestasjon = $_POST['Malestasjon'];
    if(empty($Malestasjon)){
        echo "Du må velge en målestasjon";
        return;
    }
    $Metadata = $userDir . "/projects/" . $project . "/" . "metadata" . $Malestasjon;
    echo $Metadata;
    if(file_exists($Metadata)){
        $file = fopen($Metadata, "r");
        while(list($key, $value) = fgetcsv($file, 1024, ";")){
           
        }
    }
}
function LagreMetadata($userDir, $project){
    $Malestasjon = $_POST['Malestasjon'];
    if(empty($Malestasjon)){
        echo "Du må velge en målestasjon";
        return;
    }
    else{
        $csv = $userDir . "/projects/" . $project . "/" . "Metadata" . $Malestasjon; 
        $fileWrite = fopen($csv, "w");
        fwrite($fileWrite, "AntallMalinger;" . $_POST['AntallMalinger'] . "\n");
        fwrite($fileWrite, "Qmiddel;" . $_POST['Qmiddel'] . "\n");
        fwrite($fileWrite, "FeltAreal;" . $_POST['FeltAreal'] . "\n");
        fwrite($fileWrite, "SnaufjellsAndel;" . $_POST['SnaufjellsAndel'] . "\n");
        fwrite($fileWrite, "EffSjoandel;" . $_POST['EffSjoandel'] . "\n");
        fwrite($fileWrite, "MaxKvote;" . $_POST['MaxKvote'] . "\n");
        fwrite($fileWrite, "MinKvote;" . $_POST['MinKvote'] . "\n");
        fclose($fileWrite);
    }
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

