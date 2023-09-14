<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="canvasjs.min.js"></script>
</head>
<body>
    <?php 
    include "head.php";

    $projectDir = $userDir . "/projects" . "/" . $_GET["project"] . "/Skalert_" . $_GET["project"];
    // Sjekker om bruker er logget inn
    if(!isset($_SESSION['idusers'])){
        header("location: index.php");
    }
    // Sjekker om bruker har valgt et prosjekt
    if(empty($_GET['project'])){
        header("location: index.php");
    }
    if(!isset($_GET['project'])){
        header("location: index.php");
    }
    // Sjekker om prosjektet eksisterer
    if(!is_dir($userDir . "/projects" . "/" . $_GET["project"])){
        header("location: index.php");
    }

    if(!is_file($projectDir)){ 
        echo "Finner ingen skalert prosjekt fil, vennligst gå tilbake og skaler prosjektet";
        echo '<a href="beregn.php?project="' . $_GET["project"] . '></a>';
    }
    ?>

<!-- Henter data fra csv -->
<?php 
$I = 0;
$csv = $projectDir;
$fileHandler = fopen($csv, "r");
$MDato = array();
$MVerdi = array();

// henter startdato og sluttdato på filen
list($AktueltÅr, $sluttDato) = HentDato($fileHandler);

// Leser filen inn i en array
$fileHandler = fopen($csv, "r");
while(list($MaleDato, $MaleVerdi) = fgetcsv($fileHandler, 1024, ",")) {
    array_push($MDato, $MaleDato);
    array_push($MVerdi, $MaleVerdi);
}   
fclose($fileHandler);

// Henter data fra arrayen
$i = 0;
$total = 0;
echo substr($AktueltÅr, -4) . "<br>";
$fileWrite = fopen($userDir . "/projects" . "/" . $_GET["project"] ."/QmiddelAar-Aar", "a");
foreach($MDato as $key => $value){
    // sammenlkigner årstall
    if(substr($value, -4) == substr($AktueltÅr, -4)){
        // plusser på verdien
        $total += $MVerdi[$key];
        $i++;
    }
    if( $i +1 == count($MDato)|| substr($value, -4) !== substr($AktueltÅr, -4)){
        // plusser den siste verdien
        $total += $MVerdi[$key];
        // Deler på antall verdier
        $total = $total/($i + 1);
        // Skriver til fil
        fputcsv($fileWrite, array(substr($AktueltÅr, -4), $total));
        // Resetter variabler
        $total = 0;
        $i = 0;
        // Øker årstallet
        $AktueltÅr++;
    }
}



function HentDato($fileHandler){
    $dato = array();
    list($MaleDato) = fgetcsv($fileHandler, 1024, ",");

    $AktueltÅr = $MaleDato;

    while(list($MaleDato) = fgetcsv($fileHandler, 1024, ",")) {
        $sluttDato = $MaleDato;    
    }
        
    fclose($fileHandler);
    echo $AktueltÅr . "<br>";
    echo $sluttDato . "<br>";

    return $dato = array($AktueltÅr, $sluttDato);
    }
?>


<!-- chart -->
<?php 

$csv = $userDir . "/projects" . "/" . $_GET["project"] ."/QmiddelAar-Aar";
$fileHandler = fopen($csv, "r");
while(list($MaleDato, $MaleVerdi) = fgetcsv($fileHandler, 1024, ",")){
    $dataPoints[] = array("x" => $MaleDato, "y" => $MaleVerdi);
}   
?>    
<script type="text/javascript" src="/CanvasJS/canvasjs-chart-3.7.19/canvasjs.min.js"></script>
<script type="text/javascript">
	  window.onload = function () {
        CanvasJS.addColorSet("blue", ["#89CFF0"]);
		  var chart = new CanvasJS.Chart("chartContainer", {
            colorSet: "blue",
            title:{
                text: "Variasjon i middelavløp fra år til år"
            },
            axisX:{
                title: "År",
                valueFormatString: "####",
                interval: 5
            },
            axisY:{
                title: "Middelavløp",
                valueFormatString: "#0.## m3/s",
                includeZero: true
            },
			  data: [
			  {
				type: "column",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
			  }
			  ]
		  });
 
		  chart.render();

          document.getElementById("download").addEventListener('click', function() {
            chart.exportChart({format: "jpg"}); 
        });
	  }
  </script>
      <div id="chartContainer" style="height: 500px; width: 50%;"></div>
      <button id="download">download</button>
</body>
</html>