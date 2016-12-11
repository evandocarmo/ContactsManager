<?php if (isset($this->session->userdata['logged_in'])): ?>
    <div class="navigation-inner">
        <div class="navigation-brand">
            <a href="<?php print site_url("dashboard"); ?>">Contacts Manager<?php print (isset($this->session->userdata['logged_in']['loc_name'])) ? " - {$this->session->userdata['logged_in']['loc_name']}" : ''; ?>
            </a>
        </div>
        <div class="navigation-menu">
            <ul>
                <li>
                    <a href="#">Profile</a>
                    <ul>
                        <li>
                            <a href="<?php print site_url("login/changepassword"); ?>">Change Password</a>
                        </li>
                        <li>
                            <a href="<?php print site_url("login/logout"); ?>">Logout</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Settings</a>
                    <ul>
                        <li>
                            <a href="<?php print site_url("settings/status"); ?>">Status</a>
                        </li>
                        <li>
                            <a href="<?php print site_url("settings/category"); ?>">Category</a>
                        </li>
                        <li>
                            <a href="<?php print site_url("settings/publishers"); ?>">Publishers</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Management</a>
                    <ul>
                        <li>
                            <a href="<?php print site_url("fieldsearch/browse"); ?>">Field Search</a>
                        </li>
                        <li>
                            <a href="<?php print site_url("fieldservice/browse"); ?>">Field Service (List)</a>
                        </li>
                        <li>
                            <a href="<?php print site_url("fieldservice/browselists"); ?>">Field Service (Schedule)</a>
                        </li>
                        <li>
                            <a href="<?php print site_url("reservedcontacts/browse"); ?>">Reserved Contacts</a>
                        </li>
                        <li>
                            <a href="<?php print site_url("management/backup"); ?>">Automated Backups</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Foreigners</a>
                    <ul>
                        <li>
                            <a href="<?php print site_url("foreigners/contacts"); ?>">Contacts</a>
                        </li>
                        <li>
                            <a href="<?php print site_url("foreigners/contact"); ?>">Insert Contact</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Statistics</a>
                    <ul>
                        <li>
                            <a href="<?php print site_url("statistics/heatmap"); ?>">Heatmap</a>
                        </li>
                        <li>
                            <a href="<?php print site_url("statistics/foreigners"); ?>">Foreigners</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php print site_url("dashboard"); ?>">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
<?php endif; ?>