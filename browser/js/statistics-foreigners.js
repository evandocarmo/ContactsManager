var infowindow = null;

$(document).ready(function () {
    var map = new google.maps.Map(document.getElementById("heatmap-area"), myOptions);

    setMarkers(map, sites);

    var kingdonHall = new google.maps.Marker({
        position: new google.maps.LatLng('-19.92020', '-43.99741'),
        map: map,
        icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
        zIndex: 10000
    });

    infowindow = new google.maps.InfoWindow({
        content: "loading..."
    });

    var bikeLayer = new google.maps.BicyclingLayer();

    bikeLayer.setMap(map);
    
    var googleMapWidth = $("#heatmap-area").css('width');
    var googleMapHeight = $("#heatmap-area").css('height');

    $('#enter-full-screen').click(function () {
        $("#heatmap-area").css("position", 'fixed').
                css('top', 0).
                css('left', 0).
                css("width", '100%').
                css("height", '100%');
        google.maps.event.trigger(map, 'resize');
        map.setCenter(new google.maps.LatLng('-19.92020', '-43.99741'));
        return false;
    });
});

function setMarkers(map, markers)
{
    for (var i = 0; i < markers.length; i++)
    {
        var sites = markers[i];
        var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
        var marker = new google.maps.Marker({
            clickable: true,
            cursor: "pointer",
            position: siteLatLng,
            map: map,
            title: sites[0],
            zIndex: sites[3],
            html: sites[4],
            icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
        });

        google.maps.event.addListener(marker, "click", function () {
            infowindow.setContent(this.html);
            infowindow.open(map, this);
        });
    }
}