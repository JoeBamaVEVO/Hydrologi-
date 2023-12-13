<?php 
$projectDir = "./Varighetsgraftest";
$csv = $projectDir . "/Skalert_Varighetsgraftest.csv"; 
$fileHandler = fopen($csv, "r");

$csvWrite = $projectDir . '/TabelldataVarighet.csv';
$fileWrite = fopen($csvWrite, "w");

$MVerdi = array();
$MVerdiSommer = array();
$MVerdiVinter = array();

// Function that returns the data from the csv file
function GetWinterSummerData($csv, $MVerdi, $MVerdiSommer, $MVerdiVinter){
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

list($MVerdi, $MVerdiSommer, $MVerdiVinter) = GetWinterSummerData($csv, $MVerdi, $MVerdiSommer, $MVerdiVinter);
echo "Maksimum sommer: " . max($MVerdiSommer) . "<br>";
echo "Maksimum vinter: " . max($MVerdiVinter) . "<br>";
echo "Maksimum totalt: " . max($MVerdi) . "<br>";




function testWrite($csv){
    $txt = fopen("text.txt", "w");
    foreach ($csv as $key => $value) {
        fwrite($txt, $value . "\n");
    }
    fclose($txt);
}

testWrite($MVerdiSommer);

?>