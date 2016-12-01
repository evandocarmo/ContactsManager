<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <style type="text/css"> @import url("<?php print $this->config->base_url(); ?>browser/css/mobile.css"); /* #heatmap-area { height: 400px; float: left; width: 100%; } */ </style>
    </head>
    <body>
        <div class="container mobile">
            <ul id="mobile">
                <li>
                    <div class="title">Contact Information</div>
                    <div class="content profile-data">
                        <h3>
                            <?php print $foreigner->for_name; ?>
                        </h3>
                        <dl>
                            <dt>Country:</dt>
                            <dd>
                                <i class="icon-flag">
                                </i>
                                <?php print isset($country->name) ? $country->name : "Undefined"; ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>Address:</dt>
                            <dd>
                                <i class="icon-home">
                                </i>
                                <?php print $foreigner->for_route; ?>, <?php print $foreigner->for_street_number; ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>Neighborhood:</dt>
                            <dd>
                                <i class="icon-home">
                                </i>
                                <?php print $foreigner->for_sublocality; ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>Complement:</dt>
                            <dd>
                                <i class="icon-home">
                                </i>
                                <?php print $foreigner->for_complement; ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>Phone:</dt>
                            <dd>
                                <i class="icon-headphones">
                                </i>
                                <?php print $foreigner->for_telephone; ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>Status:</dt>
                            <dd>
                                <i class="icon-warning-sign">
                                </i>
                                <?php print $status->sta_name; ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>Region:</dt>
                            <dd>
                                <i class="icon-resize-small">
                                </i>
                                <?php print $category->cat_name; ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>City:</dt>
                            <dd>
                                <i class="icon-home">
                                </i>
                                <?php print $foreigner->for_locality; ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>Coordinates:</dt>
                            <dd>
                                <i class="icon-map-marker">
                                </i>
                                <?php print $foreigner->for_location; ?>
                            </dd>
                        </dl>
                    </div>
                </li>
                <li>
                    <div class="title">Visits</div>
                    <div class="content profile-visit">
                        <?php if (empty($visits)): ?>
                            <div class="alert alert-info">There is no record of visits.</div>
                        <?php else: ?>
                            <h3>Total of <?php print count($visits); ?> identified visits</h3>
                            <?php foreach ($visits as $rows): ?>
                                <dl>
                                    <dt>
                                        <?php print date("d/m/Y", strtotime($rows->vis_date)); ?> (<?php print $rows->vis_publisher; ?>)</dt>
                                    <dd>
                                        <?php print nl2br($rows->vis_description); ?>
                                    </dd>
                                </dl>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </li>
                <?php /* <li>
                  <div class="title">Maps</div>
                  <div class="content" id="heatmap-area">&nbsp;</div>
                  </li> */ ?>
            </ul>
        </div>
        <?php include_once(APPPATH . 'views/includes/footer.php'); ?>
    </body>
</html>