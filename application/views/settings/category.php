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
                        <col span="1" style="width: 205px;" />
                        <col span="1" style="width: 45px;" />
                        <!--<col span="1" style="width: 50px;" />-->
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Color</th>
                            <!--<th>Edit</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($category as $key => $row): ?>
                            <tr>
                                <td>
                                    <?php print $row->cat_name; ?>
                                </td>
                                <td style="background-color: #<?php print $row->cat_color; ?>;">
                                </td>
                                <!--<td>
                                <div class="btn-group">
                                <ul>
                                <li>
                                <a class="btn-success" href="<?php print $this->config->base_url(); ?>settings/category/<?php print $row->cat_id; ?>">
                                <i class="icon-edit">
                                </i>
                                </a>
                                </li>
                                </ul>
                                </div>
                                </td>-->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <form id="default" action="<?php print $this->config->base_url(); ?>settings/category<?php print (isset($edit)) ? "/{$edit[0]->cat_id}" : ""; ?>" method="post">
                    <fieldset>
                        <legend>Category</legend>
                        <?php if ($this->session->flashdata('message')): ?>
                            <div class="message">
                                <?php print $this->session->flashdata('message'); ?>
                            </div>
                        <?php endif; ?>
                        <dl>
                            <dt>
                                <label for="cat_name">Name</label>
                            </dt>
                            <dd>
                                <input type="text" name="cat_name" <?php print (isset($edit)) ? "value=\"{$edit[0]->cat_name}\"" : ""; ?> />
                                <?php print form_error('cat_name', '<span>', '</span>'); ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <label for="cat_color">Color</label>
                            </dt>
                            <dd>
                                <input type="text" name="cat_color" <?php print (isset($edit)) ? "value=\"#{$edit[0]->cat_color}\"" : ""; ?> placeholder="Pick the color on the box below" />
                                <?php print form_error('cat_color', '<span>', '</span>'); ?>
                                <div id="cat_color">
                                </div>
                            </dd>
                        </dl>
                    </fieldset>
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <?php if (isset($edit)): ?>
                            <a href="<?php print $this->config->base_url(); ?>settings/category" class="command">Insert new category</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/piwik.php'); ?>
    </body>
</html>