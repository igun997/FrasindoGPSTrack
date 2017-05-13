<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <script src="http://gps.id/engine/userspace.php?user=sandysal0882&session=4e78e7f4160a9a6e6219a25ce74283f3" type="text/javascript"></script>
        <script src="http://gps.id/engine/userpoi.php?user=sandysal0882&session=4e78e7f4160a9a6e6219a25ce7428" type="text/javascript"></script>
       
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css" integrity="sha384-h21C2fcDk/eFsW9sC9h0dhokq5pDinLNklTKoxIZRUn3+hvmgQSffLLQ4G4l2eEr" crossorigin="anonymous">
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
            .labelcar {
                 color: black;
                 background-color: white;
                 font-family: "Calibri";
                 font-size: 10px;
                 font-weight: bold;
                 text-align: center;
                 border: 1px solid white;
                 padding-right: 2px;
                 padding-left: 2px;
                 white-space: nowrap;
               }
            .labels {
                 color: blue;
                 background-color: white;
                 font-family: "Calibri";
                 font-size: 10px;
                 font-weight: bold;
                 text-align: center;
                 padding-right: 2px;
                 padding-left: 2px;
                 border: 1px solid white;
                 white-space: nowrap;
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

    <body onload="load()">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12" style="padding-bottom:10px;">
                        <input class="form-control" id="cari" placeholder="Cari Mobil / Driver / POI" />
                    </div>
                </div>
            </div>
        </div>
        <div id="map"></div>
        <div id="result"></div>
        <script type="text/javascript">
            //<![CDATA[

            var map, infoWindow, intervalId,dataPOI=[],infoPOI,geocoder;
            function load() {
                map = new google.maps.Map(document.getElementById("map"), {
                    center: new google.maps.LatLng(-6.221202, 106.913503),
                    zoom: 13,
                    mapTypeId: 'roadmap'
                });
                geocoder = new google.maps.Geocoder;
                infoWindow = new google.maps.InfoWindow;
                infoPOI = new google.maps.InfoWindow;
                var trafficLayer = new google.maps.TrafficLayer();
                trafficLayer.setMap(map);
                // Trigger downloadUrl at an interval
                intervalId = setInterval(triggerDownload, 9000);
            }
           
            
            function bindInfoWindow(marker, map, infoWindow, html,lat,long) {
                console.log("Start Bind Info");
                console.log("Lat :"+lat+" Long :"+long);
                
                google.maps.event.addListener(marker, 'mouseover', function() {
                    infoWindow.setContent(html);
                    infoWindow.open(map, marker);
                });
            }
            

            var markersArray = [];
            var poiMarkers = [];
            var markerCluster;
            function clearOverlays() {
                for (var i = 0; i < markersArray.length; i++) {
                    markersArray[i].setMap(null);
                }
                 for (var i = 0; i < poiMarkers.length; i++) {
                    poiMarkers[i].setMap(null);
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
           var terdekat=null;
           function getAdr(lat,long)
            {
                    console.log("Get Adress Name");
                   terdekat = $.ajax({
                      method: "GET",
                      url: "<?= base_url("ajax/getAddr/") ?>"+lat+"/"+long
                    })
                      .done(function(msg) {
                        return JSON.parse(msg);
                      });
            }
            function addMarker()
            {
                for(i = 0; i < data.photos.length; i++)
                {
                    var point = new google.maps.LatLng(parseFloat(data.photos[i].latitude),parseFloat(data.photos[i].longitude));
                    var color;
                    var direction = data.photos[i].direction;
                    var clr = "#EEEEEE";
                    if (data.photos[i].status > 0) {
                        if (data.photos[i].speed < 1) {
                            clr = "yellow";
                        } else {
                            clr = "cyan";
                        }
                    }
                    var stat = data.photos[i].status;
                    var lic = data.photos[i].photo_title.split("-")[0];
                    var nama = data.photos[i].photo_title.split("-")[1];
                    var speed = data.photos[i].speed;
                    var lat = parseFloat(data.photos[i].latitude);
                    var long = parseFloat(data.photos[i].longitude);
                     //getAdr(lat,long);
                    
                    var latlng = {lat: lat, lng: long};
                    var mileage = (data.photos[i].mileage/1000).toFixed(2);
                    var mesin = (data.photos[i].status > 0)?'ACTIVE':'OFF';
                    var html = "<div class='address-line full-width'>Car No &nbsp:<b>"+lic+"</b></div><div class='address-line full-width'>Name &nbsp&nbsp: <b>"+nama+"</b></div><div class='address-line full-width'>Speed &nbsp&nbsp: <b>"+speed+" KM/h</b></div><div class='address-line full-width'> Engine  &nbsp: <b>"+mesin+"</b></div><div class='address-line full-width'> Millage</b> : <b>"+mileage+" KM</b></div>";
                    var marker = new MarkerWithLabel({
                        map: map,
                        position: point,
                        icon: {
                            path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                            scale: 3,
                            fillColor: clr,
                            fillOpacity: 1,
                            strokeWeight: 1,
                            rotation: parseInt(direction)
                        },
                        labelContent: data.photos[i].photo_title,
                        labelAnchor: new google.maps.Point(50, -15),
                        labelClass: "labelcar", // the CSS class for the label
                        labelStyle: {opacity: 0.95}
                    });
                    markersArray.push(marker);
                    bindInfoWindow(marker, map, infoWindow, html,lat,long);
                }
                for(i = 0; i < dataPOI.pois.length; i++)
                {
                    var point = new google.maps.LatLng(parseFloat(dataPOI.pois[i].latitude),parseFloat(dataPOI.pois[i].longitude));
                    var nama = dataPOI.pois[i].poiname;
                    if(dataPOI.pois[i].icon == 0)
                    {
                        var iko = 'http://gps.id/image/POI/0.gif';
                    }else if(dataPOI.pois[i].icon == 11){
                        var iko = 'http://gps.id/image/POI/11.gif';
                    }else if(dataPOI.pois[i].icon == 28)
                    {
                        var iko = 'http://gps.id/image/POI/28.gif';
                    }else if(dataPOI.pois[i].icon == 44)
                    {
                        var iko = 'http://gps.id/image/POI/44.gif';
                    }
                    
                     var marker = new MarkerWithLabel({
                           position: point,
                           draggable: false,
                           title : dataPOI.pois[i].poiname,
                           map: map,
                           icon: iko,
                           labelContent: addNewlines(dataPOI.pois[i].poiname),
                           labelAnchor: new google.maps.Point(-9, 15),
                           labelClass: "labels", // the CSS class for the label
                           labelStyle: {opacity: 0.95}
                     });
                    poiMarkers.push(marker);
                    //bindPoiInfo(marker,map,infoPOI);
                }
            }
            function addNewlines(str) {
              var result = '';
              while (str.length > 0) {
                result += str.substring(0, 12) + '<br>';
                str = str.substring(12);
              }
              return result;
            }
          
            

           

            function doNothing() {}
            

            //]]>

        </script>
        <script>
         $("#cari").change(function() {
            var isPoi = false;
            var lic = $("#cari").val();
            var p;
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
                     cari = cari.split("-");
                     console.log(i);
                     if(cari[0].toUpperCase() == lic.toUpperCase() || cari[1].toUpperCase() == lic.toUpperCase())
                     {
                         lat = data.photos[i].latitude;
                         long = data.photos[i].longitude;
                         break;
                     }else{
                         lat = 0;
                         long = 0;
                     }
                   
               }
              if(lat == 0 && long ==0)
              {
                  for(p = 0; p < dataPOI.pois.length; p++){
                      if(lic.toUpperCase() == dataPOI.pois[p].poiname.toUpperCase())
                      {
                          isPoi = true;
                          lat = dataPOI.pois[p].latitude;
                          long = dataPOI.pois[p].longitude;
                          break;
                      }else{
                           lat = 0;
                           long = 0;
                      }
                  }
              }
              console.log("Lat dan Long"+lat+" | "+long);
               if(lat != null && long != null)
               {
                  if(lat != 0 && long != 0 && isPoi != true)
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
                        var mileage = (data.photos[i].mileage/1000).toFixed(2);
                        if (data.photos[i].status > 0) {
                            var engine = 'ACTIVE';
                        } else {
                            var engine = 'OFF';
                        }
                        var content = "<div class='address-line full-width'>Car No &nbsp:<b>"+lic+"</b></div><div class='address-line full-width'>Name &nbsp&nbsp: <b>"+nama+"</b></div><div class='address-line full-width'>Speed &nbsp&nbsp: <b>"+speed+" KM/h</b></div><div class='address-line full-width'> Engine  &nbsp: <b>"+engine+"</b></div><div class='address-line full-width'> Millage</b> : <b>"+mileage+" KM</b></div>";
                        infoWindow = new google.maps.InfoWindow({
                            content: content
                        });
                       infoWindow.open(map, marker);
                  }else if(lat != 0 && long != 0 && isPoi == true){
                        moveToLocation(lat,long);
                           
                  }else{
                        alert("Data Tidak Ditemukan");
                  }
               }
         });
        </script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyD1cM44pjtWnEej7CgCeCVtYx5D70ImTdQ"></script>
         <script src="http://gps.id/scripts/markerwithlabel.js"></script>

    </body>

    </html>
