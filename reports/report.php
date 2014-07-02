<html>
  <head>        
    <title>My First chart using FusionCharts XT - JSON data URL</title>         
    <script type="text/javascript" src="./charts/FusionCharts.js"></script>
  </head>   
  <body>     
    <div id="chartContainer">FusionCharts XT will load here!</div>          
    <script type="text/javascript"><!--         
      var myChart = new FusionCharts( "../charts/Pie3D.swf","myChartId", "600", "280", "0" );
      myChart.setJSONData( { 
							"chart": 
							{ 
									"caption" : "Top Searches" ,    
									"xAxisName" : "Search Term", 
									"yAxisName" : "Hits",  
									"numberPrefix" : "" ,
									"showexportdatamenuitem":"1"
							},
							"data" : 
							[ 
									{ "label" : "Pants Peter England", "value" : "14400" },
									{ "label" : "Pants Network", "value" : "19600" }, 
									{ "label" : "Pants Oxemberg ", "value" : "24000" }, 
									{ "label" : "Shirts Peter England", "value" : "15700" },
									{ "label" : "Shirts Network", "value" : "14400" },
									{ "label" : "Shirts Oxemberg", "value" : "19600" }
									
							]
						} );
      myChart.render("chartContainer");
    // -->     
    </script>      
  </body> 
</html>