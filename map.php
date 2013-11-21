<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
        html {
            padding: 0;
            margin: 0;
            height: 100%;
        }
        
        body {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
        }
        
      #map-canvas {
        height: 100%;
        position: absolute;
        width: 100%;
        margin: 0px;
        padding: 0px
      }
      
      #storyDiv {
        position: absolute;
        left: 50px; 
        width: 45%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.5);
        z-index: 99;
        display: none;
        padding: 20px;
      }
    </style>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script type="text/javascript" src="http://geoxml3.googlecode.com/svn/branches/polys/geoxml3.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>

var map;
var geoXml;
var infoWindow;

var myStyle = [
       {
         featureType: "administrative",
         elementType: "labels",
         stylers: [
           { visibility: "off" }
         ]
       },{
         featureType: "poi",
         elementType: "labels",
         stylers: [
           { visibility: "off" }
         ]
       },{
         featureType: "water",
         elementType: "labels",
         stylers: [
           { visibility: "off" }
         ]
       },{
         featureType: "road",
         elementType: "labels",
         stylers: [
           { visibility: "off" }
         ]
       }
     ];

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
  google.maps.event.addListener(polygon,'click',function(e){
        var newCenter = new google.maps.LatLng(e.latLng.ob, e.latLng.pb - 7);
        map.setCenter(newCenter);
        map.setZoom(6);
        var storyDiv = document.getElementById('storyDiv');
        storyDiv.setAttribute('style', 'display: block;');
  });
}

function initialize() {
  map = new google.maps.Map(document.getElementById('map-canvas'), {
       mapTypeControlOptions: {
         mapTypeIds: ['mystyle', google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.TERRAIN]
       },
       center: new google.maps.LatLng(38.891033, -95.022461),
       zoom: 5,
       minZoom: 5,
       maxZoom: 7,
       mapTypeId: 'mystyle',
       disableDefaultUI: true
     });

  map.mapTypes.set('mystyle', new google.maps.StyledMapType(myStyle, { name: 'My Style' }));

  var modal = getURLParameter('modal')
  if (modal) {
    $.get(modal, function(data) {
      var modalContainer = $('#storyDiv');
      modalContainer.html(data).show();
    });
  } else {
    infowindow = new google.maps.InfoWindow({});
    geoXml = new geoXML3.parser({map: map,
      infoWindow: infowindow,
      singleInfoWindow: true,
      zoom: false,
      markerOptions: {optimized: false},
      suppressInfoWindows: true,
      afterParse: processDoc});
    geoXml.parse('http://dl.dropboxusercontent.com/u/5125579/Dream%20Catchers/dreamer-map/us_states_noPoint.xml');
  }
}
google.maps.event.addDomListener(window, 'load', initialize);

function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}
    </script>
  </head>
  <body>
    <div id="wrapper">
        <div id="map-canvas"></div>
        <div id="storyDiv"></div> 
    </div>
  </body>
</html>