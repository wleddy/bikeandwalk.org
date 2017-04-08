<?php

$pageTitle = 'Del Rio Trail Bike Count';

## Add items to the header if needed
$extraCSS = '	<style>
		.mapdiv {
			width:220pt;
			height:220pt;
			margin:10pt;
			float:left;
		}
	</style>
';
#$extraHeaders = '';
$extraJS = '
	<link rel=stylesheet type=text/css href="https://app.bikeandwalk.org/static/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="https://app.bikeandwalk.org/static/bikeandwalk.js"></script>
	
    
        <!-- included from map/mapHeaders.html -->
    <script type="text/javascript" src="/js/map.js"></script>
    <link rel="stylesheet" href="https://app.bikeandwalk.org/static/map/map.css" type="text/css" media="all" >
    <script type="text/javascript" src="https://app.bikeandwalk.org/static/map/leaflet/leaflet-src.js"></script>
    <link rel="stylesheet" href="https://app.bikeandwalk.org/static/map/leaflet/leaflet.css" type="text/css" media="all" >
    <script type="text/javascript" src="https://app.bikeandwalk.org/static/map/FlowMarker/leaflet.flowmarker.js"></script>
    <!-- end mapHeaders.html -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" >
	// Initialize the map
    function getAMap(divID, name, lat, lng, n,e){
		var map = new BAWAMap("baw.p0hdja4j", "pk.eyJ1IjoiYmF3IiwiYSI6ImNpanh4bHQ3MzFleXh2d2tpMTNzYXQ0bGcifQ.WNpDcwH6Y9pGVZhUtZOdwg", divID);
		//map.addLocationMarker(name, lat, lng, n, e);
		map.addSimpleLocation(name, lat, lng, false);
	}
	</script>
';

require_once($_SERVER['DOCUMENT_ROOT'].'/templates/base.php'); 


?>