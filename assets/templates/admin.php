<?php $img_path = plugin_dir_url( dirname( __FILE__, 1) ); ?>
<div class="wrap">
  <h1>Book List - General Settings</h1>
  <?php settings_errors(); ?>

  <div class="blfa-spinner"><img src="<?php echo $img_path; ?>img/blfa-spinner.gif" alt="loading"/></div>

  <form id="blfa-settings-form" method="post" action="options.php">
    <div id="blfa-admin-content" style="display: none;">
    <?php
      submit_button();
      settings_fields('blfa_plugin');
      do_settings_sections('blfa_plugin_settings');
      submit_button();
    ?>
    </div>
  </form>
</div>
