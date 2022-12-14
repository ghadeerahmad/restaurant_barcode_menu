<style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #map {
        height: 500px;
        width: 100%;
    }

    #panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
    }


    #panel,
    .panel {
        font-family: 'Roboto', 'sans-serif';
        line-height: 30px;
        padding-left: 10px;
    }

    #panel select,
    #panel input,
    .panel select,
    .panel input {
        font-size: 15px;
    }

    #panel select,
    .panel select {
        width: 100%;
    }

    #panel i,
    .panel i {
        font-size: 12px;
    }
</style>
<script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyD56PXkzsgJEz5gXkohjDpyNfYiFoMT6aY"></script>
<script>
    var map;
    var address;
    var markers = [];
    var lat_lng = {
        lat: parseFloat('{{$store->latitude}}'),
        lng: parseFloat('{{$store->longtude}}')
    };
    var radius = parseFloat('{{$store->delivery_distance}}');

    function initMap() {
        lat_lng = {
            lat: 33.513063981545386,
            lng: 36.27619029460451
        };



        map = new google.maps.Map(document.getElementById("map"), {
            center: lat_lng,
            zoom: 10,
        });
        infoWindow = new google.maps.InfoWindow();
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    if (lat_lng == null) lat_lng = pos;

                    infoWindow.open(map);
                    map.setCenter(pos);
                    // if (radius != null) {
                    //     addCircle(radius);
                    //     console.log('add circle: ' + radius);
                    // }
                },
                () => {
                    handleLocationError(true, infoWindow, map.getCenter());
                }
            );
            
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }
            addMarker(lat_lng);
        // This event listener will call addMarker() when the map is clicked.  
        map.addListener('click', function(event) {
            addMarker(event.latLng);
        });
        // Adds a marker at the center of the map.  
        //addMarker(lat_lng);

    }

    function setMapOnAll(map) {
        for (let i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    function deleteMarkers() {
        hideMarkers();
        markers = [];
    }
    // Removes the markers from the map, but keeps them in the array.
    function hideMarkers() {
        setMapOnAll(null);
    }

    // Adds a marker to the map and push to the array.  
    function addMarker(location) {
        deleteCircles();
        deleteMarkers();
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
        markers.push(marker);
        lat = marker.position.lat();
        lng = marker.position.lng();
        $("#lat").val(lat);
        $("#lng").val(lng);
        lat_lng = {
            lat: lat,
            lng: lng
        };
    }
    var remove = false;
    var circles = [];

    function deleteCircles() {
        for (let i = 0; i < circles.length; i++) {
            circles[i].setMap(null);
        }
    }

    function addCircle(radius) {
        $("#area").html(radius);
        if (remove) {
            deleteCircles();
        }
        const cityCircle = new google.maps.Circle({
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
            map,
            center: lat_lng,
            radius: (radius / 2) * 1000,
        });
        circles.push(cityCircle);
        remove = true;
        //console.log(cityCircle);
    }
</script>