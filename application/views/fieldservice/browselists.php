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
                <div id="table">
                    <table>
                        <colgroup>
                            <col span="1" style="width: 65px;" />
                            <col span="1" style="width: 100px;" />
                            <col span="1" style="width: 200px;" />
                            <col span="1" style="width: 485px;" />
                            <col span="1" style="width: 50px;" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Conductor</th>
                                <th>Contacts</th>
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
                                            <?php print $row->fia_iden; ?>
                                        </td>
                                        <td>
                                            <?php print date('d/m/Y', strtotime($row->fia_date)); ?>
                                        </td>
                                        <td>
                                            <?php print $row->fia_cond; ?>
                                        </td>
                                        <td>
                                            <?php if (count($row->visits) > 0): ?>
                                                <ul class="fieldsearch-visits">
                                                    <?php foreach ($row->visits as $key_ => $row_): ?>
                                                        <li class="<?php print $row_['col_']; ?>">
                                                            <a href="<?php print $this->config->base_url(); ?>profile/contact/<?php print $key_; ?>">
                                                                <?php print $key_; ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p>No foreigers on this list.</p>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (new DateTime($row->fia_date) >= new DateTime()): ?>
                                                <div class="btn-group">
                                                    <ul>
                                                        <li>
                                                            <a target="_blank" class="btn-info" href="<?php print $this->config->base_url(); ?>fieldservice/printer/<?php print $row->fia_iden; ?>">
                                                                &nbsp;
                                                            </a>
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