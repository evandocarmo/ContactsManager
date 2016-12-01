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
                            <col span="1" style="width: 70px;" />
                            <col span="1" style="width: 223px;" />
                            <col span="1" style="width: 135px;" />
                            <col span="1" style="width: 150px;" />
                            <col span="1" style="width: 80px;" />
                            <col span="1" style="width: 100px;" />
                            <col span="1" />
                            <col span="1" style="width: 120px;" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Country</th>
                                <th>Sub Locality</th>
                                <th>Status</th>
                                <th>Region</th>
                                <th>Visits</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="filter">
                                <td>
                                    <input type="text" name="for_id" value="<?php print ($this->input->get('for_id')) ? $this->input->get('for_id') : ""; ?>" />
                                </td>
                                <td>
                                    <input type="text" name="for_name" value="<?php print ($this->input->get('for_name')) ? $this->input->get('for_name') : ""; ?>" />
                                </td>
                                <td>
                                    <select name="for_nationality">
                                        <option value="ALL" <?php if ("ALL" == $this->input->get('for_nationality')): ?>selected="selected"<?php endif; ?>>All</option>
                                        <option value="0" <?php if ('0' === $this->input->get('for_nationality')): ?>selected="selected"<?php endif; ?>>Uninformed</option>
                                        <?php foreach ($country as $id => $value): ?>
                                            <option value="<?php print $value->id; ?>" <?php if ($value->id == $this->input->get('for_nationality')): ?>selected="selected"<?php endif; ?>>
                                                <?php print $value->name; ?> (<?php print $value->number; ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <select name="sta_id">
                                        <option value="ALL" <?php if ("ALL" == $this->input->get('sta_id')): ?>selected="selected"<?php endif; ?>>All</option>
                                        <?php foreach ($status as $id => $value): ?>
                                            <option value="<?php print $value->sta_id; ?>" <?php if ($value->sta_id == $this->input->get('sta_id')): ?>selected="selected"<?php endif; ?>>
                                                <?php print $value->sta_name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="cat_id">
                                        <option value="ALL" <?php if ("ALL" == $this->input->get('cat_id')): ?>selected="selected"<?php endif; ?>>All</option>
                                        <?php foreach ($category as $id => $value): ?>
                                            <option value="<?php print $value->cat_id; ?>" <?php if ($value->cat_id == $this->input->get('cat_id')): ?>selected="selected"<?php endif; ?>>
                                                <?php print $value->cat_name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="vis_amount" value="<?php print !empty($this->input->get('vis_amount')) || $this->input->get('vis_amount') == "0" ? $this->input->get('vis_amount') : ""; ?>" />
                                </td>
                                <td>
                                    <button type="submit" class="bottom">Submit</button>
                                </td>
                            </tr>
                            <?php if (empty($table)): ?>
                                <tr>
                                    <td colspan="8">Nothing returned</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($table as $key => $row): ?>
                                    <tr>
                                        <td style="text-align: center;">
                                            <?php print $row->for_id; ?>
                                        </td>
                                        <td>
                                            <?php print $row->for_name; ?>
                                        </td>
                                        <td>
                                            <?php print $row->for_country; ?>
                                        </td>
                                        <td>
                                            <?php print $row->for_sublocality; ?>
                                        </td>
                                        <td>
                                            <?php print $row->for_status; ?>
                                        </td>
                                        <td>
                                            <?php print $row->for_category; ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php print $row->for_visits; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <ul>
                                                    <li>
                                                        <a href="<?php print $this->config->base_url(); ?>foreigners/contact/<?php print $row->for_id; ?>" class="btn-success">
                                                        <!--<i class="icon-edit">
                                                        </i>Edit-->
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php print $this->config->base_url(); ?>foreigners/printer/<?php print $row->for_id; ?>" class="btn-info">
                                                        <!--<i class="icon-print">
                                                        </i>Print-->
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php print $this->config->base_url(); ?>profile/contact/<?php print $row->for_id; ?>" class="btn-danger">
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
                </form>
                <div id="pagination">
                    <div id="pagination-navigation">
                        <?php print $links; ?>
                    </div>
                    <div id="pagination-description"> Total of <?php print $total; ?> results. </div>
                </div>
                <!--<a class="bottom" href="<?php print $this->config->base_url(); ?>foreigners/export">Download Excel</a>-->
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/footer.php'); ?>
    </body>
</html>
