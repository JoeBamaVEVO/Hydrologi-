<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="canvasjs.min.js"></script>
</head>
<body>
    <?php 
    include "head.php";
    // Sjekker om bruker er logget inn
    if(!isset($_SESSION['idusers'])){
        header("location: index.php");
    }
    // Sjekker om bruker har valgt et prosjekt
    if(empty($_GET['project'])){
        header("location: index.php");
    }
    if(!isset($_GET['project'])){
        header("location: index.php");
    }
    // Sjekker om prosjektet eksisterer
    if(!is_dir($userDir . "/projects" . "/" . $_GET["project"])){
        header("location: index.php");
    }

    if(!is_file($userDir . "/projects" . "/" . $_GET["project"] . "/Skalert_" . $_GET["project"])){ 
        echo "Finner ingen skalert prosjekt fil, vennligst gå tilbake og skaler prosjektet";
        echo '<a href="beregn.php?project="' . $_GET["project"] . '></a>';
    }
    ?>
<script type="text/javascript" src="/CanvasJS/canvasjs-chart-3.7.19/canvasjs.min.js"></script>
<script type="text/javascript">
	  window.onload = function () {
		  var chart = new CanvasJS.Chart("chartContainer", {
			  data: [
			  {
				  type: "column",
				  dataPoints: [
				  { x: 10, y: 10 },
				  { x: 20, y: 15 },
				  { x: 30, y: 25 },
				  { x: 40, y: 30 },
				  { x: 50, y: 28 }
				  ]
			  }
			  ]
		  });
 
		  chart.render();
	  }
  </script>
      <div id="chartContainer" style="height: 500px; width: 50%;"></div>
</body>
</html>