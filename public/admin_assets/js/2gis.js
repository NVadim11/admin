$(document).ready(function () {
    var maps = {};

    var id = 'map_office';
    if(maps[id] != 1){
        var $input = $('input[name='+id+']');
        var coords = $input.val();
        DG.then(function () {
            var map,
                    marker;

            map = DG.map(id, {
                center: coords ? coords.split(',') : [55.62075828167465,37.62243487007321],
                zoom: 15
            });

            marker = DG.marker(coords ? coords.split(',') :[55.62069756913588,37.627067500000024], {
                draggable: true
            }).addTo(map);

            marker.on('drag', function (e) {
                var lat = e.target._latlng.lat.toFixed(3),
                        lng = e.target._latlng.lng.toFixed(3);
                $input.val(lat + ',' + lng);
            });
        });
        maps[id] = 1;
    }

  
});

