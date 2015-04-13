<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport"
  content="width=device-width, initial-scale=1.0, maximum-scale=1.0:, user-scalable=no">

        <title>Open Data Survey 2015 - List</title>
        <link href="/css3/bootstrap.css" rel="stylesheet" />
        <link href="/dist/jquery.bootgrid.css" rel="stylesheet" />
        <script src="/js3/modernizr-2.8.1.js"></script>
        <style>
            @-webkit-viewport { width: device-width; }
            @-moz-viewport { width: device-width; }
            @-ms-viewport { width: device-width; }
            @-o-viewport { width: device-width; }
            @viewport { width: device-width; }

            body { padding-top: 70px; }
            
            .column .text { color: #f00 !important; }
            .cell { font-weight: bold; }
        </style>


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.min.css">
<link rel="stylesheet" href="//js.arcgis.com/3.13/esri/css/esri.css">
<style>
  html, body {
    padding: 0;
    margin: 0;
    width: 100%;
    height: 100%;
    font-size: 1em;
    font-family: Roboto, "Helvetica Neue", Verdana, Geneva, Arial, Helvetica, sans-serif;
  }

  body {
    padding-top: 70px;
  }

  #map {
    position: relative;
    width: 100%;
    height: 100%;
    z-index: 1;
    margin: 0 auto;
    border: 0px solid green;
  }

  #jqSlider {
    position: absolute;
    left: 2em; /* 32 pixels */
    top: 15.65em; /* 250 pixels */
    height: 12.5em; /* 200 pixels */
    z-index: 2;
    font-size: 0.75em; /* 12 pixels */
  }

  #ui-sample-description {
    position: absolute;
    top: 100px;
    /*top: 1.25em;*/
    left: 1.25em;
    right: 1.25em;
    z-index: 2;
    background-color: #fff;
    border-radius: 0.3125em;
    border: 0.0625em #AAAAAA solid;
  }

  #ui-sample-feedback {
    bottom: 1.25em;
    left: 1.25em;
    z-index: 2;
    position: absolute;
    text-align: center;
    background-color: #fff;
    border-radius: 0.3125em;
    border: 0.0625em #AAAAAA solid;
  }

  .simpleInfoWindow, .simpleInfoWindow .title {
    border-color: #5C9CFF;
  }

  .simpleInfoWindow .title {
    font-weight: bold;
  }

  .ui-header {
    top: 0;
    left: 0;
    right: 0;
    height: 1.875em;
    color: #FFFFFF;
    background-color: #67656c;
    padding: 0.625em 0 0 0.625em;
    border-radius: 0.3125em 0.3125em 0 0;
    border-bottom-color: #FFFFFF;
    border-bottom-width: 0.3125em;
  }

  .ui-content {
    color: #343434;
    background-color: #fff;
    padding: 0.625em 0.625em;
    border-radius: 0 0 0.3125em 0.3125em;
  }

  .ui-drop-shadow {
    -webkit-box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    -moz-box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
  }

  .ui-state-default,
  .ui-widget-content .ui-state-default,
  .ui-widget-header .ui-state-default {
    border: 2px solid #67656c;
  }

  .ui-widget-content {
    border: 2px solid #67656c;
    color: #555555;
  }
</style>

