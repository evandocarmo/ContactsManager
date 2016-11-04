<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
    <head>
        <?php include_once(APPPATH . 'views/includes/head.php'); ?>
    </head>
    <body class="settings">
        <div class="navigation">
            <?php include_once(APPPATH . 'views/includes/navigation.php'); ?>
        </div>
        <div class="container">
            <div class="container-inner">
                <table>
                    <colgroup>
                        <col span="1" style="width: 80px;" />
                        <col span="1" style="width: 80px;" />
                        <col span="1" style="width: 140px;" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Name</th>
                            <th>Mail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($publishers as $key => $row): ?>
                            <tr>
                                <td style="background-color: #<?php print ($row->pus_stts == 0) ? "e66665" : "4d9379"; ?>;">
                                </td>
                                <td>
                                    <?php print strtok($row->pus_name, " "); ?>
                                </td>
                                <td>
                                    <?php print $row->pus_mail; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <form id="default" method="post" action="<?php print $this->config->base_url(); ?>settings/publishers">
                    <fieldset>
                        <legend>Publishers</legend>
                        <?php if ($this->session->flashdata('message') || !empty(validation_errors())): ?>
                            <div class="message">
                                <?php print $this->session->flashdata('message') . validation_errors(); ?>
                            </div>
                        <?php endif; ?>
                        <dl>
                            <dt>
                                <label for="pus_name">Name</label>
                            </dt>
                            <dd>
                                <input type="text" name="pus_name"value="<?php print ($this->input->post("pus_name")) ? $this->input->post("pus_name") : ""; ?>" />
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <label for="pus_mail">Email</label>
                            </dt>
                            <dd>
                                <input type="text" name="pus_mail" value="<?php print ($this->input->post("pus_mail")) ? $this->input->post("pus_mail") : ""; ?>" />
                            </dd>
                        </dl>
                    </fieldset>
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/piwik.php'); ?>
    </body>
</html>