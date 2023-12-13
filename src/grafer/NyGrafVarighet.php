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










function testWrite($csv){
    $txt = fopen("text.txt", "w");
    foreach ($csv as $key => $value) {
        fwrite($txt, $value . "\n");
    }
    fclose($txt);
}

testWrite($MVerdiSommer);

?>