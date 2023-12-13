    <script>
          // Gjør klar CanvasJS for å lage diagram
       window.onload = function () {

        CanvasJS.addColorSet("red", ["#C73A3A"]);

        // Vi setter opp Graf1 og gjør den klar for utskrift
        // Vi gir grafen navnet chart1 og legger den i chartContainer1
        var chart1 = new CanvasJS.Chart("chartContainer1", {
            exportFileName: <?php echo json_encode($Diagram1Overskrift); ?>,
            colorSet: "red",
            animationEnabled: true,
            exportEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title:{
                text: <?php echo json_encode($Diagram1Overskrift); ?>
            },
            axisX:{
                title: "År",
                valueFormatString: "####",
                interval: 5
            },
            axisY:{
                title: "Middelavløp",
                valueFormatString: "#0.## m3/s",
                includeZero: true
            },
            data: [{
                type: "column", //change type to bar, line, area, pie, etc
                // indexLabel: "{y}", //Shows y value on all Data Points
                indexLabelFontColor: "#5A5757",
                indexLabelPlacement: "outside",
                dataPoints: <?php echo json_encode($Graf1, JSON_NUMERIC_CHECK); ?>

            }]
        });

        // Tegner Graf1 
        chart1.render();

        // Vi lager Graf2 og gjør den klar for utskrift
        // Vi gir grafen navnet chart2 og legger den i HTML div chartContainer2
        var chart2 = new CanvasJS.Chart("chartContainer2", {
            exportFileName: <?php echo json_encode($Diagram2Overskrift); ?>,
            animationEnabled: true,
            theme: "light2",
            title:{
                text: <?php echo json_encode($Diagram2Overskrift); ?>
            },
            axisX:{
                interval: 1,
                intervalType: "month",
                valueFormatString: "MMM",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                },
            },
            axisY: {
                title: "Avrenning (m3/s)",
                includeZero: true,
                crosshair: {
                    enabled: true
                }
            },
            toolTip:{
                shared:true
            },  
            legend:{
                cursor:"pointer",
                verticalAlign: "bottom",
                horizontalAlign: "left",
                dockInsidePlotArea: false,
                itemclick: toogleDataSeries
            },
            data: [{
                type: "line",
                showInLegend: true,
                name: "Q-Middel",
                markerType: "square",
                xValueType: "dateTime",
                color: "#80b3f6",
                dataPoints: <?php echo json_encode($Middel, JSON_NUMERIC_CHECK); ?>
            },
            {
                type: "line",
                showInLegend: true,
                name: "Q-Minimum",
                color: "#fdc975",
                dataPoints: <?php echo json_encode($Minimum, JSON_NUMERIC_CHECK); ?>
            }]
        });
    
        // Tegner Graf2 
        chart2.render();

        // Denne blir brukt i graf2 for å skjule og vise data 
        function toogleDataSeries(e){
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else{
                e.dataSeries.visible = true;
            }
            chart.render();
        }

        // Tegner Graf3
        var chart3 = new CanvasJS.Chart("chartContainer3", {
            animationEnabled: true,
            exportFileName: <?php echo json_encode($Diagram3Overskrift); ?>,  
            theme: "light2",
            title:{
                text: <?php echo json_encode($Diagram3Overskrift); ?>
            },
            legend:{
                cursor:"pointer",
                verticalAlign: "bottom",
                horizontalAlign: "left",
                dockInsidePlotArea: false,
                itemclick: toogleDataSeries
            },
            axisX:{
                interval: 1,
                intervalType: "month",
                valueFormatString: "MMM",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                },
            },
            axisY: {
                // Her skal vi lage en variabel som setter intervallen på Y-Aksen
                interval:<?php echo $IntervalSize; ?>,
                title: "Avrenning (m3/s)",
                includeZero: true,
                crosshair: {
                    enabled: true
                }
            },
            data: [{        
                type: "line",
                color: "#80b3f6",
                indexLabelFontSize: 16,
                xValueType: "dateTime",
                lineThickness: 1,
                dataPoints: <?php echo json_encode($Maximum, JSON_NUMERIC_CHECK); ?>
            }]
        });

        // Tegner Graf3
        chart3.render();

        // Tegner Graf4
        let LW = 1.3;  // Variable for line width
        var chart4 = new CanvasJS.Chart("chartContainer4", {
            animationEnabled: true,
            exportFileName: <?php echo json_encode($VarighetsKurveOverskrift); ?>,
            theme: "light2",
            title:{
                text: <?php echo json_encode($VarighetsKurveOverskrift); ?>

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
                interval: <?php echo json_encode($VarighetskurveInterval, JSON_NUMERIC_CHECK) ?>,                    },
            data: [{        
                type: "line",
                lineThickness: LW,
                title : "Varighetskurve",
                showInLegend: true,
                name: "Varighetskurve",
                indexLabelFontSize: 16,
                dataPoints: <?php echo json_encode($VarighhetData, JSON_NUMERIC_CHECK); ?>
            },
            {
                lineThickness: LW,
                type: "spline",
                title : "Slukeevne",
                color: "#debb0d",
                name: "Slukeevne",
                showInLegend: true,
                indexLabelFontSize: 16,
                dataPoints: <?php echo json_encode($SlukeevneData, JSON_NUMERIC_CHECK); ?>
            },
            {
                lineThickness: LW,
                type: "spline",
                title : "Sum Lavere",
                showInLegend: true,
                name : "Sum Lavere",
                indexLabelFontSize: 16,
                dataPoints: <?php echo json_encode($SumLavereData, JSON_NUMERIC_CHECK); ?>
            },
            {
                lineThickness: LW,
                type: "line",
                title : "Qmiddel",
                showInLegend: true,
                name : "Qmiddel",
                indexLabelFontSize: 16,
                dataPoints: <?php echo json_encode($QmiddelData, JSON_NUMERIC_CHECK); ?>
            }
        ],
        });

        chart4.render();

        var chartVarighetSommer = new CanvasJS.Chart("chartContainerSommer", {
            animationEnabled: true,
            theme: "light2",
            exportFileName: <?php echo json_encode($VarighetsKurveSommerOverskrift); ?>,
            title:{
                text: <?php echo json_encode($VarighetsKurveSommerOverskrift); ?>
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
                interval: <?php echo json_encode($VarighetskurveInterval, JSON_NUMERIC_CHECK) ?>,                    },
            data: [{        
                type: "line",
                lineThickness: LW,
                title : "Varighetskurve",
                showInLegend: true,
                name: "Varighetskurve",
                indexLabelFontSize: 16,
                dataPoints: <?php echo json_encode($VarighhetDataSommer, JSON_NUMERIC_CHECK); ?>
            },
            {
                lineThickness: LW,
                type: "spline",
                title : "Slukeevne",
                color: "#debb0d",
                name: "Slukeevne",
                showInLegend: true,
                indexLabelFontSize: 16,
                dataPoints: <?php echo json_encode($SlukeevneDataSommer, JSON_NUMERIC_CHECK); ?>
            },
            {
                lineThickness: LW,
                type: "spline",
                title : "Sum Lavere",
                showInLegend: true,
                name : "Sum Lavere",
                indexLabelFontSize: 16,
                dataPoints: <?php echo json_encode($SumLavereDataSommer, JSON_NUMERIC_CHECK); ?>
            },
            {
                lineThickness: LW,
                type: "line",
                title : "Qmiddel",
                showInLegend: true,
                name : "Qmiddel",
                indexLabelFontSize: 16,
                dataPoints: <?php echo json_encode($QmiddelDataSommer, JSON_NUMERIC_CHECK); ?>
            }
        ],
        });

        chartVarighetSommer.render();



        var chartVarighetVinter = new CanvasJS.Chart("chartContainerVinter", {
            animationEnabled: true,
            theme: "light2",
            exportFileName: <?php echo json_encode($VarighetsKurveVinterOverskrift); ?>,
            title:{
                text: <?php echo json_encode($VarighetsKurveVinterOverskrift); ?>
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


        document.getElementById("download1").addEventListener('click', function() {
            chart1.exportChart({format: "jpg"}); 
        })
        document.getElementById("download2").addEventListener('click', function() {
            chart2.exportChart({format: "jpg"}); 
        })
        document.getElementById("download3").addEventListener('click', function() {
            chart3.exportChart({format: "jpg"}); 
        })
        document.getElementById("download4").addEventListener('click', function() {
            chart4.exportChart({format: "jpg"}); 
        })
        document.getElementById("downloadSommer").addEventListener('click', function() {
            chartVarighetSommer.exportChart({format: "jpg"}); 
        })
        document.getElementById("downloadVinter").addEventListener('click', function() {
            chartVarighetVinter.exportChart({format: "jpg"}); 
        })
    }
</script>
