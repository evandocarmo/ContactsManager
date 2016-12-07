<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
    <head>
        <?php include_once(APPPATH . 'views/includes/head.php'); ?>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("visualization", "1", {packages: ["corechart"]});
            google.setOnLoadCallback(function () {
                var table = [['Task', 'Hours per Day']];
<?php foreach ($stats as $key => $value): ?>
                    table.push(['<?php print $key; ?>', <?php print $value; ?>]);
<?php endforeach; ?>
                var data = google.visualization.arrayToDataTable(table);
                var options = {
                    legend: 'none',
                    tooltip: {
                        trigger: 'none'
                    },
                    slices: {
                        0: { color: 'e66665' },
                        1: { color: '4d9379' },
                        2: { color: '82b5e0' },
                        3: { color: 'ffd602' }
                    }
                };
                var chart = new google.visualization.PieChart(document.getElementById('waiting-info-piechart'));
                chart.draw(data, options);
            });
        </script>
    </head>
    <body>
        <div class="navigation">
            <?php include_once(APPPATH . 'views/includes/navigation.php'); ?>
        </div>
        <div class="container">
            <div class="container-inner">
                <div id="waiting">
                    <div id="waiting-info-piechart">&nbsp;</div>
                    <div id="waiting-info">
                        <ul>
                            <li class="red">Contacts who were once assigned but not visited.</li>
                            <li class="green">Contacts made, but not confirmed or unconfirmed.</li>
                            <li class="blue">Re-assigned contacts waiting to be done.</li>
                            <li class="yellow">Previously assigned contacts waiting to be done.</li>
                        </ul>
                    </div>
                </div>
                <div id="waiting-unlisted">
                    <div id="waiting-unlisted-title">Unlisted Waiting Contacts</div>
                    <div id="waiting-unlisted-lists">
                        <?php if (count($unlisted) > 0): ?>
                            <ul>
                                <?php foreach ($unlisted as $value): ?>
                                    <li>
                                        <a href="/profile/contact/<?php print $value; ?>">
                                            <?php print $value; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>All waiting contats are already in the scheduled lists.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div id="table">
                    <table>
                        <colgroup>
                            <col span="1" style="width: 40px;" />
                            <col span="1" style="width: 90px;" />
                            <col span="1" style="width: 50px;" />
                            <col span="1" style="width: 140px;" />
                            <col span="1" style="width: 540px;" />
                            <col span="1" style="width: 40px;" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Group</th>
                                <th>Conductor</th>
                                <th>Cards</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($browse)): ?>
                                <tr>
                                    <td colspan="5">Nothing returned</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($browse as $key => $row): ?>
                                    <tr>
                                        <td>
                                            <?php print $row->fie_id; ?>
                                        </td>
                                        <td>
                                            <?php print date('d/m/Y', strtotime($row->fie_date)); ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php print $row->fie_group; ?>
                                        </td>
                                        <td>
                                            <?php print $row->fie_conductors; ?>
                                        </td>
                                        <td>
                                            <ul class="fieldsearch-visits">
                                                <?php foreach ($row->fie_foreigners_ as $key => $value): ?>
                                                    <li class="<?php print $value[1]; ?>">
                                                        <a href="<?php print site_url("profile/contact/{$value[0]}"); ?>">
                                                            <?php print $value[0]; ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <?php if (new DateTime() < new DateTime($row->fie_date)): ?>
                                                <div class="btn-group">
                                                    <ul>
                                                        <li>
                                                            <a class="btn-info" target="_blank" href="<?php print $this->config->base_url(); ?>fieldsearch/printer/<?php print $row->fie_timestamp; ?>/<?php print $row->fie_group; ?>">&nbsp;</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div id="pagination">
                    <div id="pagination-navigation">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                    <div id="pagination-description">
                        <p>Total of <?php print $total; ?> results.</p>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/footer.php'); ?>
    </body>
</html>