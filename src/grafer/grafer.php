<?php 
// Vi inkluderer Head.php som inneholder alle nødvendige filer og variabler
include "../setup/head.php";
// Vi definerer stien til prosjektet, og til CSV filen som skal brukes til å lage graf 1
$projectDir = $userDir . "/projects" . "/" . $_GET["project"];
$CsvGraf1 = $projectDir . "/Tabelldata_Graf1.csv";

// Her inporterer vi Graf1.php som lager CSV filen som brukes til å lage graf 1
require_once "graf1.php";
// Her inporterer vi Graf2-3.php som lager CSV filen som brukes til å lage graf 2 og 3
require_once "graf2-3.php";
// Her inporterer vi GrafVarighet.php som lager CSV filen som brukes til å lage graf 4
require_once "grafVarighet.php";


// Her leser vi inn CSV filen som brukes til å lage graf 1
// og legger den inn i en array som heter Graf1
$fileHandler1 = fopen($CsvGraf1, "r");
while(list($MaleDato, $MaleVerdi) = fgetcsv($fileHandler1, 1024, ",")){
    $Graf1[] = array("x" => $MaleDato, "y" => $MaleVerdi);
}
fclose($fileHandler1);

// Her skal vi hente data til Graf 2-3
// Vi leser inn CSV filen som brukes til å lage graf 2 og 3
$CsvGraf2 = $projectDir . "/Tabelldata_Graf2-3.csv";
$fileHandler2 = fopen($CsvGraf2, "r");

// Åpner CSV filen og lagrer data i flere arrays
while(list($Dato, $Gjennomsnitt, $Maks, $Min) = fgetcsv($fileHandler2, 1024, ",")){
    // Vi må konvertere dato fra CSV filen til JavaScript timestamp
	$phpDate = date("d-m-Y h:i:sa", strtotime($Dato)); 
	$phpTimestamp = strtotime($phpDate);
	$javaScriptTimestamp = $phpTimestamp * 1000;
    
    // Disse arrayene blir brukt til å lage graf 1-2 som viser middel og minimum avrenning
    $Middel[] = array("x" => $javaScriptTimestamp, "y" => $Gjennomsnitt);
	$Minimum[] = array("x" => $javaScriptTimestamp, "y" => $Min);
    
    // Denne arrayen blir brukt til å lage graf3 som viser maksimum avrenning
    $Maximum[] = array("x" => $javaScriptTimestamp, "y" => $Maks);
	// Creates an extra array that stores all the values in $Maks
	// So that we can find the largest value in the Måleserie.
	$Max2[] = $Maks;
}
fclose($fileHandler2);
// Here we find the largest number in £Max2 
// This is for scaling the graph intervals correctly. 
$MaxInMax = Max($Max2);
$IntervalSize = round(($MaxInMax / 10), 0);


// Her skal vi jobbe på Varighetsgrafen

// Her henter vi ut Varighetskurve data
$csv = $projectDir . "/TabelldataVarighet.csv";
$fileHandler = fopen($csv, "r");
while(list($Verdi, $Prosent) = fgetcsv($fileHandler, 1024, ",")){
    $VarighhetData[] = array("y" => $Verdi, "x" => $Prosent);
}

// Her henter vi ut slukeevne data
$csv = $projectDir . "/Slukeevne.csv";
echo $csv;
$fileHandler = fopen($csv, "r");
while(list($Verdi, $Prosent) = fgetcsv($fileHandler, 1024, ",")){
    $SlukeevneData[] = array("y" => $Verdi, "x" => $Prosent);
}

// Her henter vi ut SumLavere
$csv = $projectDir . "/SumLavere.csv";
$fileHandler = fopen($csv, "r");
while(list($Verdi, $Prosent) = fgetcsv($fileHandler, 1024, ",")){
    $SumLavereData[] = array("y" => $Verdi, "x" => $Prosent);
}



