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
                <div class="profile-data">
                    <h3>
                        <?php print $foreigner->for_name; ?>
                    </h3>
                    <a href="/foreigners/contact/<?php print $foreigner->for_id; ?>">Edit</a>
                    <table>
                        <tbody>
                            <tr>
                                <td>Country:</td>
                                <td>
                                    <i class="icon-flag">
                                    </i>
                                    <?php print $for_nationality; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>
                                    <i class="icon-home">
                                    </i>
                                    <?php print $foreigner->for_route; ?>, <?php print $foreigner->for_street_number; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Neighborhood:</td>
                                <td>
                                    <i class="icon-home">
                                    </i>
                                    <?php print $foreigner->for_sublocality; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Complement:</td>
                                <td>
                                    <i class="icon-home">
                                    </i>
                                    <?php print $foreigner->for_complement; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone:</td>
                                <td>
                                    <i class="icon-headphones">
                                    </i>
                                    <?php print $foreigner->for_telephone; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Status:</td>
                                <td>
                                    <i class="icon-warning-sign">
                                    </i>
                                    <?php print $sta_id[0]->sta_name; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Region:</td>
                                <td>
                                    <i class="icon-resize-small">
                                    </i>
                                    <?php print $cat_id[0]->cat_name; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>City:</td>
                                <td>
                                    <i class="icon-home">
                                    </i>
                                    <?php print $foreigner->for_locality; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Coordinates:</td>
                                <td>
                                    <i class="icon-map-marker">
                                    </i>
                                    <?php print $foreigner->for_location; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php if ($sta_id[0]->sta_name == 'Waiting'): ?>
                    <div class="profile-fieldsearch">
                        <div class="profile-fieldsearch-titl">Field Search Information</div>
                        <?php if (!empty($fieldsearch)): ?>
                            <div class="profile-fieldsearch-list">
                                <ul>
                                    <?php foreach ($fieldsearch as $key => $value): ?>
                                        <li>
                                            <div class="fis-date">
                                                <?php print $value->fie_datef; ?>
                                            </div>
                                            <div class="fis-cond">
                                                <?php print $value->fie_conductor; ?>
                                            </div>
                                            <div class="fis-actn">
                                                <?php if ($value->fie_display): ?>
                                                    <a href="/fieldsearch/delete/<?php print $foreigner->for_id; ?>/<?php print $value->fie_id; ?>">Delete</a>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="profile-fieldsearch-form">
                            <form method="post" action="<?php print site_url("profile/fieldsearch/{$foreigner->for_id}"); ?>">
                                <fieldset>
                                    <dl>
                                        <dt>
                                            <label for="fie_date">Date</label>
                                        </dt>
                                        <dd>
                                            <input type="text" name="fie_date" />
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>
                                            <label for="fie_conductor">Conductor</label>
                                        </dt>
                                        <dd>
                                            <input type="text" name="fie_conductor" />
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>
                                            <label for="fie_group">Group</label>
                                        </dt>
                                        <dd>
                                            <select name="fie_group">
                                                <?php for ($x = 0; $x <= 99; $x++): ?>
                                                    <option value="<?php print $x; ?>">
                                                        <?php print $x; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </dd>
                                    </dl>
                                </fieldset>
                                <div class="form-actions">
                                    <input type="submit" value="Submit" class="btn btn-primary" />
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (isset($publishers)): ?>
                    <div class="profile-publishers">
                        <form method="post" action="<?php print site_url("profile/setReturnVisitUpdate/{$foreigner->for_id}"); ?>">
                            <fieldset>
                                <dl>
                                    <dt>
                                        <label for="pub_iden">Reserved Contacts Information</label>
                                    </dt>
                                    <dd>
                                        <select name="pub_iden">
                                            <option value="#">Select an publisher.</option>
                                            <?php foreach ($publishers as $row): ?>
                                                <option value="<?php print $row->pub_iden; ?>" <?php if ($publishers_ == $row->pub_iden): ?>selected<?php endif; ?>>
                                                    <?php print $row->pub_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </dd>
                                </dl>
                            </fieldset>
                            <div class="form-actions">
                                <input type="submit" value="Submit" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
                <?php if ($sta_id[0]->sta_name == 'Active'): ?>
                    <div class="profile-fieldservice">
                        <form method="post" action="<?php print site_url("profile/fieldservice/{$foreigner->for_id}"); ?>">
                            <fieldset>
                                <dl>
                                    <dt>
                                        <label for="fif_fieldservice">Field Service Information</label>
                                    </dt>
                                    <dd>
                                        <select name="fif_fieldservice">
                                            <option value="#">Select an applyable territory list.</option>
                                            <?php foreach ($fieldservice as $row): ?>
                                                <option <?php print isset($fieldservic_) && $fieldservic_ == $row->fis_iden ? "selected" : ""; ?> value="<?php print $row->fis_iden; ?>">
                                                    <?php print $row->fis_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </dd>
                                </dl>
                            </fieldset>
                            <div class="form-actions">
                                <input type="submit" value="Submit" class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
                <?php if ($sta_id[0]->sta_name == "Elders"): ?>
                    <div class="profile-fieldservice">
                        <form method="post" action="<?php print site_url("profile/fieldservice/{$foreigner->for_id}"); ?>">
                            <fieldset>
                                <dl>
                                    <dt>
                                        <label for="fif_fieldservice">Printable Edition</label>
                                    </dt>
                                    <dd>
                                        <a href="<?php print site_url("profile/elders/{$foreigner->for_id}"); ?>" target="_blank" style="float: left;width: 100%;text-align: center;line-height: 25px;text-decoration: none;">Download Here</a>
                                    </dd>
                                </dl>
                            </fieldset>
                        </form>
                    </div>
                <?php endif; ?>
                <div class="profile-visit">
                    <h3>Visits</h3>
                    <?php if (empty($visits)): ?>
                        <div class="alert alert-info">There is no record of visits.</div>
                    <?php else: ?>
                        <ul>
                            <?php foreach ($visits as $rows): ?>
                                <li>
                                    <div class="head">
                                        <?php print date("d/m/Y", strtotime($rows->vis_date)); ?> (<?php print $rows->vis_publisher; ?>)</div>
                                    <div class="body">
                                        <div class="info">
                                            <?php print nl2br($rows->vis_description); ?>
                                        </div>
                                        <div class="bottom">
                                            <a href="<?php print $this->config->base_url(); ?>profile/contact/<?php print $foreigner->for_id; ?>/<?php print $rows->vis_id; ?>">Edit</a>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <form id="default" action="<?php print $this->config->base_url(); ?>profile/contact/<?php print $foreigner->for_id; ?>
                          <?php print (isset($visit)) ? "/{$visit[0]->vis_id}" : ""; ?>" method="post">
                        <fieldset>
                            <legend>Visits</legend>
                            <?php if ($this->session->flashdata('message')): ?>
                                <div class="message">
                                    <?php print $this->session->flashdata('message'); ?>
                                </div>
                            <?php endif; ?>
                            <dl>
                                <dt>
                                    <label for="vis_date">Date</label>
                                </dt>
                                <dd>
                                    <input type="text" name="vis_date" <?php print (isset($visit)) ? "value=\"" . date("d/m/Y", strtotime($visit[0]->vis_date)) . "\"" : ""; ?> placeholder="DD/MM/YYYY" />
                                </dd>
                            </dl>
                            <dl>
                                <dt>
                                    <label for="vis_publisher">Publisher</label>
                                </dt>
                                <dd>
                                    <input type="text" name="vis_publisher" <?php print (isset($visit)) ? "value=\"{$visit[0]->vis_publisher}\"" : ""; ?> />
                                </dd>
                            </dl>
                            <dl>
                                <dt>
                                    <label for="vis_description">Description</label>
                                </dt>
                                <dd>
                                    <textarea name="vis_description">
                                        <?php print (isset($visit)) ? "{$visit[0]->vis_description}" : ""; ?>
                                    </textarea>
                                </dd>
                            </dl>
                        </fieldset>
                        <div class="form-actions">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <?php include_once(APPPATH . 'views/includes/piwik.php'); ?>
</html>