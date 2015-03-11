$( document ).ready(function()
{
    var days = ["first", "second", "third", "fourth", "fifth"];

    days.forEach(initMap);

    function initMap(element, index, array)
    {
        var miniMap = document.getElementById(element + "-map");

        var lat = miniMap.getAttribute('data-lat');
        var lng = miniMap.getAttribute('data-lng');

        var latlng = new google.maps.LatLng(lat, lng);

        var options = {
            center: latlng,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var carte = new google.maps.Map(miniMap, options);

        var marqueur = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            map: carte
        });
    }

});
