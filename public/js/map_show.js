var geocoder;
var googleMap;

function myMap() {


    var mapProp= {
        center:new google.maps.LatLng(lat,long),
        zoom:7,
    };


    var googleMap = new google.maps.Map(document.getElementById("googleMap"),mapProp);


    var marker = new google.maps.Marker({
        position:mapProp.center,
        animation:google.maps.Animation.BOUNCE
    });

    marker.setMap(googleMap);


    geocoder = new google.maps.Geocoder();

    geocoder.geocode( {'location': marker.getPosition()}, function(results, status) {
        if (status == 'OK') {
          $('#lng').val(marker.getPosition().lng());
          $('#lat').val(marker.getPosition().lat());

          var lat = marker.getPosition().lat();
          var lng = marker.getPosition().lng();
            

            console.log(lat);
            console.log(lng);
            var link = "https://maps.google.com/?q="+lat+","+lng;

            $("#address").attr('href',link);
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
        }
    });


}
