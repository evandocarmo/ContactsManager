<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
    <head>
        <?php include_once(APPPATH . 'views/includes/head.php'); ?>
    </head>
    <body>
        <div class="navigation">
            <?php include_once(APPPATH . 'views/includes/navigation.php'); ?>
        </div>
        <div class="container">
            <div class="container-inner">
                <div id="fieldservice-browse">
                    <table>
                        <colgroup>
                            <col span="1" style="width: 50px;" />
                            <col span="1" style="width: 180px;" />
                            <col span="1" style="width: 130px;" />
                            <col span="1" style="width: 210px;" />
                            <col span="1" style="width: 75px;" />
                            <col span="1" style="width: 75px;" />
                            <col span="1" style="width: 50px;" />
                            <col span="1" style="width: 130px;" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th>
                                </th>
                                <th>Firegner Name</th>
                                <th>Publisher Name</th>
                                <th>Description</th>
                                <th>Assg. Date</th>
                                <th>Alter Date</th>
                                <th>Attempts</th>
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
                                        <td style="background-color: <?php print $row['color']; ?>;">
                                        </td>
                                        <td>
                                            <?php print $row['for_name']; ?>
                                        </td>
                                        <td>
                                            <?php print $row['pus_name']; ?>
                                        </td>
                                        <td>
                                            <?php print (!empty($row['pet_desc'])) ? $row['pet_desc'] : "Waiting..."; ?>
                                        </td>
                                        <td>
                                            <?php print date('d/m/Y', strtotime($row['pet_date'])); ?>
                                        </td>
                                        <td>
                                            <?php print (!empty($row['log_date'])) ? date('d/m/Y', strtotime($row['log_date'])) : "Not Yet"; ?>
                                        </td>
                                        <td>
                                            <?php print $row['the_count']; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <ul>
                                                    <?php if ($row['color'] == '#e66665' && !empty($row['pet_desc'])): ?>
                                                        <li>
                                                            <a class="btn-success" style="background-position: -209px -19px; margin-right: 5px;" href="/personal/phonerenew/<?php print $row['pet_iden']; ?>">
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <a class="btn-success" href="/foreigners/contact/<?php print $row['for_id']; ?>">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="btn-danger" style="margin-left: 5px;" href="/profile/contact/<?php print $row['for_id']; ?>">
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
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
        <?php include_once(APPPATH . 'views/includes/piwik.php'); ?>
    </body>
</html>