<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script type="text/javascript" src="http://geoxml3.googlecode.com/svn/branches/polys/geoxml3.js"></script>
    <script>

var map;
var geoXml;
var infoWindow;

var mouseOverOptions = {
  fillColor: "#FFFF00",
  strokeColor: "#000000",
  fillOpacity: 0.9,
  strokeWidth: 10
};
var normalOptions = {
  fillColor: "#CCCCCC",
  strokeColor: "#000000",
  fillOpacity: 0.9,
  strokeWidth: 10
};

function processDoc(doc) {
  var geoXmlDoc = doc[0];
  var placemarks = geoXmlDoc.placemarks;
  for (var i = 0; i < placemarks.length; i++) {
    setupPolygon(placemarks[i].polygon);
  }
}

function setupPolygon(polygon) {
  polygon.setOptions(normalOptions);
  google.maps.event.addListener(polygon, 'mouseover', function() {
    polygon.setOptions(mouseOverOptions);
  });
  google.maps.event.addListener(polygon, 'mouseout', function() {
    polygon.setOptions(normalOptions);
  });
  google.maps.event.addListener(polygon, 'click', function() {
    // polygon.infoWindow.close();
  });
}

function initialize() {
  var mapOptions = {
    zoom: 4,
    minZoom: 4,
    maxZoom: 7,
    center: new google.maps.LatLng(44.21371, -101.845703)
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  infowindow = new google.maps.InfoWindow({});
  geoXml = new geoXML3.parser({map: map,
    infoWindow: infowindow,
    singleInfoWindow: true,
    zoom: true,
    markerOptions: {optimized: false},
    suppressInfoWindows: false,
    afterParse: processDoc});
  geoXml.parse('http://dl.dropboxusercontent.com/u/5125579/Dream%20Catchers/dreamer-map/us_states_noPoint.xml');
}
google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>