<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/global.css" type="text/css">
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
        left: 20px; 
        width: 470px;
        height: 94%;
        background-color: rgba(255, 255, 255, 0.5);
        z-index: 99;
        display: none;
        overflow-y: auto;
        top: 75px;
      }
      
      #formDiv {
        top: 50px;
        position: absolute; 
        width: 800px;
        margin: 0 auto;
        background-color: rgba(255, 255, 255, 0.5);
        z-index: 99;
        display: none;
        padding: 20px;
      }
      
      #mapHeader {
        height: 55px;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.5);
        position: absolute;
        z-index: 99;
        padding: 10px;
        display: none;
      }
      
    </style>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script type="text/javascript" src="http://geoxml3.googlecode.com/svn/branches/polys/geoxml3.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>

var map;
var geoXml;
var infoWindow;
var selectedPolygon;
var geoXmlDoc;


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
           { visibility: "off" },
           { saturation: -100 }
         ]
       },{
         featureType: "road",
         elementType: "labels",
         stylers: [
           { visibility: "off" }
         ]
       },{
         featureType: "landscape",
         elementType: "all",
         stylers: [
           { visibility: "on" },
           { hue: "#1aff00" },
           { lightness: -17 }
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
  strokeColor: "#666666",
  fillOpacity: 0.5,
  strokeWidth: 3
};
var selectedOptions = {
  fillColor: "#6666FF",
  strokeColor: "#000000",
  fillOpacity: 0.9,
  strokeWidth: 10
};

function processDoc(doc, callback) {
  geoXmlDoc = doc[0];
  var placemarks = geoXmlDoc.placemarks;
  for (var i = 0; i < placemarks.length; i++) {
    setupPolygon(placemarks[i].polygon);
  }
  if (callback)
  {
    callback();
  }
}

function findPolygonForState(state) {
  var placemarks = geoXmlDoc.placemarks;
  for (var i = 0; i < placemarks.length; i++) {
    var stateTitle = getStateTitle(placemarks[i].polygon.title)
    if (stateTitle == state)
    {
      return placemarks[i].polygon;
    }
  }
  return null;
}

function setupPolygon(polygon) {
  polygon.setOptions(normalOptions);
  google.maps.event.addListener(polygon, 'mouseover', function() {
    if (selectedPolygon != polygon) {
      polygon.setOptions(mouseOverOptions);
    }
  });
  google.maps.event.addListener(polygon, 'mouseout', function() {
    if (selectedPolygon != polygon) {
      polygon.setOptions(normalOptions);      
    }
  });
  google.maps.event.addListener(polygon,'click',function(e){
    if (selectedPolygon) {
      selectedPolygon.setOptions(normalOptions);
    }
    polygon.setOptions(selectedOptions);
    selectedPolygon = polygon;
    var newCenter;
    var mapOffset = 4;
    if (e) {
      newCenter = new google.maps.LatLng(e.latLng.ob, e.latLng.pb - mapOffset);
    } else {
      newCenter = new google.maps.LatLng(polygon.bounds.getCenter().ob, polygon.bounds.getCenter().pb - mapOffset);      
    }
    map.setCenter(newCenter);
    map.setZoom(6);
    showStories(getStateTitle(polygon.title));
  });
}

function getStateTitle(state) {
    var stateArr = state.split('(');
    return stateArr[0].toLowerCase().replace(/ /g,'');
}

function showStories(state) {
    var storyDiv = $('#storyDiv');
    storyDiv.css('display', 'block');
    $.get('story_list.php?state=' + state, function(data) {
      storyDiv.html(data);
    });
}

function hideModal(callback) {
  var modalContainer = $('#formDiv');
  modalContainer.hide();
  showHeader();
  parseGeoXml(callback);
}

function showHeader() {
  $('#mapHeader').show();
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
      var modalContainer = $('#formDiv');
      modalContainer.html(data);
      modalContainer.show();
      modalContainer.css("left", ($(window).width() / 2) - (modalContainer.width() / 2));
    });
  } else {
    showHeader();
    parseGeoXml();
  }
}

function parseGeoXml(callback) {
  infowindow = new google.maps.InfoWindow({});
    geoXml = new geoXML3.parser({map: map,
      infoWindow: infowindow,
      singleInfoWindow: true,
      zoom: false,
      markerOptions: {optimized: false},
      suppressInfoWindows: true,
      afterParse: function (doc) {processDoc(doc, callback)} });
    geoXml.parse('http://www.dreamerstogether.us/us_states_noPoint.xml');
}
google.maps.event.addDomListener(window, 'load', initialize);

function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}
    </script>
  </head>
  <body>
    <div id="mapHeader">
        <img src="images/logo.png" style="float: left; width: 160px">
        <a class="button white" href="map.php?modal=want_form.php">Get Help</a> <a class="button white" href="map.php?modal=give_form.php">Give Help</a>
    </div>      
    <div id="wrapper">
        <div id="map-canvas"></div>
        <div id="storyDiv"></div>
        <div id="formDiv"></div>
    </div>
  </body>
</html>