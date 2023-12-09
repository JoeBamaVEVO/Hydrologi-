<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php 
// Vi inkluderer Head.php som inneholder alle nødvendige filer og variabler
include "head.php";
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
<script>
            // Gjør klar CanvasJS for å lage diagram
            window.onload = function () {

                CanvasJS.addColorSet("red", ["#C73A3A"]);

                // Vi setter opp Graf1 og gjør den klar for utskrift
                // Vi gir grafen navnet chart1 og legger den i chartContainer1
                var chart1 = new CanvasJS.Chart("chartContainer1", {
                    exportFileName: <?php echo json_encode($Diagram1Overskrift); ?>,
                    colorSet: "red",
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light2", // "light1", "light2", "dark1", "dark2"
                    title:{
                        text: <?php echo json_encode($Diagram1Overskrift); ?>
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
                    data: [{
                        type: "column", //change type to bar, line, area, pie, etc
                        // indexLabel: "{y}", //Shows y value on all Data Points
                        indexLabelFontColor: "#5A5757",
                        indexLabelPlacement: "outside",
                        dataPoints: <?php echo json_encode($Graf1, JSON_NUMERIC_CHECK); ?>

                    }]
                });

                // Tegner Graf1 
                chart1.render();

                // Vi lager Graf2 og gjør den klar for utskrift
                // Vi gir grafen navnet chart2 og legger den i HTML div chartContainer2
                var chart2 = new CanvasJS.Chart("chartContainer2", {
                    exportFileName: <?php echo json_encode($Diagram2Overskrift); ?>,
                    animationEnabled: true,
                    theme: "light2",
                    title:{
                        text: <?php echo json_encode($Diagram2Overskrift); ?>
                    },
                    axisX:{
                        interval: 1,
                        intervalType: "month",
                        valueFormatString: "MMM",
                        crosshair: {
                            enabled: true,
                            snapToDataPoint: true
                        },
                    },
                    axisY: {
                        title: "Avrenning (m3/s)",
                        includeZero: true,
                        crosshair: {
                            enabled: true
                        }
                    },
                    toolTip:{
                        shared:true
                    },  
                    legend:{
                        cursor:"pointer",
                        verticalAlign: "bottom",
                        horizontalAlign: "left",
                        dockInsidePlotArea: true,
                        itemclick: toogleDataSeries
                    },
                    data: [{
                        type: "line",
                        showInLegend: true,
                        name: "Q-Middel",
                        markerType: "square",
                        xValueType: "dateTime",
                        color: "#80b3f6",
                        dataPoints: <?php echo json_encode($Middel, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "line",
                        showInLegend: true,
                        name: "Q-Minimum",
                        color: "#fdc975",
                        dataPoints: <?php echo json_encode($Minimum, JSON_NUMERIC_CHECK); ?>
                    }]
                });
            
                // Tegner Graf2 
                chart2.render();

                // Denne blir brukt i graf2 for å skjule og vise data 
                function toogleDataSeries(e){
                    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    } else{
                        e.dataSeries.visible = true;
                    }
                    chart.render();
                }

                // Tegner Graf3
                var chart3 = new CanvasJS.Chart("chartContainer3", {
                    animationEnabled: true,
                    exportFileName: <?php echo json_encode($Diagram3Overskrift); ?>,  
                    theme: "light2",
                    title:{
                        text: <?php echo json_encode($Diagram3Overskrift); ?>
                    },
                    axisX:{
                        interval: 1,
                        intervalType: "month",
                        valueFormatString: "MMM",
                        crosshair: {
                            enabled: true,
                            snapToDataPoint: true
                        },
                    },
                    axisY: {
						// Her skal vi lage en variabel som setter intervallen på Y-Aksen
                        interval:<?php echo $IntervalSize; ?>,
                        title: "Avrenning (m3/s)",
                        includeZero: true,
                        crosshair: {
                            enabled: true
                        }
                    },
                    data: [{        
                        type: "line",
                        color: "#80b3f6",
                        indexLabelFontSize: 16,
                        xValueType: "dateTime",
                        lineThickness: 1,
                        dataPoints: <?php echo json_encode($Maximum, JSON_NUMERIC_CHECK); ?>
                    }]
                });

                // Tegner Graf3
                chart3.render();

                // Tegner Graf4
                let LW = 1.3;  // Variable for line width
                var chart4 = new CanvasJS.Chart("chartContainer4", {
                    animationEnabled: true,
                    exportFileName: <?php echo json_encode($VarighetsKurveOverskrift); ?>,
                    theme: "light2",
                    title:{
                        text: <?php echo json_encode($VarighetsKurveOverskrift); ?>

                    },
                    axisX:{
                        minimum: 0,
                        maximum: 100,
                        title: "Prosent",
                        interval: 10,
                    },
                    axisY:{
                        minimum: 0,
                        maximum: <?php echo json_encode($Qmiddel * 4, JSON_NUMERIC_CHECK) ?>,
                        interval: <?php echo json_encode($VarighetskurveInterval, JSON_NUMERIC_CHECK) ?>,                    },
                    data: [{        
                        type: "line",
                        lineThickness: LW,
                        title : "Varighetskurve",
                        showInLegend: true,
                        name: "Varighetskurve",
                        indexLabelFontSize: 16,
                        dataPoints: <?php echo json_encode($VarighhetData, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        lineThickness: LW,
                        type: "spline",
                        title : "Slukeevne",
                        color: "#debb0d",
                        name: "Slukeevne",
                        showInLegend: true,
                        indexLabelFontSize: 16,
                        dataPoints: <?php echo json_encode($SlukeevneData, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        lineThickness: LW,
                        type: "spline",
                        title : "Sum Lavere",
                        showInLegend: true,
                        name : "Sum Lavere",
                        indexLabelFontSize: 16,
                        dataPoints: <?php echo json_encode($SumLavereData, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        lineThickness: LW,
                        type: "line",
                        title : "Qmiddel",
                        showInLegend: true,
                        name : "Qmiddel",
                        indexLabelFontSize: 16,
                        dataPoints: <?php echo json_encode($QmiddelData, JSON_NUMERIC_CHECK); ?>
                    }
                ],
                });

                chart4.render();

                var chartVarighetSommer = new CanvasJS.Chart("chartContainerSommer", {
                    animationEnabled: true,
                    theme: "light2",
                    exportFileName: <?php echo json_encode($VarighetsKurveSommerOverskrift); ?>,
                    title:{
                        text: <?php echo json_encode($VarighetsKurveSommerOverskrift); ?>
                    },
                    axisX:{
                        minimum: 0,
                        maximum: 100,
                        title: "Prosent",
                        interval: 10,
                    },
                    axisY:{
                        minimum: 0,
                        maximum: <?php echo json_encode($Qmiddel * 4, JSON_NUMERIC_CHECK) ?>,
                        interval: <?php echo json_encode($VarighetskurveInterval, JSON_NUMERIC_CHECK) ?>,                    },
                    data: [{        
                        type: "line",
                        lineThickness: LW,
                        title : "Varighetskurve",
                        showInLegend: true,
                        name: "Varighetskurve",
                        indexLabelFontSize: 16,
                        dataPoints: <?php echo json_encode($VarighhetDataSommer, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        lineThickness: LW,
                        type: "spline",
                        title : "Slukeevne",
                        color: "#debb0d",
                        name: "Slukeevne",
                        showInLegend: true,
                        indexLabelFontSize: 16,
                        dataPoints: <?php echo json_encode($SlukeevneDataSommer, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        lineThickness: LW,
                        type: "spline",
                        title : "Sum Lavere",
                        showInLegend: true,
                        name : "Sum Lavere",
                        indexLabelFontSize: 16,
                        dataPoints: <?php echo json_encode($SumLavereDataSommer, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        lineThickness: LW,
                        type: "line",
                        title : "Qmiddel",
                        showInLegend: true,
                        name : "Qmiddel",
                        indexLabelFontSize: 16,
                        dataPoints: <?php echo json_encode($QmiddelDataSommer, JSON_NUMERIC_CHECK); ?>
                    }
                ],
                });

                chartVarighetSommer.render();



                var chartVarighetVinter = new CanvasJS.Chart("chartContainerVinter", {
                    animationEnabled: true,
                    theme: "light2",
                    exportFileName: <?php echo json_encode($VarighetsKurveVinterOverskrift); ?>,
                    title:{
                        text: <?php echo json_encode($VarighetsKurveVinterOverskrift); ?>
                    },
                    axisX:{
                        minimum: 0,
                        maximum: 100,
                        title: "Prosent",
                        interval: 10,
                    },
                    axisY:{
                        minimum: 0,
                        maximum: <?php echo json_encode($Qmiddel * 4, JSON_NUMERIC_CHECK) ?>,
                        interval: <?php echo json_encode($VarighetskurveInterval, JSON_NUMERIC_CHECK) ?>,
                    },
                    data: [{        
                        type: "line",
                        lineThickness: LW,
                        title : "Varighetskurve",
                        showInLegend: true,
                        name: "Varighetskurve",
                        indexLabelFontSize: 16,
                        dataPoints: <?php echo json_encode($VarighhetDataVinter, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        lineThickness: LW,
                        type: "spline",
                        title : "Slukeevne",
                        color: "#debb0d",
                        name: "Slukeevne",
                        showInLegend: true,
                        indexLabelFontSize: 16,
                        dataPoints: <?php echo json_encode($SlukeevneDataVinter, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        lineThickness: LW,
                        type: "spline",
                        title : "Sum Lavere",
                        showInLegend: true,
                        name : "Sum Lavere",
                        indexLabelFontSize: 16,
                        dataPoints: <?php echo json_encode($SumLavereDataVinter, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        lineThickness: LW,
                        type: "line",
                        title : "Qmiddel",
                        showInLegend: true,
                        name : "Qmiddel",
                        indexLabelFontSize: 16,
                        dataPoints: <?php echo json_encode($QmiddelDataVinter, JSON_NUMERIC_CHECK); ?>
                    }
                ],
                });

                chartVarighetVinter.render();


                document.getElementById("download1").addEventListener('click', function() {
                    chart1.exportChart({format: "jpg"}); 
                })
                document.getElementById("download2").addEventListener('click', function() {
                    chart2.exportChart({format: "jpg"}); 
                })
                document.getElementById("download3").addEventListener('click', function() {
                    chart3.exportChart({format: "jpg"}); 
                })
                document.getElementById("download4").addEventListener('click', function() {
                    chart4.exportChart({format: "jpg"}); 
                })
                document.getElementById("downloadSommer").addEventListener('click', function() {
                    chartVarighetSommer.exportChart({format: "jpg"}); 
                })
                document.getElementById("downloadVinter").addEventListener('click', function() {
                    chartVarighetVinter.exportChart({format: "jpg"}); 
                })
            }
            
        </script>
</head>
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
</body>
</html>