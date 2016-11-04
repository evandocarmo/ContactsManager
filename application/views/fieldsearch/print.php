<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="content-type" content="text/html; charset=<?php print config_item('charset'); ?>" />
        <title>Field Search List</title>
        <style type="text/css"> @import url(https://fonts.googleapis.com/css?family=Noticia+Text:400,400italic,700,700italic); @import url("<?php print $this->config->base_url(); ?>browser/css/fieldservice.css"); </style>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
            jQuery(function ()
            {
                var stops = [
<?php foreach ($printer as $id => $row): ?>
                        {"Geometry": {"Latitude":<?php print explode(',', $row->for_location)[0]; ?>, "Longitude":<?php print explode(',', $row->for_location)[1]; ?>}},
<?php endforeach; ?>
                ];
                var map = new window.google.maps.Map(document.getElementById("map-inner"));
                var directionsDisplay = new window.google.maps.DirectionsRenderer({
                    suppressMarkers: true
                });
                var directionsService = new window.google.maps.DirectionsService();
                Tour_startUp(stops);
                window.tour.loadMap(map, directionsDisplay);
                window.tour.fitBounds(map);
                if (stops.length > 1)
                    window.tour.calcRoute(directionsService, directionsDisplay);
            });
            function Tour_startUp(stops)
            {
                if (!window.tour)
                    window.tour = {
                        updateStops: function (newStops)
                        {
                            stops = newStops;
                        },
                        loadMap: function (map, directionsDisplay)
                        {
                            var myOptions = {
                                zoom: 13,
                                center: new window.google.maps.LatLng(51.507937, -0.076188), // default to London
                                mapTypeId: window.google.maps.MapTypeId.ROADMAP,
                                disableDefaultUI: true,
                                styles: [{"featureType": "water", "elementType": "geometry.fill", "stylers": [{"color": "#d3d3d3"}]}, {"featureType": "transit", "stylers": [{"color": "#808080"}, {"visibility": "off"}]}, {"featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{"visibility": "on"}, {"color": "#b3b3b3"}]}, {"featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{"color": "#ffffff"}]}, {"featureType": "road.local", "elementType": "geometry.fill", "stylers": [{"visibility": "on"}, {"color": "#ffffff"}, {"weight": 1.8}]}, {"featureType": "road.local", "elementType": "geometry.stroke", "stylers": [{"color": "#d7d7d7"}]}, {"featureType": "poi", "elementType": "geometry.fill", "stylers": [{"visibility": "on"}, {"color": "#ebebeb"}]}, {"featureType": "administrative", "elementType": "geometry", "stylers": [{"color": "#a7a7a7"}]}, {"featureType": "road.arterial", "elementType": "geometry.fill", "stylers": [{"color": "#ffffff"}]}, {"featureType": "road.arterial", "elementType": "geometry.fill", "stylers": [{"color": "#ffffff"}]}, {"featureType": "landscape", "elementType": "geometry.fill", "stylers": [{"visibility": "on"}, {"color": "#efefef"}]}, {"featureType": "road", "elementType": "labels.text.fill", "stylers": [{"color": "#696969"}]}, {"featureType": "administrative", "elementType": "labels.text.fill", "stylers": [{"visibility": "on"}, {"color": "#737373"}]}, {"featureType": "poi", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {"featureType": "poi", "elementType": "labels", "stylers": [{"visibility": "off"}]}, {"featureType": "road.arterial", "elementType": "geometry.stroke", "stylers": [{"color": "#d6d6d6"}]}, {"featureType": "road", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {}, {"featureType": "poi", "elementType": "geometry.fill", "stylers": [{"color": "#dadada"}]}]
                            };
                            map.setOptions(myOptions);
                            directionsDisplay.setMap(map);
                        },
                        fitBounds: function (map)
                        {
                            var bounds = new window.google.maps.LatLngBounds();
                            jQuery.each(stops, function (key, val)
                            {
                                var myLatlng = new window.google.maps.LatLng(val.Geometry.Latitude, val.Geometry.Longitude);
                                bounds.extend(myLatlng);
                            });
                            map.fitBounds(bounds);
                        },
                        calcRoute: function (directionsService, directionsDisplay)
                        {
                            var batches = [];
                            var itemsPerBatch = 10;
                            var itemsCounter = 0;
                            var wayptsExist = stops.length > 0;
                            while (wayptsExist)
                            {
                                var subBatch = [];
                                var subitemsCounter = 0;
                                for (var j = itemsCounter; j < stops.length; j++)
                                {
                                    subitemsCounter++;
                                    subBatch.push({
                                        location: new window.google.maps.LatLng(stops[j].Geometry.Latitude, stops[j].Geometry.Longitude),
                                        stopover: true
                                    });
                                    if (subitemsCounter == itemsPerBatch)
                                        break;
                                }
                                itemsCounter += subitemsCounter;
                                batches.push(subBatch);
                                wayptsExist = itemsCounter < stops.length;
                                itemsCounter--;
                            }
                            var combinedResults;
                            var unsortedResults = [{}];
                            var directionsResultsReturned = 0;
                            for (var k = 0; k < batches.length; k++)
                            {
                                var lastIndex = batches[k].length - 1;
                                var start = batches[k][0].location;
                                var end = batches[k][lastIndex].location;
                                var waypts = [];
                                waypts = batches[k];
                                waypts.splice(0, 1);
                                waypts.splice(waypts.length - 1, 1);
                                var request = {
                                    origin: start,
                                    destination: end,
                                    waypoints: waypts,
                                    travelMode: window.google.maps.TravelMode.WALKING
                                };
                                (function (kk)
                                {
                                    directionsService.route(request, function (result, status)
                                    {
                                        if (status == window.google.maps.DirectionsStatus.OK)
                                        {
                                            var unsortedResult = {
                                                order: kk,
                                                result: result
                                            };
                                            unsortedResults.push(unsortedResult);
                                            directionsResultsReturned++;
                                            if (directionsResultsReturned == batches.length)
                                            {
                                                unsortedResults.sort(function (a, b)
                                                {
                                                    return parseFloat(a.order) - parseFloat(b.order);
                                                });
                                                var count = 0;
                                                for (var key in unsortedResults)
                                                {
                                                    if (unsortedResults[key].result != null)
                                                    {
                                                        if (unsortedResults.hasOwnProperty(key))
                                                        {
                                                            if (count == 0)
                                                                combinedResults = unsortedResults[key].result;
                                                            else
                                                            {
                                                                combinedResults.routes[0].legs = combinedResults.routes[0].legs.concat(unsortedResults[key].result.routes[0].legs);
                                                                combinedResults.routes[0].overview_path = combinedResults.routes[0].overview_path.concat(unsortedResults[key].result.routes[0].overview_path);
                                                                combinedResults.routes[0].bounds = combinedResults.routes[0].bounds.extend(unsortedResults[key].result.routes[0].bounds.getNorthEast());
                                                                combinedResults.routes[0].bounds = combinedResults.routes[0].bounds.extend(unsortedResults[key].result.routes[0].bounds.getSouthWest());
                                                            }
                                                            count++;
                                                        }
                                                    }
                                                }
                                                directionsDisplay.setDirections(combinedResults);
                                                var legs = combinedResults.routes[0].legs;
                                                for (var i = 0; i < legs.length; i++)
                                                {
                                                    var markerletter = "A".charCodeAt(0);
                                                    markerletter += i;
                                                    markerletter = String.fromCharCode(markerletter);
                                                    createMarker(directionsDisplay.getMap(), legs[i].start_location, "marker" + i, "some text for marker " + i + "<br>" + legs[i].start_address, i + 1);
                                                }
                                                var i = legs.length;
                                                var markerletter = "A".charCodeAt(0);
                                                markerletter += i;
                                                markerletter = String.fromCharCode(markerletter);
                                                createMarker(directionsDisplay.getMap(), legs[legs.length - 1].end_location, "marker" + i, "some text for the " + i + "marker<br>" + legs[legs.length - 1].end_address, i + 1);
                                            }
                                        }
                                    });
                                })(k);
                            }
                        }
                    };
            }
            var infowindow = new google.maps.InfoWindow({
                size: new google.maps.Size(150, 50)
            });
            var icons = new Array();
            icons["red"] = new google.maps.MarkerImage("mapIcons/marker_red.png",
                    new google.maps.Size(20, 34),
                    new google.maps.Point(0, 0),
                    new google.maps.Point(9, 34));
            function getMarkerImage(iconStr)
            {
                if ((typeof (iconStr) == "undefined") || (iconStr == null))
                {
                    iconStr = "red";
                }
                if (!icons[iconStr])
                {
                    icons[iconStr] = new google.maps.MarkerImage("https://raw.githubusercontent.com/Concept211/Google-Maps-Markers/master/images/marker_black" + iconStr + ".png",
                            new google.maps.Size(22, 40),
                            new google.maps.Point(0, 0));
                }
                return icons[iconStr];
            }
            var iconImage = new google.maps.MarkerImage('mapIcons/marker_red.png',
                    new google.maps.Size(20, 34),
                    new google.maps.Point(0, 0),
                    new google.maps.Point(9, 34));
            var iconShadow = new google.maps.MarkerImage('http://www.google.com/mapfiles/shadow50.png',
                    new google.maps.Size(37, 34),
                    new google.maps.Point(0, 0),
                    new google.maps.Point(9, 34));
            var iconShape = {
                coord: [9, 0, 6, 1, 4, 2, 2, 4, 0, 8, 0, 12, 1, 14, 2, 16, 5, 19, 7, 23, 8, 26, 9, 30, 9, 34, 11, 34, 11, 30, 12, 26, 13, 24, 14, 21, 16, 18, 18, 16, 20, 12, 20, 8, 18, 4, 16, 2, 15, 1, 13, 0],
                type: 'poly'
            };
            function createMarker(map, latlng, label, html, color)
            {
                var contentString = '<b>' + label + '</b><br>' + html;
                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    shadow: iconShadow,
                    icon: getMarkerImage(color),
                    shape: iconShape,
                    title: label,
                    zIndex: Math.round(latlng.lat() * -100000) << 5
                });
                marker.myname = label;
                google.maps.event.addListener(marker, 'click', function ()
                {
                    infowindow.setContent(contentString);
                    infowindow.open(map, marker);
                });
                return marker;
            }
        </script>
    </head>
    <body>
        <div id="container">
            <div id="map">
                <div id="map-inner">
                </div>
            </div>
            <div id="con">
                <ul>
                    <?php foreach ($printer as $id => $row): ?>
                        <li>
                            <div class="qrcod">
                                <img src="<?php print $this->config->base_url(); ?>assets/img/qrcode/<?php print $row->fie_foreigner; ?>.png" alt="NO QR"/>
                            </div>
                            <div class="cinfo">
                                <div class="route">
                                    <?php print (isset($row->for_route)) ? $row->for_route : "Unknown"; ?>
                                </div>
                                <div class="snumb">
                                    <?php print (isset($row->for_street_number)) ? $row->for_street_number : "Unknown"; ?>
                                </div>
                                <div class="sublo">
                                    <?php print (isset($row->for_sublocality)) ? $row->for_sublocality : "Unknown"; ?>
                                </div>
                                <div class="namec">
                                    <?php print (isset($row->name)) ? $row->name : "Unknown"; ?>
                                </div>
                                <div class="compl">
                                    <?php print (isset($row->for_complement)) ? $row->for_complement : "Unknown"; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </body>
</html>