
<!-- Denne filen åpner CSV fil med måledata og beregner gjennomsnitt for hvert år,
Lagrer dette i en CSV fil som vi kaller Tabelldata_Graf1.
Brukes til å lage diagrammet middelavrenning år til år-->

<?php
// Vi trenger noen variabler for filbehandling
// Vi definerer stien til prosjektet...
$projectDir = $userDir . "/projects" . "/" . $_GET["project"];
// og CSVfilen som skal brukes til å lage graf 1
$csv = $projectDir . "/Skalert_" . $_GET["project"]; 
$MDato = array();
$MVerdi = array();

// Nå kan vi lese filen inn i 2 arrays, MDato og MVerdi
$fileHandler = fopen($csv, "r");
while(list($MaleDato, $MaleVerdi) = fgetcsv($fileHandler, 1024, ",")) {
    array_push($MDato, $MaleDato);
    array_push($MVerdi, $MaleVerdi);
}   
fclose($fileHandler);

// Vi finner startår og sluttår i arrayen ved å velge første og siste element i MDato arrayen
// Vi bruker også substring for å få ut kun årstallet.
$StartÅr = substr($MDato[0], -4);
$SluttÅr = substr($MDato[count($MDato)-1], -4);
// echo $StartÅr . "<br>" . $SluttÅr . "<br>";

// Vi trenger også en variabel for å huske hvilke år vi er på
$AktueltÅr = $StartÅr;

// Nå leser vi gjennom Mdato, hvis året = AktueltÅr så henter vi måleverdi fra Mverdi
// Med samme index som Mdato
// Men først må vi klargjøre en fil for skriving hvor vi vil lagre gjennomsnittlig avrenning
// for hvert år. Vi kaller filen TabellData.csv og den blir brukt senere for å lage grafer.
// eller for eksport av data til excel.
$fileWrite = fopen("$projectDir" . "/Tabelldata_Graf1.csv", "w");

// Her går vi gjennom alle elementene i MDato arrayen og sjekker om året er likt AktueltÅr
$i = 0; // Teller for antall målinger
$total = 0; // Variabel for å lagre summen av måleverdiene

foreach($MDato as $index => $dato){
    $DatoMåltÅr = substr($dato, -4);
    if($DatoMåltÅr == $AktueltÅr){
        // Vi legger til måleverdien i totalen der vi bruker samme index som i MDato
        $total += $MVerdi[$index];
        $i++;
    }
    elseif($DatoMåltÅr !== $AktueltÅr){
        // Hvis vi er på siste element i MDato arrayen eller året ikke er likt AktueltÅr
        // så skriver vi gjennomsnittsverdien til fil og øker AktueltÅr med 1  
        $Gjennomsnitt = $total/$i;
        fputcsv($fileWrite, array($AktueltÅr, round($Gjennomsnitt, 4)));
        $AktueltÅr++;
        $total = $MVerdi[$index]; //
        $i = 1;
    }
}
// Når vi er ferdig med å lese gjennom MDato arrayen så har vi ikke skrevet ut siste år
$Gjennomsnitt = $total/$i;
$Gjennomsnitt = round($Gjennomsnitt, 4);
fputcsv($fileWrite, array($AktueltÅr, $Gjennomsnitt));
fclose($fileWrite);
?>