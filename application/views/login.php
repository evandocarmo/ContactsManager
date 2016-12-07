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
                <?php if (isset($errors) && is_string($errors)): ?>
                    <div id="messages-login">
                        <?php print $errors; ?>
                    </div>
                <?php endif; ?>
                <form id="default" method="post" action="<?php print $this->config->base_url(); ?>login/verify">
                    <fieldset>
                        <legend>Login</legend>
                        <dl>
                            <dt>
                                <label for="username">Username</label>
                            </dt>
                            <dd>
                                <input type="text" id="username" name="username" />
                            </dd>
                        </dl>
                        <dl>
                            <dt>
                                <label for="password">Password</label>
                            </dt>
                            <dd>
                                <input type="password" id="password" name="password" />
                            </dd>
                        </dl>
                    </fieldset>
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <?php include_once(APPPATH . 'views/includes/footer.php'); ?>
    </body>
</html>
