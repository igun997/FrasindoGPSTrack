<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <script src="http://gps.id/engine/userspace.php?user=sandysal0882&session=4e78e7f4160a9a6e6219a25ce74283f3" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
    <title>Tracker Mobil Rental</title>
    <style>
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

    </style>
</head>

<body>
    <div id="map"></div>
    <div id="result"></div>
    <script>
        var i;
        setInterval(function() {
            $.get("<?= base_url("ajax/getData") ?>", function(data) {
                $("#result").html(data);
            });
        }, 20000);

        function initMap() {
            var map;
            var bounds = new google.maps.LatLngBounds();
            var mapOptions = {
                mapTypeId: 'roadmap'
            };

            // Display a map on the page
            map = new google.maps.Map(document.getElementById("map"), mapOptions);
            map.setTilt(45);

            // Multiple Markers
            var markers = [];
            var infoWindowContent = [];
            for (i = 0; i <= data.photos.length - 1; i++) {
                var judul;
                judul = data.photos[i].photo_title;
                var long;
                long = data.photos[i].longitude;
                var lat;
                lat = data.photos[i].latitude;
                var clr = "grey";
                if (data.photos[i].status > 0) {
                 if(data.photos[i].speed < 1)
                 {
                 	clr = "cyan";
                 }else{
                 	clr = "blue";
                 }
                   
                }
                markers.push([judul, lat, long, data.photos[i].direction, clr]);
            }
            // Info Window Content
            for (i = 0; i <= data.photos.length - 1; i++) {
                var head;
                head = data.photos[i].photo_title;
                var lic = head.split('-')[0];
                var nama = head.split('-')[1];
                var speed = data.photos[i].speed;
                if (data.photos[i].status > 0) {
                    var engine = 'Aktif';
                } else {
                    var engine = 'Tidak Aktif';
                }
                infoWindowContent.push(['<p>Lic : ' + lic + '</p><p>Nama : ' + nama + '</p><p>Kecepatan : ' + speed + '</p><p>Direction : ' + data.photos[i].direction + ' Derajat</p><p>Status Mesin : ' + engine + '</p>']);
            }



            // Display multiple markers on a map
            var infoWindow = new google.maps.InfoWindow(),
                marker, i;

            // Loop through our array of markers & place each one on the map  

			var drive = "";
            for (i = 0; i < markers.length; i++) {

                var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                bounds.extend(position);
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: markers[i][0],
                    icon: {
                        path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                        scale: 3,
                        fillColor: markers[i][4],
                        fillOpacity: 0.8,
                        strokeWeight: 1,
                        rotation: parseInt(markers[i][3])
                    }
                });

                // Allow each marker to have an info window    
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infoWindow.setContent(infoWindowContent[i][0]);
                        infoWindow.open(map, marker);
                    }
                })(marker, i));

                // Automatically center the map fitting all markers on the screen
                map.fitBounds(bounds);
            }
            //Trafik Lalu lintas 
            var trafficLayer = new google.maps.TrafficLayer();
            trafficLayer.setMap(map);

            // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
            var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                this.setZoom(12);
                google.maps.event.removeListener(boundsListener);
            });
            setTimeout(initMap, 20000);
        }

    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBR6g9FUm1SRP6AKlfixTh7jpxgUBd7Vm0&callback=initMap">


    </script>
</body>

</html>
