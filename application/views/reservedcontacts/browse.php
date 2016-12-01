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
                <div id="reserved-unlisted">
                    <div id="reserved-unlisted-title">Unlisted Reserved Contacts</div>
                    <div id="reserved-unlisted-lists">
                        <?php if (count($unlisted) > 0): ?>
                            <ul>
                                <?php foreach ($unlisted as $value): ?>
                                    <li>
                                        <a href="/profile/contact/<?php print $value->for_id; ?>">
                                            <?php print $value->for_id; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>All reserved contats are already assigned.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div id="reserved-table">
                    <table>
                        <colgroup>
                            <col span="1" style="width: 50px;" />
                            <col span="1" style="width: 250px;" />
                            <col span="1" style="width: 310px;" />
                            <col span="1" style="width: 100px;" />
                            <col span="1" style="width: 100px;" />
                            <col span="1" style="width: 90px;" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Publisher</th>
                                <th>Foreigner</th>
                                <th>Category</th>
                                <th>Last Check</th>
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
                                        <td class="<?php print $row->color; ?>">
                                        </td>
                                        <td>
                                            <?php print $row->pub_name; ?>
                                        </td>
                                        <td>
                                            <?php print $row->for_name; ?>
                                        </td>
                                        <td>
                                            <?php print $row->cat_name; ?>
                                        </td>
                                        <td>
                                            <?php print $row->check_date; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <ul>
                                                    <li>
                                                        <a class="btn-info" href="<?php print site_url("reservedcontacts/check/{$row->for_id}"); ?>" style="background-position: -281px 4px;">
                                                        <!--<i class="icon-print">
                                                        </i>Print-->
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="btn-danger" href="<?php print site_url("profile/contact/{$row->for_id}"); ?>">
                                                        <!--<i class="icon-user">
                                                        </i>User-->
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
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/footer.php'); ?>
    </body>
</html>