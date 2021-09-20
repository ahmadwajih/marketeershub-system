var geocoder;
var googleMap;

function myMap() {

    myLatlng = { lat: 30.033333, lng: 31.233334 };

    var mapProp= {
    center:myLatlng,
    zoom:5,
    };


    googleMap = new google.maps.Map(document.getElementById("googleMap"),mapProp);


    var marker = new google.maps.Marker({
    position:mapProp.center,
    animation:google.maps.Animation.BOUNCE
    });

    marker.setMap(googleMap);


    geocoder = new google.maps.Geocoder();

    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            marker.setPosition(pos);

            geocoder.geocode( {'location': marker.getPosition()}, function(results, status) {
                if (status == 'OK') {
                    $('#lat').val(marker.getPosition().lat());
                    $('#lng').val(marker.getPosition().lng());
                    $("#address").val(results[0].formatted_address);
                } else {
                    console.log('Geocode was not successful for the following reason: ' + status);
                }
            });

        });
    }

    marker.addListener("click", () => {
    googleMap.setZoom(8);
    googleMap.setCenter(marker.getPosition());
    });


    googleMap.addListener("click", (mapsMouseEvent) => {
    let clickAddress = mapsMouseEvent.latLng.toJSON();
    marker.setPosition(clickAddress);



    geocoder.geocode( {'location': marker.getPosition()}, function(results, status) {
        if (status == 'OK') {
            $("#address").val(results[0].formatted_address);
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
        }
    });


    $('#lat').val(clickAddress.lat);
    $('#lng').val(clickAddress.lng);

    });

}



