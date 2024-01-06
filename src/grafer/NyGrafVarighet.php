<?php 
$projectDir = $userDir . "/projects" . "/" . $_GET["project"];
$csv = $projectDir . "/Skalert_" . $_GET["project"]; 
$fileHandler = fopen($csv, "r");

$csvWrite = $projectDir . '/TabelldataVarighet.csv';
$fileWrite = fopen($csvWrite, "w");

$MVerdi = array();
$MVerdiSommer = array();
$MVerdiVinter = array();

$QmiddleData = array();
$QmiddleDataSommer = array();
$QmiddleDataVinter = array();

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

    return list($Qmiddle, $Qmedian, $Persentil5) = array($Qmiddle, $Qmedian, $Persentil5);
}

function CreateQmiddleData($Qmiddle, $QmiddleData){
$n = 1;
while($n <= 100){
    $QmiddleData[] = array("y" => $Qmiddle, "x" => $n);
    $n += 99;
}
return $QmiddleData;
}



list($MVerdi, $MVerdiSommer, $MVerdiVinter) = GetWinterSummerData($csv);

// Helårs
GetVarighetskurve($MVerdi, $projectDir . "/Varighet.csv");
// Sommer
GetVarighetskurve($MVerdiSommer, $projectDir . "/SommerVarighet.csv");
//Vinter
GetVarighetskurve($MVerdiVinter, $projectDir . "/VinterVarighet.csv");

// Helårs 
GetSlukeevne($MVerdi, $projectDir . "/Slukeevne.csv");
GetSumLavere($MVerdi, $projectDir . "/SumLavere.csv");

// Sommer
GetSlukeevne($MVerdiSommer, $projectDir . "/SlukeevneSommer.csv");
GetSumLavere($MVerdiVinter, $projectDir . "/SumLavereSommer.csv");

// Vinter
GetSlukeevne($MVerdiVinter, $projectDir . "/SlukeevneVinter.csv");
GetSumLavere($MVerdiVinter, $projectDir . "/SumLavereVinter.csv");

// Helårs
list($Qmiddle, $Qmedian, $Persentil5) = getQmiddleQMedian5Pers($MVerdi);

// Sommer   
list($QmiddleSommer, $QmedianSommer, $Persentil5Sommer) = getQmiddleQMedian5Pers($MVerdiSommer);

// Vinter
list($QmiddleVinter, $QmedianVinter, $Persentil5Vinter) = getQmiddleQMedian5Pers($MVerdiVinter);

// Helårs
$QmiddleData = CreateQmiddleData($Qmiddle, $QmiddleData);
// Sommer
$QmiddleDataSommer = CreateQmiddleData($QmiddleSommer, $QmiddleDataSommer);
// Vinter
$QmiddleDataVinter = CreateQmiddleData($QmiddleVinter, $QmiddleDataVinter);




?>


