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
                            <col span="1" style="width: 200px;" />
                            <col span="1" style="width: 600px;" />
                            <col span="1" style="width: 50px;" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
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
                                            <?php print $row->fis_iden; ?>
                                        </td>
                                        <td>
                                            <?php print $row->fis_name; ?>
                                        </td>
                                        <td>
                                            <?php if (count($row->foreigers) > 0): ?>
                                                <ul class="fieldservice-browse-foreigers">
                                                    <?php foreach ($row->foreigers as $key_ => $row_): ?>
                                                        <li class="<?php print $row_->color; ?>">
                                                            <div class="foreiger">
                                                                <a href="/profile/contact/<?php print $row_->fif_foreigner; ?>">
                                                                    <?php print $row_->fif_foreigner; ?>
                                                                </a>
                                                            </div>
                                                            <div class="last-visit">
                                                                <?php print (!empty($row_->vis_date)) ? date('d/m/Y', strtotime($row_->vis_date)) : "Never Visited"; ?>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p>No foreigers on this list.</p>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <ul>
                                                    <li>
                                                        <a class="btn-list" style="margin-left: 6px;" href="/fieldservice/read/<?php print $row->fis_iden; ?>">&nbsp;</a>
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
                <div id="fieldservice-add">
                    <?php if (!empty($this->session->flashdata('error'))): ?>
                        <div id="fieldservice-add-messag">
                            <?php print $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    <div id="fieldservice-add-fields">
                        <form method="post" action="<?php print site_url("fieldservice/add"); ?>">
                            <fieldset>
                                <legend>New Field Service List</legend>
                                <dl>
                                    <dt>
                                        <label for="name">Name</label>
                                    </dt>
                                    <dd>
                                        <input type="text" name="name" />
                                    </dd>
                                </dl>
                            </fieldset>
                            <div class="form-actions">
                                <input type="submit" value="Submit" />
                            </div>
                        </form>
                    </div>
                </div>
                <div id="fieldservice-unlisted">
                    <div id="fieldservice-unlisted-title">Unlisted Active Contacts</div>
                    <div id="fieldservice-unlisted-lists">
                        <ul>
                            <?php foreach ($unlisted as $value): ?>
                                <li>
                                    <a href="<?php print site_url("profile/contact/{$value->for_id}"); ?>">
                                        <?php print $value->for_id; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/footer.php'); ?>
    </body>
</html>