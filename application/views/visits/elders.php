<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
    <head>
        <?php include_once(APPPATH . 'views/includes/head.php'); ?>
    </head>
    <body>
        <div id="container">
            <div id="map">
                <div id="map-inner">
                </div>
            </div>
            <div id="con">
                <ul>
                    <li>
                        <div class="qrcod">
                            <img src="<?php print $this->config->base_url(); ?>assets/img/qrcode/<?php print $for->for_id; ?>.png" alt="NO QR"/>
                        </div>
                        <div class="cinfo">
                            <div class="route">
                                <?php print (isset($for->for_route)) ? $for->for_route : "Unknown"; ?>
                            </div>
                            <div class="snumb">
                                <?php print (isset($for->for_street_number)) ? $for->for_street_number : "Unknown"; ?>
                            </div>
                            <div class="sublo">
                                <?php print (isset($for->for_sublocality)) ? $for->for_sublocality : "Unknown"; ?>
                            </div>
                            <div class="namec">
                                <?php print (isset($for->name)) ? $row->name : "Unknown"; ?>
                            </div>
                            <div class="compl">
                                <?php print (isset($for->for_complement)) ? $for->for_complement : "Unknown"; ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </body>
</html>