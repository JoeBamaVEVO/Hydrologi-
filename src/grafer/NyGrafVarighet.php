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

list($MVerdi, $MVerdiSommer, $MVerdiVinter) = GetWinterSummerData($csv);

$NewCsv = $projectDir . "/test.csv";


CreateVarighetskurve($MVerdi, $NewCsv);


function CreateVarighetskurve($Array, $csv){
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





// Nå skal vi lage varighetskurve for vinter halvåret   
// $csvWrite = $projectDir . '/TabelldataVarighetVinter.csv';
// $fileWrite = fopen($csvWrite, "w");

// $AktuellVerdi = $MVerdiVinter[0];

// // Vi går gjennom arrayen
// foreach($MVerdiVinter as $index => $Verdi){
//     if($AktuellVerdi > $Verdi){
//         // Vi finner prosenten og skriver til fil sammen med verdien
//         $Prosent = round(($index/count($MVerdiVinter))*100, 4);
//         fputcsv($fileWrite, array($AktuellVerdi, $Prosent));
//         // Definerer AktuellVerdi til å være den nye verdien f.eks 7 -> 5
//         $AktuellVerdi = $Verdi;
//     }
// }


function testWrite($csv){
    $txt = fopen("text.txt", "w");
    foreach ($csv as $key => $value) {
        fwrite($txt, $value . "\n");
    }
    fclose($txt);
}

testWrite($MVerdiSommer);

?>