<script src="//js.arcgis.com/3.13compact/"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<script>
  var map;

  require([
      "dojo/dom",
      "dojo/on",
      "esri/Color",
      "esri/config",
      "esri/geometry/webMercatorUtils",
      "esri/graphic",
      "esri/lang",
      "esri/map",
      "esri/symbols/SimpleFillSymbol",
      "esri/symbols/SimpleLineSymbol",
      "esri/symbols/SimpleMarkerSymbol",
      "esri/geometry/Point",
      "esri/layers/GraphicsLayer",
      "dojo/domReady!"
    ],
    function (dom, on, Color, esriConfig, webMercatorUtils, Graphic, lang, Map, SimpleFillSymbol, SimpleLineSymbol,
      SimpleMarkerSymbol, Point, GraphicsLayer){

      var zoomSymbol = new SimpleFillSymbol(SimpleFillSymbol.STYLE_SOLID,
        new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,
          new Color([20, 156, 255]), 1), new Color([141, 185, 219, 0.3]));

      esriConfig.defaults.map.zoomSymbol = zoomSymbol.toJson();

      map = new Map("map", {
        basemap: "gray",
        center: [2.352, 31.00],
        zoom: 2,
        slider: false
      });

      on(map, "load", function (){


  var gl = new GraphicsLayer();
            var p = new Point(-88.380801, 42.10560);
            var s = new SimpleMarkerSymbol().setSize(10);
            var g = new Graphic(p, s);
            gl.add(g);
            map.addLayer(gl);



        console.log("Map load event");
        // Hook up jQuery
        $(document).ready(jQueryReady);
      });

      on(map, "layer-add", function (){
        console.log("Map layer-add event");
      });

      on(map, "extent-change", showExtent);

      map.infoWindow.resize(150, 100);

      function showExtent(event){
        console.log("Map extent-change", JSON.stringify(event.extent));
        var innerContent;
        var extent = webMercatorUtils.webMercatorToGeographic(event.extent);
        innerContent = "XMin: " + extent.xmin.toFixed(2) + " " +
          "YMin: " + extent.ymin.toFixed(2) + " " +
          "XMax: " + extent.xmax.toFixed(2) + " " +
          "YMax: " + extent.ymax.toFixed(2);

        dom.byId("info").innerHTML = innerContent;
      }

      // jQuery stuff
      function jQueryReady(){
        // Create jQuery Slider
        createSlider();

        var markerSymbol = new SimpleMarkerSymbol(SimpleMarkerSymbol.STYLE_X,
          12, new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,
            new Color([92, 156, 255, 1]), 4));

        var graphic;

        on(map, "click", function (event){
          console.log("Map click event");
          // Add a graphic at the clicked location
          if (graphic) {
            graphic.setGeometry(event.mapPoint);
          }
          else {
            graphic = new Graphic(event.mapPoint, markerSymbol);
            map.graphics.add(graphic);
          }

          formatNumber = function (value, key, data){
            return value.toFixed(2);
          };

          var infoContent = lang.substitute(
            webMercatorUtils.webMercatorToGeographic(event.mapPoint),
            "Latitude (y): ${y:formatNumber} <br> Longitude (x): ${x:formatNumber}");

          map.infoWindow.setTitle("Location:");
          map.infoWindow.setContent(infoContent);
          map.infoWindow.show(event.mapPoint);
        });
      }

      function createSlider(){
        $("#jqSlider").slider({
          min: 0,
          max: map.getLayer(map.layerIds[0]).tileInfo.lods.length - 1,
          value: map.getLevel(),
          orientation: "vertical",
          range: "min",
          change: function (event, ui){
            map.setLevel(ui.value);
          }
        });

        on(map, "zoom-end", function (){
          $("#jqSlider").slider("value", map.getLevel());
        });
      }
    });
</script>
</head>
<body>

        <header id="header" class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar">t1</span>
                        <span class="icon-bar">t2</span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand" data-i18n="title">Open Data Enpterprise 2015 Survey</span>
                </div>
                <nav id="menu" class="navbar-collapse collapse" role="navigation">

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Recently submitted surveys</a></li>
                    </ul>
                </nav>
            </div>
        </header>


        <div class="container-fluid" style="border:0px solid orange;">
            <div class="row">
                <div class="col-md-1 visible-md visible-lg" style="border:0px solid green;">
                    <div class="affix">
                        <a href="/survey/opendata/list/new/">view recent</a>
                        <br />
                        <a href="/survey/opendata/" target="_blank">new survey</a>
                        <br />
                        map
                        <!--a href="">all</a-->
                    </div>
                </div>
                <div class="col-md-10" style="border:0px solid blue;">
                    <div style="text-align:center;margin-bottom:12px;">
                        <img class="logo" src="http://uploads.webflow.com/54c24a0650f1708e4c8232a0/54c24f1f6631ca2737e86a02_Logo-Mark.png" width="60" alt="54c24f1f6631ca2737e86a02_Logo-Mark.png">
                        <img class="logo" src="http://uploads.webflow.com/54c24a0650f1708e4c8232a0/54c24fc57bbf1d8c4cfd6581_Logo-Text.png" width="400" alt="54c24fc57bbf1d8c4cfd6581_Logo-Text.png"></a>
                    </div>

               


  <!-- Map canvas -->
  <div id="mapcontainer" style="">
    <div id="map"></div>
  </div>
  <!-- Div that will render jQuery Slider -->
  <div id="jqSlider"></div>
  <div id="ui-sample-description" class="ui-drop-shadow hidden">
    <div class="ui-header">Description</div>
    <div class="ui-content">
      This sample demonstrates the use of <a href=" http://jquery.com/" target="_blank">jQuery</a> library with
      the ArcGIS API for JavaScript (compact). This sample uses the <a href="http://jqueryui.com/slider/"
      target="_blank">Slider</a> UI widget.
      Click on the map for location info.
    </div>
  </div>
  <div id="ui-sample-feedback" class="ui-drop-shadow hidden">
    <div class="ui-header">Current extent</div>
    <div id="info" class="ui-content"></div>
  </div>
  <!-- /Map stuff -->


<!-- grid stuff -->

 </div>
                
            </div>
        </div>

 <footer id="footer" style="margin-top:50px;text-align:center;">
            © Copyright 2015, Center for Open Data Enterprise
        </footer>

        <!--script src="/lib/jquery-1.11.1.min.js"></script-->
        <script src="/js3/bootstrap.js"></script>
        <script src="/dist/jquery.bootgrid.js"></script>



</body>
</html>
 