<?php
$projectDir = $userDir . "/projects" . "/" . $_GET["project"];
$csv = $projectDir . "/Skalert_" . $_GET["project"]; 
$fileHandler = fopen($csv, "r");
$MVerdi = array();
// Variabel som skal inneholde den totale vannføringen over hele måleperioden

// Skal inneholde verdiene som skal brukes til grafen
$csvWrite = $projectDir . '/TabelldataVarighet.csv';
$fileWrite = fopen($csvWrite, "w");

// Vi leser CSV filen og lagrer måleverdier i en array
$fileHandler = fopen($csv, "r");
while(list($MaleDato, $MaleVerdi) = fgetcsv($fileHandler, 1024, ",")) {
    array_push($MVerdi, round($MaleVerdi, 3)); // Her runder vi av Måleverdiene
}   
fclose($fileHandler);

// Vi finner total vannføring over hele måleperioden
$TotalVann = array_sum($MVerdi);

// Vi sorterer arrayen med måleverdier i synkende rekkefølge
rsort($MVerdi);

// Vi definerer en verdi som den første verdien i arrayen MVerdi   
$AktuellVerdi = $MVerdi[0];


// Vi går gjennom arrayen
foreach($MVerdi as $index => $Verdi){
    if($AktuellVerdi > $Verdi){
        // Vi finner prosenten og skriver til fil sammen med verdien
        $Prosent = round(($index/count($MVerdi))*100, 4);
        fputcsv($fileWrite, array($AktuellVerdi, $Prosent));
        // Definerer AktuellVerdi til å være den nye verdien f.eks 7 -> 5
        $AktuellVerdi = $Verdi;
    }
}



// Vi begynner på Slukevene her: 
// Klargjør filen som skal skrives til 
$csvWrite = $projectDir . '/Slukeevne.csv';
$fileWrite = fopen($csvWrite, "w");

// Vi lager en variabel som heter totalVann som er summen av
// alle målingene over alle år
$SlukTotalVann = $TotalVann;

// Denne variablen skal akkumulere tapet i vannføringen
$SlukTotalTap = 0; 

// Først setter vi slukeevnen til å være samme som den største/første målte vannføringen
$Slukeevne = $MVerdi[0];

// Vi går gjennom arrayen for å finne ut....
foreach($MVerdi as $index => $Verdi){
    // Vi sjekker om den siste verdien er mindre enn verdien vi hadde i $slukeevne
    if($Verdi < $Slukeevne){
        // Her akkumulerer vi tapet i vannføringen.
        // Vi tar da $Slukevene - $Verdi
        // for å finnen forskjellen mellom verdiene og ganger dette med $index
        // som er lik antall dager.
        // Det nye tapet legges til det gamle tapet i $TotalTap
        $SlukTotalTap += ($Slukeevne - $Verdi) * $index;

        // Vi må nå finne prosenten som tapet utgjør av den totale vannføringen
        $SlukeevneProsent = round(($SlukTotalTap/$SlukTotalVann)*100, 4);

        // Så må vi "Snu-om" prosenten slik at vi får prosenten av vannføringen som er igjen
        $SlukeevneProsent = 100 - $SlukeevneProsent;
        // Nå har vi slukeevne og prosent-satsen som er hhv. Y og X i grafen

        // Nå skriver vi både prosenten og verdien til fil
        fputcsv($fileWrite, array($Slukeevne, $SlukeevneProsent));

        // Vi setter nå slukeevnen til å være den nye verdien
        $Slukeevne = $Verdi;
    }
}

// Nå skal vi jobbe med Sum Lavere Grafen

// ”sum lavere” viser hvor stor del av vannmengden som
// vil gå tapt når vannføringen underskrider lavest mulig driftsvannføring i
// kraftverket/vannverket.

// Klargjør filen som skal skrives til 
$csvWrite = $projectDir . '/SumLavere.csv';
$fileWrite = fopen($csvWrite, "w");

// Vi sorterer MVerdi på nytt, men nå i stigende rekkefølge 
sort($MVerdi);

// Først setter vi $MinVann til å være samme som den minste/første målte vannføringen
$MMV = $MVerdi[0]; // står for minste mulige vannføring
$MMVTotalTap = 0;
$gammelIndex = 0;

foreach($MVerdi as $index => $Verdi){
    // Vi sjekker om den nyeste verdien er større enn verdien vi hadde i $MinVann
    if($Verdi > $MMV){
        // Nå må vi beregne hvor mye vann som vil gå tapt for dagene 
        // som allerede har gått, ved at MMV nå er blitt høyere
        $RealIndex = $index - $gammelIndex;
        $TestTap = $MMV * $RealIndex;
        $MMVTotalTap += $TestTap;
       
        // Vi må nå finne prosenten som tapet utgjør av den totale vannføringen
        $MMVTapsProsent = round(($MMVTotalTap/$TotalVann)*100, 4);
        
        // skriver til CSV fil
        fputcsv($fileWrite, array($MMV, $MMVTapsProsent));
        
        // Setter nye verdier, og klar for neste runde
        $MMV = $Verdi;
        $gammelIndex = $index;
    }
}


// Vi vil også ha Qmiddel inn på grafen
$Qmiddel = $TotalVann / count($MVerdi);

$Qmedian = $MVerdi[count($MVerdi)/2];

$n = 1;
while($n <= 100){
    $QmiddelData[] = array("y" => $Qmiddel, "x" => $n);
    $n += 99;
}
// QMedian blir echoet ut i grafer.php

// Nå må vi finne 5 persentil
$Persentil5 = 0;
$Persentil5 = $MVerdi[intval(count($MVerdi) * 0.05)];
// Persentil5 blir echoet ut i grafer.php



?>