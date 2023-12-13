<?php
// Here we vill make the varighetskurver for the project

$projectDir = $userDir . "/projects" . "/" . $_GET["project"];
$csv = $projectDir . "/Skalert_" . $_GET["project"]; 
$fileHandler = fopen($csv, "r");

// Vi lager 3 arrays som skal inneholde måleverdier fra $csv
$MVerdi = array();
$MVerdiSommer = array();
$MVerdiVinter = array();

// Definerer filen som skal inneholde verdiene som skal brukes til varighetskurven
$csvWrite = $projectDir . '/TabelldataVarighet.csv';
$fileWrite = fopen($csvWrite, "w");

// Vi leser CSV filen og lagrer måleverdier i våre tre arrays
$fileHandler = fopen($csv, "r");
while(list($MaleDato, $MaleVerdi) = fgetcsv($fileHandler, 1024, ",")) {
    array_push($MVerdi, round($MaleVerdi, 3)); // Her runder vi av Måleverdiene
    // Vi skiller mellom sommer og vinter halvår
    $mnd = intval(substr($MaleDato, 3, 2));
    if($mnd >= 5 && $mnd <= 9){  // 1.mai til 30.september er sommerhalvår, 5mnd.
        array_push($MVerdiSommer, round($MaleVerdi, 3));
    }
    else{ // Resten av året er vinterhalvår, 7mnd.
        array_push($MVerdiVinter, round($MaleVerdi, 3));
    }
}  
fclose($fileHandler);

// Vi finner total vannføring over hele måleperioden, 
// og total vannføring for hhv. sommer og vinter
// TotalVann blir brukt i Slukeevne og SumLavere
$TotalVann = array_sum($MVerdi);
$TotalVannSommer = array_sum($MVerdiSommer);
$TotalVannVinter = array_sum($MVerdiVinter);

// Vi sorterer arrayene med måleverdier i synkende rekkefølge
rsort($MVerdi);
rsort($MVerdiSommer);
rsort($MVerdiVinter);

// Vi begynner med å finne varighetskruve for hele året
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

// Nå skal vi lage varighetskruve for sommer og vinter
// Vi begynner med Sommer
$csvWrite = $projectDir . '/TabelldataVarighetSommer.csv';
$fileWrite = fopen($csvWrite, "w");

$AktuellVerdi = $MVerdiSommer[0];

// Vi går gjennom arrayen
foreach($MVerdiSommer as $index => $Verdi){
    if($AktuellVerdi > $Verdi){
        // Vi finner prosenten og skriver til fil sammen med verdien
        $Prosent = round(($index/count($MVerdiSommer))*100, 4);
        fputcsv($fileWrite, array($AktuellVerdi, $Prosent));
        // Definerer AktuellVerdi til å være den nye verdien f.eks 7 -> 5
        $AktuellVerdi = $Verdi;
    }
}

// Nå skal vi lage varighetskruve for vinter halvåret   
$csvWrite = $projectDir . '/TabelldataVarighetVinter.csv';
$fileWrite = fopen($csvWrite, "w");

$AktuellVerdi = $MVerdiVinter[0];

// Vi går gjennom arrayen
foreach($MVerdiVinter as $index => $Verdi){
    if($AktuellVerdi > $Verdi){
        // Vi finner prosenten og skriver til fil sammen med verdien
        $Prosent = round(($index/count($MVerdiVinter))*100, 4);
        fputcsv($fileWrite, array($AktuellVerdi, $Prosent));
        // Definerer AktuellVerdi til å være den nye verdien f.eks 7 -> 5
        $AktuellVerdi = $Verdi;
    }
}

//////////////////////////////////////////////
// Nå skal vi jobbe med Slukeevne grafene
//////////////////////////////////////////////

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

//////////////////////////////////////////////
// Nå skal vi jobbe med Slukevne sommerhalvåret
//////////////////////////////////////////////

// Klargjør filen som skal skrives til 
$csvWrite = $projectDir . '/SlukeevneSommer.csv';
$fileWrite = fopen($csvWrite, "w"); 

// Vi lager en variabel som heter totalVann som er summen av
// alle målingene over alle år
$SlukTotalVann = $TotalVannSommer;

// Denne variablen skal akkumulere tapet i vannføringen
$SlukTotalTap = 0; 

// Først setter vi slukeevnen til å være samme som den største/første målte vannføringen
$Slukeevne = $MVerdiSommer[0];

