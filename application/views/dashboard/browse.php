<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
    <head>
        <?php include_once(APPPATH . 'views/includes/head.php'); ?>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            var visitsChart = [['Date', 'Visits'], <?php foreach ($visits as $key => $value): ?>['<?php print date('M', mktime(0, 0, 0, $value->MONTH, 10)); ?>', <?php print $value->COUNT; ?>], <?php endforeach; ?>];
            var systemUpdatesChart = [['Task', 'Hours per Day'],<?php foreach ($stats as $key => $value): ?>['<?php print $key; ?>', <?php print $value['total']; ?>], <?php endforeach; ?>];
            var waitingContactsChart = [['Date', 'Insertions', 'Updates'], <?php foreach ($update as $key => $value): ?>['<?php print str_replace("/2015", "", $key); ?>', <?php print (isset($value->updates)) ? $value->updates : 0; ?>, <?php print (isset($value->inserts)) ? $value->inserts : 0; ?>], <?php endforeach; ?>];
        </script>
    </head>
    <body>
        <div class="navigation">
            <?php include_once(APPPATH . 'views/includes/navigation.php'); ?>
        </div>
        <div class="container">
            <div class="container-inner">
                <div id="dashboard">
                    <dl>
                        <dt>System Updates</dt>
                        <dd class="updates">
                            <div id="updates-areachart-filter">
                                <form action="/dashboard" method="post">
                                    <fieldset>
                                        <legend>Login</legend>
                                        <dl>
                                            <dt>
                                                <label for="sync">Sync Mode</label>
                                            </dt>
                                            <dd>
                                                <select id="sync" name="sync" onchange="this.form.submit()">
                                                    <option value="0" <?php print $this->input->post("sync") == 0 ? "selected=\"selected\"" : ""; ?>>synchronous</option>
                                                    <option value="1" <?php print $this->input->post("sync") == 1 ? "selected=\"selected\"" : ""; ?>>asynchronous</option>
                                                </select>
                                            </dd>
                                        </dl>
                                    </fieldset>
                                </form>
                            </div>
                            <div id="updates-areachart">&nbsp;</div>
                        </dd>
                    </dl>
                    <dl>
                        <dt>Visists</dt>
                        <dd class="updates">
                            <div id="visits-linechart">&nbsp;</div>
                        </dd>
                    </dl>
                    <dl id="waiting-contacts">
                        <dt>Waiting Contacts</dt>
                        <dd id="waiting">
                            <div id="waiting-piechart">&nbsp;</div>
                            <div id="waiting-info">
                                <ul>
                                    <?php foreach ($stats as $key => $value): ?>
                                        <li class="<?php print $key; ?>"><?php print $value['total']; ?> <?php print $value['label']; ?></li>
                                    <?php endforeach; ?>
                                    <li><?php print count($unlisted); ?> Unlisted, need to set status and/or category.</li>
                                </ul>
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?php print $this->config->base_url(); ?>browser/js/deashboard.js"></script>
        <?php include_once(APPPATH . 'views/includes/footer.php'); ?>
    </body>
</html>