// Her henter vi ut Varighetskurve data for sommerhalvåret
$csv = $projectDir . "/TabelldataVarighetSommer.csv";
$fileHandler = fopen($csv, "r");
while(list($Verdi, $Prosent) = fgetcsv($fileHandler, 1024, ",")){
    $VarighhetDataSommer[] = array("y" => $Verdi, "x" => $Prosent);
}

// Her henter vi ut slukeevne data
$csv = $projectDir . "/SlukeevneSommer.csv";
echo $csv;
$fileHandler = fopen($csv, "r");
while(list($Verdi, $Prosent) = fgetcsv($fileHandler, 1024, ",")){
    $SlukeevneDataSommer[] = array("y" => $Verdi, "x" => $Prosent);
}

// Her henter vi ut SumLavere
$csv = $projectDir . "/SumLavereSommer.csv";
$fileHandler = fopen($csv, "r");
while(list($Verdi, $Prosent) = fgetcsv($fileHandler, 1024, ",")){
    $SumLavereDataSommer[] = array("y" => $Verdi, "x" => $Prosent);
}


// Her henter vi ut Varighetskurve data for vinterhalvåret
$csv = $projectDir . "/TabelldataVarighetVinter.csv";
$fileHandler = fopen($csv, "r");
while(list($Verdi, $Prosent) = fgetcsv($fileHandler, 1024, ",")){
    $VarighhetDataVinter[] = array("y" => $Verdi, "x" => $Prosent);
}

// Her henter vi ut slukeevne data
$csv = $projectDir . "/SlukeevneVinter.csv";
echo $csv;
$fileHandler = fopen($csv, "r");
while(list($Verdi, $Prosent) = fgetcsv($fileHandler, 1024, ",")){
    $SlukeevneDataVinter[] = array("y" => $Verdi, "x" => $Prosent);
}

// Her henter vi ut SumLavere
$csv = $projectDir . "/SumLavereVinter.csv";
$fileHandler = fopen($csv, "r");
while(list($Verdi, $Prosent) = fgetcsv($fileHandler, 1024, ",")){
    $SumLavereDataVinter[] = array("y" => $Verdi, "x" => $Prosent);
}



$Diagram1Overskrift = "Variasjon i middelavløp fra år til år";
$Diagram2Overskrift = "Avrenningen fordelt over året";
$Diagram3Overskrift = "Maksimale flommer fordelt over året";

$VarighetsKurveOverskrift = "Varighetskurve for hele året";
$VarighetsKurveVinterOverskrift = "Varighetskurve for vinterhalvåret";
$VarighetsKurveSommerOverskrift = "Varighetskurve for sommerhalvåret";



$VarighetskurveInterval = floor(($Qmiddel * 4 )/ 5)


?>

<!DOCTYPE HTML>
<html>
<head>  
</head>
<body>
<div id="chartContainer1" style="height: 370px; width: 40%;"></div>
<button id="download1">Download Graf1</button>

<div id="chartContainer2" style="height: 370px; width: 40%;"></div></div>
<button id="download2">Download Graf2</button>

<div id="chartContainer3" style="height: 370px; width: 40%;"></div>
<button id="download3">Download Graf3</button>

<div id="chartContainer4" style="height: 370px; width: 40%; float: center;">
</div>
<button id="download4">Download Graf4</button>

<div id="chartContainerSommer" style="height: 370px; width: 40%; float: center;"></div>
<button id="downloadSommer">Download GrafSommer</button>

<div id="chartContainerVinter" style="height: 370px; width: 40%; float: center;"></div>
<button id="downloadVinter">Download GrafVinter</button>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script defer>
    document.getElementById("Qmedian").innerHTML = "Qmedian = " + <?php echo json_encode($Qmedian, JSON_NUMERIC_CHECK); ?> + " m3/s";
    document.getElementById("5Persentil").innerHTML = "5% Persentil = " + <?php echo json_encode($Persentil5, JSON_NUMERIC_CHECK); ?> + " m3/s";
</script>
<?php include "createGrafer.php"; ?>
</body>
</html>