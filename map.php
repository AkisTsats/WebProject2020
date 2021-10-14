<?php

include('functions.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>IP Address Visualization</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="heatmap.js"></script>
    <script src="leaflet-heatmap.js"></script>

    <style>
        #myMap {
            height: 1280px;
        }
    </style>

</head>




<body>

    <div id="myMap"></div>


    <script type="text/javascript" defer>
        //?access_key=457222a8f1404474e6175a5fd244cd80 (ipstack access key) http://ip-api.com/json/  //'http://api.ipstack.com' + dummyIP + '?access_key=457222a8f1404474e6175a5fd244cd80&fields=longitude,latitude'


        var map = {}; //create

        var baseLayer = L.tileLayer(
            'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '...',
                maxZoom: 18
            }
        );

        var cfg = {
            // radius should be small ONLY if scaleRadius is true (or small radius is intended)
            // if scaleRadius is false it will be the constant radius used in pixels
            "radius": 2,
            "maxOpacity": .8,
            // scales the radius based on map zoom
            "scaleRadius": true,
            // if set to false the heatmap uses the global maximum for colorization
            // if activated: uses the data maximum within the current map boundaries
            //   (there will always be a red spot with useLocalExtremas true)
            "useLocalExtrema": true,
            // which field name in your data represents the latitude - default "lat"
            latField: 'lat',
            // which field name in your data represents the longitude - default "lng"
            lngField: 'lng',
            // which field name in your data represents the data value - default "value"
            valueField: 'count'
        };


        var heatmapLayer = new HeatmapOverlay(cfg);

        var map = new L.Map('myMap', {
            center: new L.LatLng(0, 0),
            zoom: 3,
            layers: [baseLayer, heatmapLayer]
        });


        fetch('http://localhost/registration/api_getIP.php')
            .then(results => results.json())
            .then((myData) => {

                var len = myData.length;

                var testData = {
                    max: 10,
                    data: []
                };
                for (i = 0; i < 50; i++) {

                    //console.log(myData[i]);

                    if (!(myData[i] == "")) {
                        fetch('http://ip-api.com/json/' + myData[i] + '?fields=lat,lon')
                            .then(results => results.json())
                            .then((coord) => {

                                let data = {
                                    lat: coord.lat,
                                    lng: coord.lon,
                                    count: 8
                                }

                                testData.data.push(data);

                                heatmapLayer.setData(testData);

                            }).catch(error => {
                                console.error(error);
                            });;

                    }

                }
                for (i = 50; i < len; i++) {
                    if (!(myData[i] == "")) {
                        fetch('http://api.ipstack.com/' + myData[i] + '?access_key=457222a8f1404474e6175a5fd244cd80&fields=longitude,latitude')
                            .then(results => results.json())
                            .then((coord) => {

                                let data = {
                                    lat: coord.latitude,
                                    lng: coord.longitude,
                                    count: 8
                                }

                                testData.data.push(data);

                                heatmapLayer.setData(testData);

                            }).catch(error => {
                                console.error(error);
                            });;

                    }
                }
            });
    </script>

</body>

</html>