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
         <link rel="stylesheet" href="<?= base_url("datetime") ?>/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?= base_url("datetime") ?>/bower_components/moment/min/moment.min.js"></script>
        <script type="text/javascript" src="<?= base_url("datetime") ?>/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <script  type="text/javascript" src="<?= base_url("assets/noui/nouislider.min.js") ?>" ></script>
        <link href="<?= base_url("assets/noui/nouislider.min.css") ?>" rel="stylesheet" >
        <script src="<?= base_url("assets/js/geofences.js") ?>" type="text/javascript"></script>
        
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
                 color: #AA3300;
                 background-color:#FFFFD7 ;
                 font-family: "Roboto","Arial",sans-serif;
                 font-size: 10px;
                 font-weight: bold;
                 text-align: center;
                 border: 1px solid #F3F3F3;
                 padding-right: 2px;
                 padding-left: 2px;
                 white-space: nowrap;
               }
            .slider-selection {
                background: #BABABA;
            }
            .labels {
                 color: #333399;
                 background-color: #FFFFFF;
                 font-family: "Roboto","Arial",sans-serif;
                 font-size: 11px;
                 font-weight: bold;
                 text-align: center;
                 padding-right: 2px;
                 padding-left: 2px;
                 border: 1px solid #F3F3F3;
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
                        <button class="btn btn-success" onclick="tgls()" id="tgls" >Hide Labels</button>
                        <button class="btn btn-success" onclick="tgls_cluster()" id="tgls_clust" >Turn ON Cluster</button>
                        <button class="btn btn-success" onclick="refresh()" id="tgl_refresh" >Turn Off Auto Refresh</button>
                    </div>
                    <div class="col-md-12" style="padding-bottom:10px;">
                        <div id="trackPlayer" class="player text-center hidden">
                         <div class="col-md-6">
                        <button type="button" id="button_play" class="btn" onclick='play()' >
                          <i class="fa fa-play"></i>
                        </button>
                        <button type="button" id="button_pause" class="btn" onclick='play()' >
                          <i class="fa fa-pause"></i>
                        </button> 
                        <button type="button" id="button_stop" class="btn" onclick='ref()'>
                          <i class="fa fa-close"></i>
                        </button>
                        
                         <div id="divRange" class="col-md-6 hidden">
                              <label>- Speed +</label>
                                 <input type="range" class="form-control" type="range" min="-5" max="5" step="1" value="0" id="speed">
                         </div>
                        </div>
                        <div class="col-md-3">
                            <input type="range" class="form-control" type="range" min="1" max="12" step="1" value="1"  id="motion">
                           <b><p id="timeStamp"></p></b>
                        </div>
                        <div class="col-md-3">
                        <select class="form-control" id="switchDate">
                        </select>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="map"></div>
        <div id="result"></div>
        <div id="trackDate" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter Date</h4>
              </div>
              <div class="modal-body">
                <input id="start" class="form-control datetime" placeholder="Start Date"/>
                  <br>
                <input id="end" class="form-control datetime" placeholder="End Date"/>
                <input id="id_car" value="" hidden/>
                <input id="teuid" value="" hidden/>
                <input id="latLong" value="" hidden/>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="submitDate" class="btn btn-success" data-dismiss="modal">Track Now !</button>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('.datetime').datetimepicker({
                    format: 'YYYY-MM-DD'
                });
            });

        </script>
        
        <script type="text/javascript">
            //<![CDATA[
            var RotateIcon = function(options){
                this.options = options || {};
                this.rImg = options.img || new Image();
                this.rImg.src = this.rImg.src || this.options.url || '';
                this.options.width = this.options.width || this.rImg.width || 52;
                this.options.height = this.options.height || this.rImg.height || 60;
                var canvas = document.createElement("canvas");
                canvas.width = this.options.width;
                canvas.height = this.options.height;
                this.context = canvas.getContext("2d");
                this.canvas = canvas;
            };
            RotateIcon.makeIcon = function(url) {
                return new RotateIcon({url: url});
            };
            RotateIcon.prototype.setRotation = function(options){
                var canvas = this.context,
                    angle = options.deg ? options.deg * Math.PI / 180:
                        options.rad,
                    centerX = this.options.width/2,
                    centerY = this.options.height/2;

                canvas.clearRect(0, 0, this.options.width, this.options.height);
                canvas.save();
                canvas.translate(centerX, centerY);
                canvas.rotate(angle);
                canvas.translate(-centerX, -centerY);
                canvas.drawImage(this.rImg, 0, 0);
                canvas.restore();
                return this;
            };
            RotateIcon.prototype.getUrl = function(){
                return this.canvas.toDataURL('image/png');
            };
            var map, infoWindow, intervalId,dataPOI=[],infoPOI,geocoder,showLabel = true,showCluster = false,dataAkun,triggerOn=true,dataTrack,playTrack=true,showPlayer = false,stopTrack=false,getIt;
            function getDtail()
            {
                 console.log("Get Detail Akun");
                  jQuery.ajax({
                        url: '<?= base_url("ajax/getDetailInfo") ?>',
                        success: function (result) {
                            dataAkun = result;
                        },
                        async: false
                    });
            }
            
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
                getDtail();
                // Trigger downloadUrl at an interval
                intervalId = setInterval(function() {
                  if(triggerOn == true) {
                      triggerDownload();
                  }else{
                      console.log("Trigger Off");
                  }
                }, 9000);
            }
            function refresh()
            {
                
                 if(triggerOn == false)
                {
                    
                    triggerOn = true;
                    $("#tgl_refresh").html("Turn Off Auto Refresh");
                    triggerDownload();
                }else{
                    triggerOn = false;
                    $("#tgl_refresh").html("Turn On Auto Refresh");
                    triggerDownload();
                }   
            }
           function tgls()
            {
                if(showLabel == false)
                {
                    showLabel = true;
                    $("#tgls").html("Hide Lables");
                    triggerDownload();
                }else{
                    showLabel = false;
                    $("#tgls").html("Show Lables");
                    triggerDownload();
                }   
            }
            function tgls_cluster()
            {
                if(showCluster == false)
                {
                    showCluster = true;
                    $("#tgls_clust").html("Turn Off Cluster");
                    triggerDownload();
                }else{
                    showCluster = false;
                    $("#tgls_clust").html("Turn On Cluster");
                    triggerDownload();
                }
                console.log(showCluster);
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
            var clust = [];
            var fStore = [];
            function clearOverlays() {
                for (var i = 0; i < markersArray.length; i++) {
                    console.log("Clean Marker")
                    markersArray[i].setMap(null);
                }
                for (var i = 0; i < poiMarkers.length; i++) {
                    console.log("Clean POI")
                    poiMarkers[i].setMap(null);
                }
                if(fStore.length != 0)
                {
                    console.log("Clean Line")
                    for (var i = 0; i < fStore.length; i++) {
                        fStore[i].setMap(null);
                    }
                }
                if(showCluster == true)
                {
                    for (var i = 0; i < clust.length; i++) {
                        clust[i].setMap(null);
                    }
                }else{
                    for (var i = 0; i < clust.length; i++) {
                        clust[i].clearMarkers();;
                    }
                }
                clust = [];
                markersArray = [];
                poiMarkers = [];
                fStore = []
               // console.log(markerCluster);
            }
            var dateLoaded = false;
            var lineTrack = [];
            var timeLine = [];
            function loadTrack(car,teuid,lat,long)
            {
                console.log("Track Started . . .");
                console.log("Data :"+car+teuid+lat+long);
                triggerOn = false;
                if(dateLoaded == true)
                {
                    clearOverlays();
                    var images = "<?= base_url("assets/icon/icon_3_stop.gif") ?>";
                    if (data.photos[i].status > 0) {
                        if (data.photos[i].speed < 1) {
                            images = "<?= base_url("assets/icon/icon_3_lost.gif") ?>";
                        } else {
                            images = "<?= base_url("assets/icon/icon_3_driver.gif") ?>";
                        }
                    }
                    var point = new google.maps.LatLng(parseFloat(lat),parseFloat(long));
                    map.setCenter(point);
                    var nama = data.photos[car].photo_title;
                    var direcion = data.photos[car].direction;
                    var marker = new MarkerWithLabel({
                      position: point,
                      map: map,
                      icon: {
                            url: RotateIcon
                                .makeIcon(
                                    images)
                                .setRotation({deg: direcion})
                                .getUrl(),
                            scale: 3,
                            fillOpacity: 1,
                            strokeWeight: 1,
                            rotation: parseInt(direcion)
                        },
                        labelContent: nama,
                        labelAnchor: new google.maps.Point(50, -15),
                        labelClass: "labelcar", // the CSS class for the label
                        labelStyle: {opacity: 0.95}
                    });
                    markersArray.push(marker);
                    console.log("Path Drawing . .");
                    var flightPath = new google.maps.Polyline({
                      path: lineTrack,
                      geodesic: true,
                      strokeColor: '#2C82C9',
                      strokeOpacity: 0.95,
                      strokeWeight: 5
                    });
                    flightPath.setMap(map);
                    fStore.push(flightPath);
                    var totalTrack = dataTrack.GPS_INFO.DATA.length;
                    console.log("Tracker Value : "+totalTrack);
                    console.log("Set Min Value : "+dataTrack.GPS_INFO.DATA[0].TIME);
                    $("#trackPlayer").removeClass("hidden");
                    $("#motion").attr("min",0);
                    $("#motion").attr("max",totalTrack-1);
                    $("#motion").attr("step",1);
                    $("#motion").attr("value",0);
                    showPlayer = true;
                    showSpeed();
                    if(showPlayer == true)
                    {
                        $("#trackPlayer").removeClass("hidden");
                    }
                    playTrack = true;
                    t = 0;
                    loopTracker(marker,totalTrack,images);
                    
                }else{
                    $("#id_car").val(car);
                    $("#latLong").val(lat+"*"+long);
                    $("#teuid").val(teuid);
                    $("#trackDate").modal("show");
                }
            }
            var t = 0;
            var speedOn = false;
            var intSpeed = 4000;
            function showSpeed()
            {
                 $("#speed").attr("min",(intSpeed/2) * -1);
                 $("#speed").attr("max",100*-1);
                 $("#speed").attr("value",(intSpeed/2) * -1);
                 console.log("Show Interval");
                 $("#divRange").removeClass("hidden");
                
            }
            $("#speed").on("change", function(){
                intSpeed = this.value*-1;
                console.log("Speed Set To : "+intSpeed);
            });
            $("#motion").on("change", function(){
                t = this.value;
                console.log("Set T to : "+t);
            });
            var loopIt;
            function loopTracker(m,totalTrack,images)
            {
                 console.log("Total Track : "+lineTrack.length+ " TotalTrack = "+totalTrack);
                 loopIt = setInterval(function() {
                      if(playTrack == true) {
                          if(lineTrack.length-1 != t)
                          {
                            console.log("Playing Track : "+dataTrack.GPS_INFO.DATA[t].TIME)
                            console.log("Int Speed : "+intSpeed);
                            console.log("Kordinat : "+lineTrack[t].lat+" "+lineTrack[t].lng)
                            var images = "<?= base_url("assets/icon/icon_3_stop.gif") ?>";
                            var direksi = dataTrack.GPS_INFO.DATA[t].DIRECTION;
                            if (dataTrack.GPS_INFO.DATA[t].SPEED > 0) {
                                if (dataTrack.GPS_INFO.DATA[t].SPEED < 1) {
                                    images = "<?= base_url("assets/icon/icon_3_lost.gif") ?>";
                                } else {
                                    images = "<?= base_url("assets/icon/icon_3_driver.gif") ?>";
                                }
                            }
                            var latlng = lineTrack[t];
                            m.setIcon({
                                url :RotateIcon
                                .makeIcon(
                                    images)
                                .setRotation({deg: direksi})
                                .getUrl()
                            });
                            map.setCenter(latlng);
                            m.setPosition(latlng);
                          $("#motion").attr("value",t);
                              var d = new Date(dataTrack.GPS_INFO.DATA[t].TIME*1000);
                              $("#timeStamp").html(d);
                              t++;
                              console.log("Current T : "+t);
                          }else{
                              console.log("Stopping");
                              stopTrack = true;
                              $("#motion").attr("value",0);
                          }
                      }else if(stopTrack == true){
                          clearInterval(loopIt);
                          t = 0;
                      }else{
                          console.log("Paused");
                      }
                     console.log("Recurusive . . ");
                     setInterval(loopIt,intSpeed);
                     console.log("Speed"+intSpeed);
                    }, 2000);
                      
            }
            $("#trackDate").on('hide.bs.modal', function () {
               $(':input', this).val('');
            });
            function play()
            {
                if(playTrack == true)
                {
                    console.log("Pause . . ");
                    playTrack = false;
                    $("#button_stop").attr("disabled");
                    $("#button_pause").attr("disabled");
                    $("#button_play").removeAttr("disabled");
                }else{
                    console.log("Strating . . ");
                    playTrack = true;
                   $("#button_stop").removeAttr("disabled");
                    $("#button_pause").removeAttr("disabled");
                    $("#button_play").attr("disabled");
                }
            }
            function stop()
            {
                console.log("Stopping .. ")
                if(stopTrack == false)
                {
                    stopTrack = true;
                    $("#button_stop").removeAttr("disabled");
                }else{
                     stopTrack = false;
                    $("#button_stop").attr("disabled");
                }
            }
            function ref()
            {
                triggerOn = true;
                showCluster = true;
                dateLoaded = false;
                stopTrack = false;
                playTrack = false;
                $("#trackPlayer").addClass("hidden");
                clearOverlays();
                triggerDownload();
            }
            function getTrack(uid,startDate,endDate)
            {
                 console.log("Data Tracked Loading ...");
                  jQuery.ajax({
                        url: '<?= base_url("ajax/getTrack/")?>'+uid+'/'+startDate+'/'+endDate,
                        success: function (result) {
                            dataTrack = jQuery.parseJSON(result);
                        },
                        async: false
                    });
            }
            function getStatus(uid)
            {
                 console.log("Get Status ID "+uid+" Loading ...");
                  jQuery.ajax({
                        url: '<?= base_url("ajax/getStatus/")?>'+uid,
                        success: function (result) {
                            getIt = jQuery.parseJSON(result);
                        },
                        async: false
                    });
            }
            var teuid,lat,long,id_car,start,end;
            $("#submitDate").click(function() {
              
                console.log("Submit Form  Started..");
                start = $("#start").val();
                end = $("#end").val();
                teuid = $("#teuid").val();
                id_car = $("#id_car").val();
                var latLong = $("#latLong").val();
                lat = latLong.split("*")[0];
                long = latLong.split("*")[1];
                start = Date.parse(start)/1000;
                end = Date.parse(end)/1000;
                dateLoaded = true;
                console.log("Submit Form  END");
                var tempStart = new Date(start*1000);
                var tempEnd = new Date(start*1000);
                tempStart.setHours(00,00,00,000);
                tempStart = Date.parse(tempStart)/1000;
                tempEnd.setHours(23,59,59,999);
                tempEnd = Date.parse(tempEnd)/1000;
                var opt="";
                for (var d =new Date(start*1000); d.getDate() <= new Date(end*1000).getDate(); d.setDate(d.getDate() + 1)) {
                    s = d;
                    s.setHours(00,00,00,000);
                    var value =new Date(s);
                    s = Date.parse(s)/1000;
                    e = d;
                    e.setHours(23,59,59,999);
                    e = Date.parse(e)/1000;
                    console.log(s+"-"+e);
                    opt += "<option value='"+s+"-"+e+"'>"+value.getDate().toString()+"-"+value.getMonth().toString()+"-"+value.getFullYear().toString()+"</option>";
                }
                    $("#switchDate").append(opt);
                
                getTrack(teuid,start,tempEnd);
                for(c = 0; c < dataTrack.GPS_INFO.DATA.length; c++)
                {
                   lineTrack.push({lat : parseFloat(dataTrack.GPS_INFO.DATA[c].LAT),lng : parseFloat(dataTrack.GPS_INFO.DATA[c].LON)});
                }
                console.log("Call Track . . ");
               loadTrack(id_car,teuid,lat,long);
                
            });
            $("#switchDate").on("change", function(){
                clearOverlays();
                dateLoaded = true;
                playTrack = true;
                lineTrack = [];
                dataTrack = [];
                clearInterval(loopIt);
                dateIt = this.value.split("-");
                getTrack(teuid,dateIt[0],dateIt[1]);
                var long,lat;
                for(c = 0; c < dataTrack.GPS_INFO.DATA.length; c++)
                {
                    long = parseFloat(dataTrack.GPS_INFO.DATA[0].LON);
                    lat = parseFloat(dataTrack.GPS_INFO.DATA[0].LAT);
                   lineTrack.push({lat : parseFloat(dataTrack.GPS_INFO.DATA[c].LAT),lng : parseFloat(dataTrack.GPS_INFO.DATA[c].LON)});
                }
             loadTrack(id_car,teuid,lat,long);
                
            });
            function triggerDownload() {
                clearOverlays();
                // Change this depending on the name of your PHP file
                 $.get("<?= base_url("ajax/getData") ?>",function(hasil) {
                      $("#result").html(hasil);
                      console.log("Data Loaded");
                      addMarker();
                    if(showCluster == true)
                    {
                         var clustEr = new MarkerClusterer(map, markersArray,{imagePath:'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
                         clust.push(clustEr);
                    }
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
                    getStatus(data.photos[i].photo_id);
                    var statusAlm = getIt.GPS_INFO.DATA.ALARMSTATE;
                    var images = "<?= base_url("assets/icon/icon_3_stop.gif") ?>";
                    if (data.photos[i].status > 0) {
                        if (data.photos[i].speed < 1) {
                            images = "<?= base_url("assets/icon/icon_3_lost.gif") ?>";
                        }else if(statusAlm > 0){
                            images = "<?= base_url("assets/icon/icon_3_alarm.gif") ?>";
                        }else{
                            images = "<?= base_url("assets/icon/icon_3_driver.gif") ?>";
                        }
                    }
                    var v_detail = jQuery.parseJSON(dataAkun);
                    console.log(v_detail);
                    var teuid = v_detail.VECHILE_INFO.VECHILE[i].TEUID;
                    var stat = data.photos[i].status;
                    var lic = data.photos[i].photo_title.split("-")[0];
                    var nama = data.photos[i].photo_title.split("-")[1];
                    var speed = data.photos[i].speed;
                    var lat = parseFloat(data.photos[i].latitude);
                    var long = parseFloat(data.photos[i].longitude);
                    var label_car = (showLabel == true)?data.photos[i].photo_title:'';
                     //getAdr(lat,long);
                    var latlng = {lat: lat, lng: long};
                    var mileage = (data.photos[i].mileage/1000).toFixed(2);
                    var mesin = (data.photos[i].status > 0)?'ACTIVE':'OFF';
                    var html = "<div class='address-line full-width'>Car No &nbsp: <b>"+lic+"</b></div><div class='address-line full-width'>Name &nbsp&nbsp: <b>"+nama+"</b></div><div class='address-line full-width'>Speed &nbsp&nbsp: <b>"+speed+" KM/h</b></div><div class='address-line full-width'> Engine  &nbsp: <b>"+mesin+"</b></div><div class='address-line full-width'> Millage</b> : <b>"+mileage+" KM</b></div><div class='address-line full-width'> Record</b> : <button onclick='loadTrack("+i+","+teuid+","+lat+","+long+")' class='btn btn-info btn-xs'>Track Record</buttom></div>";
                    var marker = new MarkerWithLabel({
                        map: map,
                        position: point,
                        icon: {
                            url: RotateIcon
                                .makeIcon(
                                    images)
                                .setRotation({deg: direction})
                                .getUrl(),
                            scale: 3,
                            fillColor: clr,
                            fillOpacity: 1,
                            strokeWeight: 1,
                            rotation: parseInt(direction)
                        },
                        labelContent: label_car,
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
                    var poi_label = (showLabel == true)?dataPOI.pois[i].poiname:'';
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
                           labelContent: addNewlines(poi_label),
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
         <script src="<?= base_url("assets/clust.js") ?>"></script>

    </body>

    </html>
