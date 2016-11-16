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
            <div class="container-inner" id="status">
                <table>
                    <colgroup>
                        <col span="1" style="width: 250px;" />
                        <!--<col span="1" style="width: 50px;" />-->
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Status</th>
                            <!--<th>Edit</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($status as $key => $row): ?>
                            <tr>
                                <td>
                                    <?php print $row->sta_name; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <form id="default" action="<?php print $this->config->base_url(); ?>settings/status<?php print (isset($edit)) ? "/{$edit[0]->sta_id}" : ""; ?>" method="post">
                    <fieldset>
                        <legend>Status</legend>
                        <?php if ($this->session->flashdata('message')): ?>
                            <div class="message">
                                <?php print $this->session->flashdata('message'); ?>
                            </div>
                        <?php endif; ?>
                        <dl>
                            <dt>
                                <label for="sta_name">Name</label>
                            </dt>
                            <dd>
                                <input type="text" name="sta_name" value="<?php print (isset($edit)) ? $edit[0]->sta_name : ""; ?>" />
                            </dd>
                        </dl>
                    </fieldset>
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <?php if (isset($edit)): ?>
                            <a href="<?php print $this->config->base_url(); ?>settings/status" class="command">Insert new status</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/piwik.php'); ?>
    </body>
</html>