function initialize() {
    var myLatlng = new google.maps.LatLng(57, -4);
    var myOptions = {
        zoom: 6,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map"), myOptions);
}
var map;
var initial_loc = new google.maps.LatLng(57, -4);
var markers = [];
var colors = {
    'museum': {
        color: 'red'
    },
    'library': {
        color: 'lightblue'

    },
    'heritage centre': {
        color: 'lightgreen'
    },
    'archive centre/records office': {
        color: 'yellow'
    },
    'family history society': {
        color: 'orange'
    },
    'other': {
        color: 'purple'
    }
}
var icons = {
    'museum': {
        icon: '<span class="map-icon map-icon-museum"></span>'
    },
    'library': {
        icon: '<span class="map-icon map-icon-library"></span>'

    },
    'heritage centre': {
        icon: '<span class="map-icon map-icon-local-government"></span>'
    },
    'archive centre/records office': {
        icon: '<span class="map-icon map-icon-book-store"></span>'
    },
    'family history society': {
        icon: '<span class="map-icon map-icon-place-of-worship"></span>'
    },
    'other': {
        icon: '<span style="color: white;" class="map-icon map-icon-embassy"></span>'
    }

};

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
    setMapOnAll(null);
    map.setCenter(initial_loc);
    map.setZoom(6);
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
}

// Function for adding a marker to the page.
var addMarker = function (location, name) {
   var marker = new google.maps.Marker({
        position: location,
        animation: google.maps.Animation.DROP,
        title: name,
        map: map
    });

    markers.push(marker);
};

// Function for adding a marker to the page based on an address.
function addMarkerByAddress(name, address, type, timeout) {
    
    var geocoder = new google.maps.Geocoder();
    window.setTimeout(function() {
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                var marker = new Marker({
                    map: map,
                    animation: google.maps.Animation.DROP,
                    position: results[0].geometry.location,
                    icon: {
                        path: MAP_PIN,
                        fillColor: colors[type.toLowerCase()].color,
                        fillOpacity: 1,
                        strokeColor: '#00000',
                        strokeWeight: 0
                    },
                    map_icon_label: icons[type.toLowerCase()].icon
                });
                markers.push(marker);
                attachMessage(marker, name);
            }
            else {
                // alert('Geocode was not successful for the following reason: ' + status);
            }

            // var bounds = new google.maps.LatLngBounds();
            // for (var i = 0; i < markers.length; i++) {
            //     bounds.extend(markers[i].getPosition());
            // }
            //
            // if (markers.length > 1) {
            //     map.fitBounds(bounds);
            // }

        });
    },timeout);
}

// Attaches an info window to a marker with the provided message. When the
// marker is clicked, the info window will open with the secret message.
function attachMessage(marker, secretMessage) {
    var infowindow = new google.maps.InfoWindow({
        content: secretMessage
    });

    marker.addListener('click', function() {
        if(isInfoWindowOpen(infowindow)){
            infowindow.close();
        }else {
            infowindow.open(marker.get('map'), marker);
        }
    });

}

function isInfoWindowOpen(infoWindow){
    var map = infoWindow.getMap();
    return (map !== null && typeof map !== "undefined");
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

window.addEventListener('load', function () {
    google.maps.event.addDomListener(window, 'load', initialize);
});