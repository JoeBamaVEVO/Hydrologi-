<!-- Denne filen åpner en CSV fil med måledata og summerer og finner gjennomsnitt for 
hver dag i året over flere år. Den finner også minimum og maksimum verdier for hver dag.
Vi lagrer dette i en CSV fil som vi kaller Tabelldata_Graf2-3.
Brukes til å lage diagramene maks, min og middel avrenning fordelt over årene-->

<?php 
// Vi trenger noen variabler for filbehandling 
$projectDir = $userDir . "/projects" . "/" . $_GET["project"];
$csv = $projectDir . "/Skalert_" . $_GET["project"]; 
$fileHandler = fopen($csv, "r");
$MDato = array();
$MVerdi = array();

// Nå kan vi lese filen inn i 2 arrays, MDato og MVerdi
$fileHandler = fopen($csv, "r");
while(list($MaleDato, $MaleVerdi) = fgetcsv($fileHandler, 1024, ",")) {
    array_push($MDato, $MaleDato);
    array_push($MVerdi, $MaleVerdi);
}   
fclose($fileHandler);

// I ett år er det 365 dager + skuddår. Vi trenger derfor 366 variabler for totaldag,
// mindag, maksdag, og tellerdag. Så vi lager arrays med 366 elementer ved hjelp av for loop.
$Dager = array();
$Teller = array();
$Min = array();
$Maks = array();
for($i = 0; $i < 367; $i++){
    $Dager[$i] = 0;
    $Teller[$i] = 0;
    $Min[$i] = 10000;
    $Maks[$i] = 0;
}

// Vi kjører gjennom arrayen og finner hvilken dag i ett skuddår hver dato er.
// TODO: Forklare nærmere med skuddår
foreach($MDato as $index => $dato){
    // Vi bruker substr for å finne dag og mnd i dato. År er alltid 2008 siden det er et 
    // skuddår. 
    $dag = substr($dato, 0, 2);
    $mnd = substr($dato, 3, 2);
    $year = substr($dato, -4);
    $SkuddÅr = 2008;

    // Vi bruker intval for å konvertere fra string til int.
    $dag = intval($dag);
    $mnd = intval($mnd);

    // Vi bruker date funksjonen for å finne hvilken dag i året det er.
    $DagNummer = date("z", mktime(0,0,0,$mnd,$dag,$SkuddÅr)) + 1;

    // Her akkumulerer vi måleverdier for hver dag i året i riktig "Boks"/array element.
    // Vi øker også teller med 1 for hver måleverdi lagt til, slik at vi kan finne gjennomsnitt
    $Dager[$DagNummer] += $MVerdi[$index];
    $Teller[$DagNummer] += 1;

    // Vi må også finne minimum... 
    if($Min[$DagNummer] > $MVerdi[$index]){
        $Min[$DagNummer] = round($MVerdi[$index], 4);
    }
    // og maksimum for hver dag i året.
    if($Maks[$DagNummer] < $MVerdi[$index]){
        $Maks[$DagNummer] = round($MVerdi[$index], 4);
    }  
}

// Nå skal vi finne gjennomsnittet for hver dag i året.
// Vi lager en array for å lagre gjennomsnittsverdiene.
$Gjennomsnitt = array();
// Vi går gjennom alle elementene i Dager arrayen og deler på teller arrayen.
// Vi bruker round for å runde av til 4 desimaler.
for($i = 1; $i < count($Dager); $i++){
    if($Teller[$i] > 0){
        $Gjennomsnitt[$i] = round($Dager[$i]/$Teller[$i], 4);
    }
    else{
        $Gjennomsnitt[$i] = 0;
    }
}

// Vi henter det første året og det siste året for å vise perioden 
$StartÅr = substr($MDato[0], -4);
$SluttÅr = substr($MDato[count($MDato)-1], -4);

// Nå har vi alle verdiene vi trenger for å lage en CSV fil med data for hver dag i året.
// Vi lager en fil for skriving.
$csv = $projectDir . "/Tabelldata_Graf2-3.csv";
$fileWrite = fopen($csv, "w");
// Vi skriver til filen ved hjelp av fputcsv funksjonen.
$date = date("d-m-Y", strtotime("31-12-2007"));

for($i = 1; $i < count($Dager); $i++){
    $new_date = date("d-m-Y", strtotime("+$i day" . $date));
    fputcsv($fileWrite, array($new_date, $Gjennomsnitt[$i], $Maks[$i], $Min[$i], ));
}
fclose($fileWrite);
?>
