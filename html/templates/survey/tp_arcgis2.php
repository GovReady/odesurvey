<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no"/>
    <title>Simple Map</title>
    <link rel="stylesheet" href="http://js.arcgis.com/3.13/esri/css/esri.css">
    <style>
      html, body, #map {
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
      }
      body {
        background-color: #FFF;
        overflow: hidden;
        font-family: "Trebuchet MS";
      }
    </style>
    <script src="http://js.arcgis.com/3.13/"></script>
    <script>
      var map, csv;

      require([
        "esri/map", 
        "esri/layers/CSVLayer",
        "esri/Color",
        "esri/symbols/SimpleMarkerSymbol",
        "esri/renderers/SimpleRenderer",
        "esri/InfoTemplate",
        "esri/urlUtils",
        "dojo/domReady!"
      ], function(
        Map, CSVLayer, Color, SimpleMarkerSymbol, SimpleRenderer, InfoTemplate, urlUtils
      ) {
        urlUtils.addProxyRule({
          proxyUrl: "/proxy/.ashx",
          urlPrefix: "earthquake.usgs.gov"
        });
        map = new Map("map", {
          basemap: "gray",
          center: [ -60, -10 ],
          zoom: 4 
        });
        csv = new CSVLayer("http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.csv", {
          copyright: "USGS.gov"
        });
        var orangeRed = new Color([238, 69, 0, 0.5]); // hex is #ff4500
        var marker = new SimpleMarkerSymbol("solid", 15, null, orangeRed);
        var renderer = new SimpleRenderer(marker);
        csv.setRenderer(renderer);
        var template = new InfoTemplate("${type}", "${place}");
        csv.setInfoTemplate(template);
        map.addLayer(csv);
      });
    </script>
  </head>

  <body>
    <div id="map"></div>
  </body>
</html>