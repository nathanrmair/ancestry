@if(isset($provider_id))<?php $data = App\Provider::where('provider_id', '=', $provider_id)->first();?>
@else <?php $data = App\Provider::where('user_id', '=', $user_id)->first();?>
@endif
<!--NOTE - key is not associated with an appropriate account and should be changed before the website goes live-->
<?php $mapKey = App\Http\Controllers\MapController::getMapKey(); ?>
<script defer
        src="https://maps.googleapis.com/maps/api/js?key={{$mapKey}}&callback=initialize"></script>

<script>
    function initialize() {
        var myLatlng = new google.maps.LatLng(57, -4);
        var myOptions = {
            zoom: 7,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map"), myOptions);
        addMarkerByAddress(parseAddress());
    }
    var map;
    var markers = [];
    var infowindow = null;

    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        setMapOnAll(null);
    }
    // Sets the map on all markers in the array.
    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }


    // Function for deleting markers.
    function deleteMarkers() {
        clearMarkers();
        markers = [];
    }


    // Function for adding a marker to the page.
    var addMarker = function (location, name) {
        marker = new google.maps.Marker({
            position: location,
            animation: google.maps.Animation.DROP,
            title: name,
            map: map
        });

        markers[0] = marker;
    }

    // Function for adding a marker to the page based on an address.
    function addMarkerByAddress(address) {
        //code based on google geocoding eample
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    animation: google.maps.Animation.DROP,
                    position: results[0].geometry.location
                });
                markers[0] = marker;
                //alert('Geocode was successful: '+ status);
            }
            /*else {
             alert('Geocode was not successful for the following reason: ' + status);
             }*/
        });
    }


    function AutoCenter() {
//  Create a new viewpoint bound
        google.maps.event.trigger(map, "resize");
        map.panTo(markers[0].getPosition());
        map.setZoom(17);
        google.maps.event.trigger(map, 'resize');
    }

    function map_reload() {
        google.maps.event.trigger(map, 'resize');
    }

    function parseAddress() {
                @if(isset($data->postcode))
        var address = "<?php echo $data->postcode ?>";
        return address;
                @elseif(isset($data->street_name) && isset($data->town))
        var almost_address = "<? echo $data->street_name . ' ' . $data->town?>"
        return almost_address;
        @else
                return "";
        @endif
    }

    window.addEventListener('load', function () {
        google.maps.event.addDomListener(window, 'load', initialize);
    });

</script>
        <div class="text-center">
            <h2>Map</h2>
        </div>
        <div id="map" style="height:400px;"></div>