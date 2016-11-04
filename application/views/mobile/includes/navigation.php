<div class="container-tpbar">
    <a class="toggle" href="#">OpenSideBar</a>
</div>
<div class="navigation-inner">
    <div class="navigation-brand">
        <h1>Contcats Manager</h1>
        <h2>Personal Territory</h2>
    </div>
    <div class="navigation-menu">
        <ul>
            <?php if (isset($this->session->userdata['logged_personal'])): ?>
                <li<?php if ($this->uri->segment(2) == "dashboard"): ?> class="active"<?php endif; ?>>
                    <span class="fa fa-list-alt">
                    </span>
                    <a href="<?php print site_url("mobile/dashboard"); ?>">Dashboard</a>
                </li>
                <li<?php if ($this->uri->segment(2) == "add"): ?> class="active"<?php endif; ?>>
                    <span class="fa fa-phone">
                    </span>
                    <a href="<?php print site_url("mobile/add"); ?>">Phone Call</a>
                </li>
                <!-- <li>
                <span class="fa fa-user-secret">
                </span>
                <a href="#">Change Password</a>
                </li> -->
                <li>
                    <span class="fa fa-sign-out">
                    </span>
                    <a href="<?php print site_url("mobile/logout"); ?>">Logout</a>
                </li>
            <?php else: ?>
                <li<?php if ($this->uri->segment(2) == "login"): ?> class="active"<?php endif; ?>>
                    <span class="fa fa-users">
                    </span>
                    <a href="#">Login</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>