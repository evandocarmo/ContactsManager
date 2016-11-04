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
                <form id="search" action="<?php print $this->config->base_url(); ?>foreigners/contacts" method="get">
                    <table>
                        <colgroup>
                            <col span="1" style="width: 5%;" />
                            <col span="1" style="width: 89%;" />
                            <col span="1" style="width: 6%;" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Data</th>
                                <th>Excel</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($backup)): ?>
                                <tr>
                                    <td colspan="7">Nothing returned</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($backup as $key => $row): ?>
                                    <tr>
                                        <td>
                                            <?php print $key; ?>
                                        </td>
                                        <td>
                                            <?php print $row; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <ul>
                                                    <li>
                                                        <a href="<?php print $this->config->base_url(); ?>assets/backup/excel/<?php print md5($key); ?>.xlsx" class="btn-download">
                                                            <i class="icon-download">
                                                            </i>
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
                    <div id="pagination">
                        <div id="pagination-navigation">
                            <?php print $links; ?>
                        </div>
                        <div id="pagination-description"> Total of <?php print $total; ?> results. </div>
                    </div>
                </form>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/piwik.php'); ?>
    </body>
</html>