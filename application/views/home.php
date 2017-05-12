<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <script src="http://gps.id/engine/userspace.php?user=sandysal0882&session=4e78e7f4160a9a6e6219a25ce74283f3" type="text/javascript"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css" integrity="sha384-h21C2fcDk/eFsW9sC9h0dhokq5pDinLNklTKoxIZRUn3+hvmgQSffLLQ4G4l2eEr" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
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
            
            .controls {
                margin-top: 10px;
                border: 1px solid transparent;
                border-radius: 2px 0 0 2px;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                height: 32px;
                outline: none;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            }
            
            #pac-input {
                background-color: #fff;
                font-family: Roboto;
                font-size: 15px;
                font-weight: 300;
                margin-left: 12px;
                padding: 0 11px 0 13px;
                text-overflow: ellipsis;
                width: 300px;
            }
            
            #pac-input:focus {
                border-color: #4d90fe;
            }
            
            .pac-container {
                font-family: Roboto;
            }
            
            #type-selector {
                color: #fff;
                background-color: #4d90fe;
                padding: 5px 11px 0px 11px;
            }
            
            #type-selector label {
                font-family: Roboto;
                font-size: 13px;
                font-weight: 300;
            }
            
            #target {
                width: 345px;
            }
            
            body {
                padding: 20px;
            }

        </style>



    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12" style="padding-bottom:10px;">
                        <input class="form-control" id="cari" placeholder="Cari Dengan Lic" />
                    </div>
                </div>
            </div>
        </div>
        <div id="map"></div>
        <div id="result"></div>
        <script type="text/javascript">
            //<![CDATA[

            var map, infoWindow, intervalId;

            var customIcons = {
                restaurant: {
                    icon: 'http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_blue.png'
                },
                bar: {
                    icon: 'http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_red.png'
                }
            };

            function load() {
                map = new google.maps.Map(document.getElementById("map"), {
                    center: new google.maps.LatLng(data.photos[0].latitude, data.photos[0].longitude),
                    zoom: 13,
                    mapTypeId: 'roadmap'
                });

                infoWindow = new google.maps.InfoWindow;
                var trafficLayer = new google.maps.TrafficLayer();
                trafficLayer.setMap(map);

                // Trigger downloadUrl at an interval
                intervalId = setInterval(triggerDownload, 5000);
            }

            function bindInfoWindow(marker, map, infoWindow, html) {
                google.maps.event.addListener(marker, 'click', function() {
                    infoWindow.setContent(html);
                    infoWindow.open(map, marker);
                });
            }

            function bindInfoWindow(marker, map, infoWindow, html) {
                google.maps.event.addListener(marker, 'click', function() {
                    infoWindow.setContent(html);
                    infoWindow.open(map, marker);
                });
            }

            var markersArray = [];
            var markerCluster;
            function clearOverlays() {
                for (var i = 0; i < markersArray.length; i++) {
                    markersArray[i].setMap(null);
                }
               // console.log(markerCluster);
            }

            function triggerDownload() {
                clearOverlays();
                // Change this depending on the name of your PHP file
                 $.get("<?= base_url("ajax/getData") ?>",function(hasil) {
                      $("#result").html(hasil);
                      console.log("Data Loaded");
                     addMarker();
                     //markerCluster = new MarkerClusterer(map, markersArray,{imagePath:'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
                     
                });
            }
            function addMarker()
            {
                for(i = 0; i < data.photos.length; i++)
                {
                    var point = new google.maps.LatLng(parseFloat(data.photos[i].latitude),parseFloat(data.photos[i].longitude));
                    var color;
                    var direction = data.photos[i].direction;
                    var clr = "grey";
                    if (data.photos[i].status > 0) {
                        if (data.photos[i].speed < 1) {
                            clr = "cyan";
                        } else {
                            clr = "blue";
                        }
                    }
                    var lic = data.photos[i].photo_title.split("-")[0];
                    var nama = data.photos[i].photo_title.split("-")[1];
                    var speed = data.photos[i].speed;
                    var mileage = data.photos[i].mileage;
                    var mesin = (data.photos[i].status > 0)?'Aktif':'Mati';
                    var html = "<p>Nomor Polisi :"+lic+"</p><p>Nama :"+nama+"</p><p>Kecepatan :"+speed+" KM</p><p>Mileage :"+mileage+" KM</p><p>Status Mesin :"+mesin+"</p><p>Direction : "+direction+" Derajat</p>";
                    var marker = new google.maps.Marker({
                        map: map,
                        position: point,
                        icon: {
                            path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                            scale: 3,
                            fillColor: clr,
                            fillOpacity: 0.8,
                            strokeWeight: 1,
                            rotation: parseInt(direction)
                        }
                    });
                    markersArray.push(marker);
                    bindInfoWindow(marker, map, infoWindow, html);
                }
            }
          
            

           

            function doNothing() {}
            

            //]]>

        </script>
        <script>
         $("#cari").change(function() {
            var lic = $("#cari").val();
              var cari;
              var lat;
              var long;
               function moveToLocation(lat, lng) {
                    var center = new google.maps.LatLng(lat, lng);
                    map.panTo(center);
               }
               for(i = 0; i <= data.photos.length-1; i++)
               {
                     cari = data.photos[i].photo_title;
                     cari = cari.split("-")[0];
                     console.log(i);
                     if(cari == lic)
                     {
                         lat = data.photos[i].latitude;
                         long = data.photos[i].longitude;
                         break;
                     }else{
                         lat = 0;
                         long = 0;
                     }
                   
               }
                console.log("Lat dan Long"+lat+" | "+long);
               if(lat != null && long != null)
               {
                  if(lat != 0 && long != 0)
                  {
                       moveToLocation(lat,long);
                       var position = new google.maps.LatLng(lat, long);
                        marker = new google.maps.Marker({
                            position: position,
                            map: map,
                            title: data.photos[i].photo_title,
                            icon: {
                                path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                                scale: 3,
                                fillColor: 'red',
                                fillOpacity: 0.8,
                                strokeWeight: 1,
                                rotation: parseInt(data.photos[i].direction)
                            }
                        });
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
                        var content = '<p>Lic : ' + lic + '</p><p>Nama : ' + nama + '</p><p>Kecepatan : ' + speed + '</p><p>Direction : ' + data.photos[i].direction + ' Derajat</p><p>Status Mesin : ' + engine + '</p>';
                        infoWindow = new google.maps.InfoWindow({
                            content: content
                        });
                       infoWindow.open(map, marker);
                  }else{
                      alert("Data Tidak Ditemukan");
                  }
               }
         });
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBR6g9FUm1SRP6AKlfixTh7jpxgUBd7Vm0&callback=load">


        </script>

    </body>

    </html>
