<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="content-type" content="text/html; charset=<?php print config_item('charset'); ?>" />

<title>Contacts Manager<?php print (isset($this->session->userdata['logged_in']['loc_name'])) ? " - {$this->session->userdata['logged_in']['loc_name']}" : ''; ?></title>

<style type="text/css">
    @import url("<?php print $this->config->base_url(); ?>browser/css/_bower.css") (max-width: 900px);
    @import url("<?php print $this->config->base_url(); ?>browser/css/responsive.css") (max-width: 900px);
    @import url("<?php print $this->config->base_url(); ?>browser/css/default.css") (min-width: 900px);
</style>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places,visualization"></script>
<script type="text/javascript" src="<?php print $this->config->base_url(); ?>browser/js/_bower.js"></script>
<script type="text/javascript" src="<?php print $this->config->base_url(); ?>browser/js/default.js"></script>