// Vi går gjennom arrayen for å finne ut....
foreach($MVerdiSommer as $index => $Verdi){
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

//////////////////////////////////////////////
// Nå skal vi jobbe med Slukeevne Vinterhalvåret
//////////////////////////////////////////////

// Klargjør filen som skal skrives til 
$csvWrite = $projectDir . '/SlukeevneVinter.csv';
$fileWrite = fopen($csvWrite, "w"); 

// Vi lager en variabel som heter totalVann som er summen av
// alle målingene over alle år
$SlukTotalVann = $TotalVannVinter;

// Denne variablen skal akkumulere tapet i vannføringen
$SlukTotalTap = 0; 

// Først setter vi slukeevnen til å være samme som den største/første målte vannføringen
$Slukeevne = $MVerdiVinter[0];

// Vi går gjennom arrayen for å finne ut....
foreach($MVerdiVinter as $index => $Verdi){
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


//////////////////////////////////////////////
// Nå skal vi jobbe med Sum Lavere 
//////////////////////////////////////////////

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

////////////////////////////////////////////////
// Nå skal vi jobbe med Sum Lavere Sommer//////
//////////////////////////////////////////////

$csvWrite = $projectDir . '/SumLavereSommer.csv';
$fileWrite = fopen($csvWrite, "w");

// Vi sorterer MVerdi på nytt, men nå i stigende rekkefølge 
sort($MVerdiSommer);

// Først setter vi $MinVann til å være samme som den minste/første målte vannføringen
$MMV = $MVerdiSommer[0]; // står for minste mulige vannføring
$MMVTotalTap = 0;
$gammelIndex = 0;

foreach($MVerdiSommer as $index => $Verdi){
    // Vi sjekker om den nyeste verdien er større enn verdien vi hadde i $MinVann
    if($Verdi > $MMV){
        // Nå må vi beregne hvor mye vann som vil gå tapt for dagene 
        // som allerede har gått, ved at MMV nå er blitt høyere
        $RealIndex = $index - $gammelIndex;
        $TestTap = $MMV * $RealIndex;
        $MMVTotalTap += $TestTap;
       
        // Vi må nå finne prosenten som tapet utgjør av den totale vannføringen
        $MMVTapsProsent = round(($MMVTotalTap/$TotalVannSommer)*100, 4);
        
        // skriver til CSV fil
        fputcsv($fileWrite, array($MMV, $MMVTapsProsent));
        
        // Setter nye verdier, og klar for neste runde
        $MMV = $Verdi;
        $gammelIndex = $index;
    }
}
////////////////////////////////////////////////
// Nå skal vi jobbe med Sum Lavere Vinter//////
//////////////////////////////////////////////


$csvWrite = $projectDir . '/SumLavereVinter.csv';
$fileWrite = fopen($csvWrite, "w");

// Vi sorterer MVerdi på nytt, men nå i stigende rekkefølge 
sort($MVerdiVinter);

// Først setter vi $MinVann til å være samme som den minste/første målte vannføringen
$MMV = $MVerdiVinter[0]; // står for minste mulige vannføring
$MMVTotalTap = 0;
$gammelIndex = 0;

foreach($MVerdiVinter as $index => $Verdi){
    // Vi sjekker om den nyeste verdien er større enn verdien vi hadde i $MinVann
    if($Verdi > $MMV){
        // Nå må vi beregne hvor mye vann som vil gå tapt for dagene 
        // som allerede har gått, ved at MMV nå er blitt høyere
        $RealIndex = $index - $gammelIndex;
        $TestTap = $MMV * $RealIndex;
        $MMVTotalTap += $TestTap;
       
        // Vi må nå finne prosenten som tapet utgjør av den totale vannføringen
        $MMVTapsProsent = round(($MMVTotalTap/$TotalVannVinter)*100, 4);
        
        // skriver til CSV fil
        fputcsv($fileWrite, array($MMV, $MMVTapsProsent));
        
        // Setter nye verdier, og klar for neste runde
        $MMV = $Verdi;
        $gammelIndex = $index;
    }
}

////////////////////////////////////////////////////////
// Nå skal vi jobbe med QMedian, Qmiddel og 5 persentil/
////////////////////////////////////////////////////////
// Vi vil også ha Qmiddel inn på grafen
$Qmiddel = $TotalVann / count($MVerdi);

$Qmedian = $MVerdi[count($MVerdi)/2];

$n = 1;
while($n <= 100){
    $QmiddelData[] = array("y" => $Qmiddel, "x" => $n);
    $n += 99;
}

// Qmiddel Sommer
$QmiddelSommer = $TotalVannSommer / count($MVerdiSommer);
$n = 1;
while($n <= 100){
    $QmiddelDataSommer[] = array("y" => $QmiddelSommer, "x" => $n);
    $n += 99;
}

// Qmiddel Vinter
$QmiddelVinter = $TotalVannVinter / count($MVerdiVinter);
$n = 1;
while($n <= 100){
    $QmiddelDataVinter[] = array("y" => $QmiddelVinter, "x" => $n);
    $n += 99;
}
// QMedian blir echoet ut i grafer.php

// Nå må vi finne 5 persentil
$Persentil5 = 0;
$Persentil5 = $MVerdi[intval(count($MVerdi) * 0.05)];
// Sommer
$PersentilSommer = $MVerdiSommer[intval(count($MVerdiSommer) * 0.05)];
// vinter
$Persentil5Vinter = $MVerdiVinter[intval(count($MVerdiVinter) * 0.05)];

// Persentil5 blir echoet ut i grafer.php
?>