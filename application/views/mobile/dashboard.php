<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">    <head>        <?php include_once(APPPATH . 'views/mobile/includes/head.php'); ?>    </head>    <body>        <div id="menu">            <?php include_once(APPPATH . 'views/mobile/includes/navigation.php'); ?>        </div>        <div id="panl">            <div class="container-tpbar">                <a href="#" class="toggle">OpenSideBar</a>            </div>            <div class="container-inner">                <div id="dashboard">                    <h1>Welcome, <strong>                            <?php print $info->pus_name; ?>                        </strong>.</h1>                    <a href="<?php print site_url("mobile/add"); ?>">Confirm contacts via Phone Call</a>                    <?php if (isset($fore) && !empty($fore)): ?>                        <table>                            <colgroup>                                <col span="1" style="width: 100px;" />                                <col span="1" style="width: 300px;" />                            </colgroup>                            <thead>                                <tr>                                    <th>Date</th>                                    <th>Name</th>                                </tr>                            </thead>                            <tbody>                                <?php foreach ($fore as $value): ?>                                    <tr>                                        <td>                                            <?php print date('d/m/Y', strtotime($value->pet_date)); ?>                                        </td>                                        <td>                                            <?php print $value->for_name; ?>                                        </td>                                    </tr>                                <?php endforeach; ?>                            </tbody>                        </table>                    <?php endif; ?>                </div>            </div>        </div>        <?php include_once(APPPATH . 'views/mobile/includes/slideout.php'); ?>        <?php include_once(APPPATH . 'views/includes/footer.php'); ?>    </body></html>