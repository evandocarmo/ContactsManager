<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
    <head>
        <?php include_once(APPPATH . 'views/includes/head.php'); ?>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript"> google.load("visualization", "1", {packages: ["corechart"]}); google.setOnLoadCallback(function () { var data = google.visualization.arrayToDataTable([['Task', 'Hours per Day']<?php foreach ($stats as $key => $value): ?>, ['<?php print $key; ?>', <?php print $value; ?>]<?php endforeach; ?>]); var options = { 'legend': 'none', 'tooltip': {trigger: 'none'}, 'height': 150, 'pieSliceText': 'none', 'slices': { 0: {'color': 'e66665'}, 1: {'color': '4d9379'}, 2: {'color': '82b5e0'}, 3: {'color': 'ffd602'} } }; var chart = new google.visualization.PieChart(document.getElementById('waiting-piechart')); chart.draw(data, options); }); google.setOnLoadCallback(function () { var data = google.visualization.arrayToDataTable([['Date', 'Visits']<?php foreach ($visits as $key => $value): ?>, ['<?php print date('M', mktime(0, 0, 0, $value->MONTH, 10)); ?>', <?php print $value->COUNT; ?>]<?php endforeach; ?>]); var options = { curveType: 'function', legend: {position: 'none'} }; var chart = new google.visualization.LineChart(document.getElementById('visits-linechart')); chart.draw(data, options); }); google.setOnLoadCallback(function () { var data = google.visualization.arrayToDataTable([['Date', 'Insertions', 'Updates']<?php foreach ($update as $key => $value): ?>, ['<?php print str_replace("/2015", "", $key); ?>', <?php print (isset($value->updates)) ? $value->updates : 0; ?>, <?php print (isset($value->inserts)) ? $value->inserts : 0; ?>]<?php endforeach; ?>]); var options = { 'legend': 'none', vAxis: { minValue: 0 } }; var chart = new google.visualization.AreaChart(document.getElementById('updates-areachart')); chart.draw(data, options); });</script>
    </head>
    <body>
        <div class="navigation">
            <?php include_once(APPPATH . 'views/includes/navigation.php'); ?>
        </div>
        <div class="container">
            <div class="container-inner">
                <div id="dashboard">
                    <dl>
                        <dt>
                            <div id="system-updates-title"> System Updates </div>
                            <div id="system-updates-form">
                                <form action="/dashboard" method="POST">
                                    <select name="sync" onchange="this.form.submit()">
                                        <option value="0" <?php print $this->input->post("sync") == 0 ? "selected" : ""; ?>>synchronous</option>
                                        <option value="1" <?php print $this->input->post("sync") == 1 ? "selected" : ""; ?>>asynchronous</option>
                                    </select>
                                </form>
                            </div>
                        </dt>
                        <dd id="updates">
                            <div id="updates-areachart">&nbsp;</div>
                        </dd>
                    </dl>
                    <dl>
                        <dt>Visists</dt>
                        <dd id="updates">
                            <div id="visits-linechart">&nbsp;</div>
                        </dd>
                    </dl>
                    <dl>
                        <dt>Waiting Contacts</dt>
                        <dd id="waiting">
                            <div id="waiting-piechart">
                            </div>
                            <div id="waiting-numbers">
                                <ul>
                                    <?php foreach ($stats as $key => $value): ?>
                                        <li class="<?php print $key; ?>">
                                            <?php print $value; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div id="waiting-info">
                                <ul>
                                    <li class="red">
                                        <span>Contacts who were once assigned but not visited.</span>
                                    </li>
                                    <li class="green">
                                        <span>Contacts made, but not confirmed or unconfirmed.</span>
                                    </li>
                                    <li class="blue">
                                        <span>Re-assigned contacts waiting to be done.</span>
                                    </li>
                                    <li class="yellow">
                                        <span>Previously assigned contacts waiting to be done. </span>
                                    </li>
                                </ul>
                            </div>
                            <div id="waiting-unlisted">
                                <div class="number">
                                    <?php print count($unlisted); ?>
                                </div>
                                <div class="description">Unlisted</div>
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/footer.php'); ?>
    </body>
</html>