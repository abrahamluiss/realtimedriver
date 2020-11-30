<!-- Nom &amp; Prénom: WOUMTANA P. Youssouf
            Téléphone: +226 63 86 22 46 / 73 35 41 41
                Email: issoufwoumtana@gmail.com -->
                <?php

    include("query/fonction2.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    

    <!-- Bootstrap Core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="assets/plugins/morrisjs/morris.css" rel="stylesheet">

    
	<style> 
        #map { 
            height: 500px; 
            width: 100%; 
        } 
	</style> 

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div> -->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div class="row m-t-0">
                    <div class="col-md-12">
                
                        <h3>map</h3> 
                        <div id="map"></div> 

                        <script async defer 
                            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChoPczWIfOyvAtHmp5p0ieVFAexYMcPEw&callback=initMap"> 
                        </script> 

                    </div>
                </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->

    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--sparkline JavaScript -->
    <script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--morris JavaScript -->
    <script src="assets/plugins/raphael/raphael-min.js"></script>
    <script src="assets/plugins/morrisjs/morris.min.js"></script>
    <!-- Chart JS -->
    
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->

    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    <!-- Chart JS -->
    <script src="assets/plugins/Chart.js/chartjs.init.js"></script>
    <script src="assets/plugins/Chart.js/Chart.min.js"></script>
    <!-- ============================================================== -->

    
    <!--Custom JavaScript -->
    <!-- <script src="js/custom.min.js"></script> -->
    <script src="assets/plugins/toast-master/js/jquery.toast.js"></script>
   
    <!-- This is data table -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script>
        // $('#example24').DataTable();
    </script>

    <script>
        initMap();
        var gmarkers = [];
        var map;
        function initMap(){
            $.ajax({
                url: "query/ajax/getAllVehicle.php",
                type: "POST",
                data: {"id":"ok"},
                success: function (data) {
                    var data_parse = JSON.parse(data);
                    if(data_parse.length != 0){
                        for(var i=0; i<data_parse.length; i++){
                            var lat = data_parse[i].latitude;
                            var lng = data_parse[i].longitude;
                            var prenom = data_parse[i].prenom;
                            var phone = data_parse[i].phone;
                            var nom = data_parse[i].nom;
                            var online = data_parse[i].online;
                            var nom_prenom = prenom+" "+nom;
                            var uluru = {lat: parseFloat(lat), lng: parseFloat(lng)}; 
                            if(i==0){
                                map = new google.maps.Map(document.getElementById('map'), { 
                                zoom: 15,
                                center: uluru 
                                }); 
                            }
                            if(online == "yes")
                                var image = 'http://localhost/verliveautos/assets/images/marker.png';
                            else
                                var image = 'http://localhost/verliveautos/assets/images/marker_red.png';
                            var marker = new google.maps.Marker({ 
                                position: uluru, 
                                map: map, 
                                icon: image, 
                                title: nom_prenom 
                            }); 
                            showInfo(map,marker,phone);
                            // Push your newly created marker into the array:
                            gmarkers.push(marker);
                        }
                    }else{
                        var uluru = {lat: parseFloat("-12.0664"), lng: "-75.2100"}; 
                        map = new google.maps.Map(document.getElementById('map'), { 
                        zoom: 15,
                        center: uluru 
                        }); 
                    }
                    addYourLocationButton(map, marker);
                }
            });
        }
        function showInfo(map,marker,phone){
            var infoWindow = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'click', function () {
                var markerContent = "<h4>Nombre : "+marker.getTitle()+"</h4> <h6>Phone : "+phone+"</h6>";
                infoWindow.setContent(markerContent);
                infoWindow.open(map, this);
            });
            new google.maps.event.trigger( marker, 'click' );
        }
        function addYourLocationButton(map, marker) {
            var controlDiv = document.createElement('div');

            var firstChild = document.createElement('button');
            firstChild.style.backgroundColor = '#fff';
            firstChild.style.border = 'none';
            firstChild.style.outline = 'none';
            firstChild.style.width = '40px';
            firstChild.style.height = '40px';
            firstChild.style.borderRadius = '2px';
            firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
            firstChild.style.cursor = 'pointer';
            firstChild.style.marginRight = '10px';
            firstChild.style.padding = '0px';
            firstChild.title = 'Your Location';
            controlDiv.appendChild(firstChild);

            var secondChild = document.createElement('div');
            secondChild.style.margin = '10px';
            secondChild.style.width = '18px';
            secondChild.style.height = '18px';
            secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
            secondChild.style.backgroundSize = '180px 18px';
            secondChild.style.backgroundPosition = '0px 0px';
            secondChild.style.backgroundRepeat = 'no-repeat';
            secondChild.id = 'you_location_img';
            firstChild.appendChild(secondChild);

            google.maps.event.addListener(map, 'dragend', function() {
                $('#you_location_img').css('background-position', '0px 0px');
            });

            firstChild.addEventListener('click', function() {
                var imgX = '0';
                var animationInterval = setInterval(function(){
                    if(imgX == '-18') imgX = '0';
                    else imgX = '-18';
                    $('#you_location_img').css('background-position', imgX+'px 0px');
                }, 500);
                if(navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        marker.setPosition(latlng);
                        map.setCenter(latlng);
                        clearInterval(animationInterval);
                        $('#you_location_img').css('background-position', '-144px 0px');
                    });
                }
                else{
                    clearInterval(animationInterval);
                    $('#you_location_img').css('background-position', '0px 0px');
                }
            });

            controlDiv.index = 1;
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
        }
        
        function removeMarkers(){
            for (i = 0; i < gmarkers.length; i++) {
                gmarkers[i].setMap(null);
            }
        }
        function getVehicleAll2(){
            $.ajax({
                url: "query/ajax/getAllVehicle.php",
                type: "POST",
                data: {"id":"ok"},
                success: function (data) {
                    var data_parse = JSON.parse(data);
                    removeMarkers();
                    for(var i=0; i<data_parse.length; i++){
                        var lat = data_parse[i].latitude;
                        var lng = data_parse[i].longitude;
                        var prenom = data_parse[i].prenom;
                        var phone = data_parse[i].phone;
                        var nom = data_parse[i].nom;
                        var online = data_parse[i].online;
                        var nom_prenom = prenom+" "+nom;
                        var uluru = {lat: parseFloat(lat), lng: parseFloat(lng)}; 
                        if(online == "yes")
                            var image = 'http://localhost/verliveautos/assets/images/marker.png';
                        else
                            var image = 'http://localhost/verliveautos/assets/images/marker_red.png';
                        var marker = new google.maps.Marker({ 
                            position: uluru, 
                            map: map, 
                            icon: image, 
                            title: nom_prenom 
                        }); 
                        showInfo(map,marker,phone);
                        // Push your newly created marker into the array:
                        gmarkers.push(marker);
                    }
                }
            });
        }
        function foo() {
            var day = new Date().getDay();
            var hours = new Date().getHours();

            // alert('day: ' + day + '  Hours : ' + hours );
            getVehicleAll2();

            if (day === 0 && hours > 12 && hours < 13){}
            // Do what you want here:
        }

        setInterval(foo, 7000);


    </script>

</body>

</html>