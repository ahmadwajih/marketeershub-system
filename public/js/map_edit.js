var geocoder;
var googleMap;

function myMap() {

    var mapProp= {
        center:new google.maps.LatLng(lat,long),
        zoom:5,
    };


    googleMap = new google.maps.Map(document.getElementById("googleMap"),mapProp);


    var marker = new google.maps.Marker({
        position:mapProp.center,
        animation:google.maps.Animation.BOUNCE
    });

    marker.setMap(googleMap);

    geocoder = new google.maps.Geocoder();

    geocoder.geocode( {'location': marker.getPosition()}, function(results, status) {
        if (status == 'OK') {
            $('#lat').val(marker.getPosition().lat());
            $('#lng').val(marker.getPosition().lng());
            $("#address").val(results[0].formatted_address);
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
        }
    });

    marker.addListener("click", () => {
        googleMap.setZoom(8);
        googleMap.setCenter(marker.getPosition());
    });


    googleMap.addListener("click", (mapsMouseEvent) => {
        let clickAddress = mapsMouseEvent.latLng.toJSON();
        marker.setPosition(clickAddress);

        geocoder.geocode( {'location': marker.getPosition()}, function(results, status) {
            if (status == 'OK') {
                $('#lat').val(marker.getPosition().lat());
                $('#lng').val(marker.getPosition().lng());
                $("#address").val(results[0].formatted_address);
            } else {
                console.log('Geocode was not successful for the following reason: ' + status);
            }
        });


        $('#lat').val(clickAddress.lat);
        $('#lng').val(clickAddress.lng);

    });

}



