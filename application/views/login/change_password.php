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
                <?php print validation_errors(); ?>
                <form id="default" action="<?php print $this->config->base_url(); ?>login/changepassword" method="post">
                    <fieldset>
                        <legend>Security</legend>
                        <dl>
                            <dt>
                                <label for="password_current">Current Password</label>
                            </dt>
                            <dd>
                                <input type="password" name="password_current" />
                            </dd>
                        </dl>
                    </fieldset>
                    <fieldset>
                        <legend>Password</legend>
                        <dl>
                            <dt>
                                <label for="password_new">New Password</label>
                            </dt>
                            <dd>
                                <input type="password" name="password_new" />
                            </dd>
                        </dl>
                        <hr />
                        <dl>
                            <dt>
                                <label for="password_confirm">Password Confirmation</label>
                            </dt>
                            <dd>
                                <input type="password" name="password_confirm" />
                            </dd>
                        </dl>
                    </fieldset>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/piwik.php'); ?>
    </body>
</html>