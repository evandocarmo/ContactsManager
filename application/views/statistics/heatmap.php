<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
    <head>
        <?php include_once(APPPATH . 'views/includes/head.php'); ?>
        <script type="text/javascript">
            window.onload = function ()
            {
                var myOptions = {
                    zoom: 11,
                    center: new google.maps.LatLng(<?php print $user["loc_coord"]; ?>),
                    // mapTypeId: google.maps.MapTypeId.SATELLITE,
                    disableDefaultUI: false,
                    scrollwheel: true,
                    draggable: true,
                    navigationControl: true,
                    mapTypeControl: false,
                    scaleControl: true,
                    disableDoubleClickZoom: false
                };
                var map = new google.maps.Map(document.getElementById("heatmapArea"), myOptions);
                var heatmapData = [
<?php foreach ($table as $key => $value): ?>
    <?php if ($value->for_location <> 'Uninformed' && !empty(trim($value->for_location))): ?>
        <?php
        $location = explode(",", $value->for_location);
        print "new google.maps.LatLng({$location[0]}, {$location[1]}),\n";
        ?>
    <?php endif; ?>
<?php endforeach; ?>
                ];
                        var heatmap = new google.maps.visualization.HeatmapLayer({
                            data: heatmapData,
                            radius: 20,
                            scaleRadius: true,
                            opacity: 1
                        });
                heatmap.setMap(map);
            };
        </script>
        <style type="text/css">
            #heatmapArea { height: 400px; width: 100%; }
        </style>
    </head>
    <body>
        <div class="navigation">
            <?php include_once(APPPATH . 'views/includes/navigation.php'); ?>
        </div>
        <div class="container">
            <div class="container-inner">
                <div id="heatmapArea"></div>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/footer.php'); ?>
    </body>
</html>