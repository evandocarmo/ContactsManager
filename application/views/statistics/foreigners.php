<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
    <head>
        <?php include_once(APPPATH . 'views/includes/head.php'); ?>
        <script type="text/javascript">
            var sites = [
            <?php foreach ($table as $key => $value): ?>
                <?php if ($value->for_location <> 'Uninformed' && !empty(trim($value->for_location))): ?>
                    <?php $location = explode(",", $value->for_location); ?>
                    [
                        '<?php print $value->for_name; ?>',
                         <?php print $location[0]; ?>,
                         <?php print $location[1]; ?>,
                         <?php print $value->for_id; ?>,
                        '<div class="foreigner-map">\
                            <div class="for_name"><?php print $value->for_name; ?></div>\
                            <div class="for_rout"><?php print $value->for_route; ?>, <?php print $value->for_street_number; ?></div>\
                            <div class="for_subl"><?php print $value->for_sublocality; ?></div>\
                            <div class="for_comp"><?php print $value->for_complement; ?></div>\
                            <div class="for_tele"><?php print $value->for_telephone; ?></div>\
                            <div class="for_acto">\
                                <a class="ico-view" href="/profile/contact/<?php print $value->for_id; ?>">View</a>\
                                <a class="ico-edit" href="/foreigners/contact/<?php print $value->for_id; ?>">Edit</a>\
                                <a class="ico-prit" href="/foreigners/printer/<?php print $value->for_id; ?>">Print</a>\
                            </div>\
                            <?php if ($value->sta_id == '1'): ?>
                                <div class="statistics-fieldservice">\
                                    <form method="post" action="<?php print site_url("profile/fieldservice/{$value->for_id}/01"); ?>">\
                                        <fieldset>\
                                            <dl>\
                                                <dt><label for="fif_fieldservice">Field Service Information</label></dt>\
                                                <dd>\
                                                    <select name="fif_fieldservice">\
                                                        <option value="#">Territory List.</option>\
                                                        <?php foreach ($fieldservice as $row): ?>\
                                                            <option <?php print isset($value->for_fieldservice) && $value->for_fieldservice == $row->fis_iden ? "selected" : ""; ?>  value="<?php print $row->fis_iden; ?>"><?php print $row->fis_name; ?></option>\
                                                        <?php endforeach; ?>\
                                                    </select>\
                                                </dd>\
                                            </dl>\
                                        </fieldset>\
                                        <div class="form-actions">\
                                            <input type="submit" value="Submit" class="btn btn-primary" />\
                                        </div>\
                                    </form>\
                                </div>\
                            <?php endif; ?>
                         </div>'
                    ],
                <?php endif; ?>
            <?php endforeach; ?>
            ];
            
            var myOptions = {
                zoom: 14,
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
            
            <?php if(!is_null($fif_foreigner) && !empty($fif_foreigner)): ?>
            var fif_foreigner = <?php print $fif_foreigner; ?>;
            <?php endif; ?>
        </script>
        <script type="text/javascript" src="<?php print $this->config->base_url(); ?>browser/js/statistics-foreigners.js"></script>
        <style type="text/css"> #heatmap-area { height: 400px; float: left; width: 100%; } #filter-area { float: left; width: 100%; margin-bottom: 30px; } </style>
    </head>
    <body>
        <div class="navigation">
            <?php include_once(APPPATH . 'views/includes/navigation.php'); ?>
        </div>
        <div class="container">
            <div class="container-inner">
                <div id="filter-area">
                    <?php include_once(APPPATH . 'views/statistics/filter.php'); ?>
                </div>
                <div id="heatmap-area">
                </div>
                <button id="enter-full-screen">Enter full Screen</button>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/footer.php'); ?>
    </body>
</html>