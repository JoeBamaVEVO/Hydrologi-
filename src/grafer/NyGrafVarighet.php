<?php 
$projectDir = "./Varighetsgraftest";
$csv = $projectDir . "/Skalert_Varighetsgraftest.csv"; 
$fileHandler = fopen($csv, "r");

$csvWrite = $projectDir . '/TabelldataVarighet.csv';
$fileWrite = fopen($csvWrite, "w");

$MVerdi = array();
$MVerdiSommer = array();
$MVerdiVinter = array();


// Function that stores the total data, summer data and winter data in arrays.
function GetWinterSummerData($csv){
    global $MVerdi, $MVerdiSommer, $MVerdiVinter;
    
    $fileHandler = fopen($csv, "r");
    while(list($MaleDato, $MaleVerdi) = fgetcsv($fileHandler, 1024, ",")) {
        array_push($MVerdi, round($MaleVerdi, 3)); // Her runder vi av Måleverdiene
        // Vi skiller mellom sommer og vinter halvår
        $mnd = substr($MaleDato, 3, 2);
        $mnd = intval($mnd);
    
        if($mnd >= 5 && $mnd <= 9){  // 1.mai til 30.september er sommerhalvår, 5mnd.
          array_push($MVerdiSommer, round($MaleVerdi, 3));
        }
        else{ // Resten av året er vinterhalvår, 7mnd.
            array_push($MVerdiVinter, round($MaleVerdi, 3));
        }
    }  
fclose($fileHandler);
return list($MVerdi, $MVerdiSommer, $MVerdiVinter) = array($MVerdi, $MVerdiSommer, $MVerdiVinter);
}

// This function takes an Array of data and then stores that data in a csv file
function GetVarighetskurve($Array, $csv){
    rsort($Array);
    $RelevantValue = $Array[0];
    $fileWrite = fopen($csv, "w");

    foreach($Array as $index => $Value){
        if($RelevantValue > $Value){
            $Prosent = round(($index/count($Array))*100, 4);
            fputcsv($fileWrite, array($RelevantValue, $Prosent));
            $RelevantValue = $Value;
        }
    }
}

function GetSlukeevne($Array, $csv){
    $fileWrite = fopen($csv, "w");

    $SlukTotalWater = array_sum($Array);
    $SlukTotalLoss = 0;

    rsort($Array);
    $Slukeevne = $Array[0];
    
    foreach($Array as $index => $Value){
        if($Value < $Slukeevne){
            $SlukTotalLoss += ($Slukeevne - $Value) * $index;

            $SlukeevnePercent = round(($SlukTotalLoss/$SlukTotalWater)*100, 4);

            $SlukeevnePercent = 100 - $SlukeevnePercent;

            fputcsv($fileWrite, array($Slukeevne, $SlukeevnePercent));
            $Slukeevne = $Value;
        }
    }
    fclose($fileWrite);
}


function GetSumLavere($Array, $csv){
    sort($Array);
    $TotalWater = array_sum($Array);
    $fileWrite = fopen($csv, "w");  

    $MMV = $Array[0];
    $MMVTotalLoss = 0;
    $OldIndex = 0;

    foreach($Array as $index => $Value){
        
        if($Value > $MMV){
            $RealIndex = $index - $OldIndex;
            $Loss = $MMV * $RealIndex;
            $MMVTotalLoss += $Loss;

            $MMVTotalLossPercent = round(($MMVTotalLoss/$TotalWater)*100, 4);

            fputcsv($fileWrite, array($MMV, $MMVTotalLossPercent));

            $MMV = $Value;
            $OldIndex = $index;
        }
    }
    fclose($fileWrite);
}


function getQmiddleQMedian5Pers($Array){
    // Gets the Qmiddle value
    $Qmiddle = array_sum($Array) / count($Array);
    $n = 1;
    // Stores the Qmiddle value in an array for use in the graphs
    while($n <= 100){
        $QmData[] = array("y" => $Qmiddle, "x" => $n);
        $n += 99;
    }

    $Qmedian = $Array[count($Array)/2];
    $Persentil5 = $Array[intval(count($Array) * 0.05)];

    return list($Qmiddle, $Qmedian, $Persentil5) = array($$Qmiddle, $Qmedian, $Persentil5);
}



list($MVerdi, $MVerdiSommer, $MVerdiVinter) = GetWinterSummerData($csv);

GetVarighetskurve($MVerdi, $projectDir . "/Varighet.csv");

GetSlukeevne($MVerdi, $projectDir . "/Slukeevne.csv");

GetSumLavere($MVerdi, $projectDir . "/SumLavere.csv");

list($Qmiddle, $Qmedian, $Persentil5) = getQmiddleQMedian5Pers($MVerdi);

?>


<script>
window.onload = function () {

CanvasJS.addColorSet("red", ["#C73A3A"]);

// Vi setter opp Graf1 og gjør den klar for utskrift
// Vi gir grafen navnet chart1 og legger den i chartContainer1
var chartVarighetVinter = new CanvasJS.Chart("chartContainerVinter", {
            animationEnabled: true,
            theme: "light2",
            exportFileName: "test",
            title:{
                text: "test Varighetskurve",
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

// Tegner Graf1 
chart1.render();

}
</script>