<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr">    <head>        <?php include_once(APPPATH . 'views/mobile/includes/head.php'); ?>    </head>    <body>        <div id="menu">            <?php include_once(APPPATH . 'views/mobile/includes/navigation.php'); ?>        </div>        <div id="panl">            <div class="container-tpbar">                <a href="#" class="toggle">OpenSideBar</a>            </div>            <div class="container-inner">                <div id="foreigner">                    <div class="foreigner-name">                        <?php print $assign['for_name']; ?>                    </div>                    <div class="foreigner-tele">                        <?php print $assign['for_telephone']; ?>                    </div>                    <?php if (!empty($messanger)): ?>                        <div class="foreigner-messanger">                            <p>                                <?php print $messanger; ?>                            </p>                        </div>                    <?php endif; ?>                    <div class="foreigner-desc">                        <form method="post" action="<?php print site_url("mobile/update/{$assign['pet_iden']}"); ?>">                            <fieldset>                                <dl>                                    <dt>                                        <label for="pet_desc">Feedback</label>                                    </dt>                                    <dd>                                        <textarea name="pet_desc" placeholder="Feedback">                                        </textarea>                                    </dd>                                </dl>                            </fieldset>                            <input type="submit" value="Submit" />                        </form>                    </div>                </div>            </div>        </div>        <?php include_once(APPPATH . 'views/mobile/includes/slideout.php'); ?>    </body></html> 