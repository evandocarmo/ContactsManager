<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">
    <head>
        <?php include_once(APPPATH . 'views/includes/head.php'); ?>
        <?php if (isset($contato[0]->for_route) && isset($contato[0]->for_street_number) && isset($contato[0]->for_sublocality) && isset($contato[0]->for_locality)): ?>
            <script type="text/javascript"> var endereco = "<?php print ($contato[0]->for_route <> "Uninformed") ? html_entity_decode($contato[0]->for_route, ENT_QUOTES, 'UTF-8') : ""; ?>
    <?php print ($contato[0]->for_street_number <> "Uninformed") ? html_entity_decode($contato[0]->for_street_number, ENT_QUOTES, 'UTF-8') : ""; ?>
    <?php print ($contato[0]->for_sublocality <> "Uninformed") ? html_entity_decode($contato[0]->for_sublocality, ENT_QUOTES, 'UTF-8') : ""; ?>
            <?php print ($contato[0]->for_locality <> "Uninformed") ? html_entity_decode($contato[0]->for_locality, ENT_QUOTES, 'UTF-8') : ""; ?>"; </script>
        <?php endif; ?>
    </head>
    <body>
        <div class="navigation">
            <?php include_once(APPPATH . 'views/includes/navigation.php'); ?>
        </div>
        <div class="container">
            <div class="container-inner">
                <form id="default" action="<?php print $this->config->base_url(); ?>foreigners/contact<?php print (isset($contato[0]->for_id)) ? "/{$contato[0]->for_id}" : ""; ?>" method="post">
                    <fieldset>
                        <legend>Personal Information</legend>
                        <dl>
                            <dt>
                                <label for="for_name">Name</label>
                            </dt>
                            <dd>
                                <input type="text" name="for_name" <?php print (isset($contato[0]->for_name)) ? "value=\"{$contato[0]->for_name}\"" : ""; ?> />
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <label for="for_nationality">Country</label>
                            </dt>
                            <dd>
                                <select name="for_nationality">
                                    <option value="0">Uninformed</option>
                                    <?php foreach ($country as $id => $value): ?>
                                        <option value="<?php print $value->id; ?>" <?php if (isset($contato[0]->for_nationality) && $value->id == $contato[0]->for_nationality): ?>selected="selected"<?php endif; ?>>
                                            <?php print $value->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <label for="for_telephone">Phone</label>
                            </dt>
                            <dd>
                                <input type="text" name="for_telephone" <?php print (isset($contato[0]->for_telephone)) ? "value=\"{$contato[0]->for_telephone}\"" : ""; ?> />
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <label for="sta_id">Status</label>
                            </dt>
                            <dd>
                                <select name="sta_id">
                                    <?php foreach ($status as $id => $value): ?>
                                        <option value="<?php print $value->sta_id; ?>" <?php if (isset($contato[0]->sta_id) && $value->sta_id == $contato[0]->sta_id): ?>selected="selected"<?php endif; ?>>
                                            <?php print $value->sta_name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </dd>
                        </dl>
                    </fieldset>
                    <fieldset>
                        <legend>Address</legend>
                        <dl>
                            <dt>
                                <button type="button" id="address-button">Search</button>
                            </dt>
                            <dd>
                                <input type="text" name="for_address" id="address-input" />
                            </dd>
                        </dl>
                        <dl id="canvas-map">
                            <dt>Map</dt>
                            <dd>
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <label for="for_route">Street</label>
                            </dt>
                            <dd>
                                <input type="text" data-geo="route" name="for_route" <?php print (isset($contato[0]->for_route)) ? "value=\"{$contato[0]->for_route}\"" : ""; ?> />
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <label for="for_street_number">Number</label>
                            </dt>
                            <dd>
                                <input type="text" name="for_street_number" <?php print (isset($contato[0]->for_street_number)) ? "value=\"{$contato[0]->for_street_number}\"" : ""; ?> placeholder="Fill this field manually" />
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <label for="for_sublocality">Neighborhood</label>
                            </dt>
                            <dd>
                                <input type="text" data-geo="neighborhood" name="for_sublocality" <?php print (isset($contato[0]->for_sublocality)) ? "value=\"{$contato[0]->for_sublocality}\"" : ""; ?> />
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <label for="for_locality">City</label>
                            </dt>
                            <dd>
                                <input type="text" data-geo="locality" name="for_locality" <?php print (isset($contato[0]->for_locality)) ? "value=\"{$contato[0]->for_locality}\"" : ""; ?> />
                            </dd>
                        </dl>
                    </fieldset>
                    <fieldset>
                        <legend>Other</legend>
                        <dl>
                            <dt>
                                <label for="for_complement">Complement</label>
                            </dt>
                            <dd>
                                <input type="text" name="for_complement" <?php print (isset($contato[0]->for_complement)) ? "value=\"{$contato[0]->for_complement}\"" : ""; ?> />
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <label for="cat_id">Region</label>
                            </dt>
                            <dd>
                                <select name="cat_id">
                                    <?php foreach ($category as $id => $value): ?>
                                        <option value="<?php print $value->cat_id; ?>" <?php if (isset($contato[0]->cat_id) && $value->cat_id == $contato[0]->cat_id): ?>selected="selected"<?php endif; ?>>
                                            <?php print $value->cat_name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </dd>
                        </dl>
                    </fieldset>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <input type="hidden" name="for_id" value="<?php print (isset($contato[0]->for_id)) ? $contato[0]->for_id : ""; ?>" />
                        <input type="hidden" name="for_location" data-geo="location" value="<?php print (isset($contato[0]->for_location)) ? $contato[0]->for_location : ""; ?>" />
                    </div>
                </form>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/piwik.php'); ?>
    </body>
</html>