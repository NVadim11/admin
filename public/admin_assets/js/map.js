function initMap() {
    var x = $("#coord_x").val() * 1;
    var y = $("#coord_y").val() * 1;
    var zoom = $('#map').data('zoom');
    var point;

    if (x && y) {
        point = new google.maps.LatLng(x, y);
        zoom = zoom ?zoom:15;
    } else {
        point = new google.maps.LatLng(55.749643273847624, 37.6173);
        zoom = zoom?zoom:11;
        $("#coord_x").val(55.749643273847624);
        $("#coord_y").val(37.6173);
    }


    var mapOptions = {
        center: point,
        zoom: zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map"), mapOptions);

    var autocomplete = new google.maps.places.Autocomplete(document.getElementById('search'));
    autocomplete.bindTo('bounds', map);

    autocomplete.addListener('place_changed', function () {

        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return false;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
        }

        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

    });


    var marker = new google.maps.Marker({
        position: point,
        map: map,
        draggable: true
    });

    google.maps.event.addListener(marker, "dragend", function () {
        var coord = this.position + '';
        var crd = coord.match(/\(([^,\(]+),\s([^\)]+)\)/);
        $("#coord_x").val(crd[1]);
        $("#coord_y").val(crd[2]);
    });
}



