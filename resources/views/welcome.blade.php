<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- leaflet css -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
         
        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            #mapid { 
                height: 512px; 
                width: 512px;
                border: 2px solid black;
            }
        </style>
    </head>
    <body>
        <h1>gis project</h1>
        <div id="mapid"></div>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script>
        const ACCESS_TOKEN = 'pk.eyJ1IjoibXVoYW1tYWRnZW50YWF0aHRoYXJyaXEiLCJhIjoiY2tyZDA2bjEyMDA1MzJ3bzVoYm16aGx1dyJ9.LS0Fbc5bnZ5i3CIS5LMYOQ';
        let map = L.map('mapid').setView([-6.914864, 107.608238], 13);
        L.tileLayer(`https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=${ACCESS_TOKEN}`, {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: ACCESS_TOKEN
        }).addTo(map);

        let circle;
        map.on('click', function(e) {
            const {lat, lng} = e.latlng;
            circle = L.circle([lat, lng], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 10000
            }).addTo(map)
        } );

        map.on('draw:created', function (e) {
          var type = e.layerType;
          let layer = e.layer;
          if (type === 'circle') {
            circle.addLayer(layer);
            var seeArea = L.GeometryUtil.geodesicArea(layer.getLatLngs());
            console.log(seeArea);
          }
          console.log(e)
        })
    </script>
    </body>
</html>
