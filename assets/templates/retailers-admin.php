<?php
  $img_path = plugin_dir_url( dirname( __FILE__, 1) );
  $default_retailer_img = $img_path . 'img/default-retailer-icon.png';
?>
<span style="display: none;" id="default_retailer_img"><?php echo $default_retailer_img; ?></span>
<div class="wrap">
  <h1>Book List - Retailers</h1>
  <?php settings_errors(); ?>

  <div class="blfa-spinner" style="display: none;"><img src="<?php echo $img_path; ?>img/blfa-spinner.gif" alt="loading"/></div>

  <div id="blfa-admin-content">
    <div class="blfa-retailers-list">
      <?php
        $retailer_list = get_option('blfa_plugin_retailers');

        if ($retailer_list) {
      ?>
      <table id="retailers-list-table" class="wp-list-table widefat fixed striped retailer-list-table">
        <thead>
          <tr>
            <th class="manage-column column-primary">Retailer</th>
            <th class="manage-column sorter-false">Icon</th>
            <th class="manage-column">Affliate Tag</th>
            <th class="manage-column">Default?</th>
            <th class="manage-column sorter-false">Actions</th>
          </tr>
        </thead>

      <?php
        foreach ($retailer_list as $id => $retailer) {
          //Don't display the default retailer listing
          if ($id != 'default_retailer') {
          ?>
          <tr id="<?php echo $id; ?>">
            <td class="blfa-retailer-name"><?php echo $retailer['blfa_retailer_name']; ?>
            </td>
            <td class="blfa-retailer-icon">
              <?php echo  wp_get_attachment_image($retailer['blfa_retailer_icon'], 'blfa-retailer-icon');?>
              <span style="display: none;"><?php echo $retailer['blfa_retailer_icon'];?></span>
            </td>
            <td class="blfa-retailer-tag"><?php echo $retailer['blfa_affiliate_tag']; ?>
            </td>
            <td class="blfa-default-retailer">
              <?php if ($retailer['blfa_default_retailer']) {?>
                <span class="blfa-check-mark">&check;</span>
              <?php } ?>
            </td>
            <td class="blfa-actions">
              <a class="blfa-edit" href="#<?php echo $id; ?>">Edit</a>
              <a class="blfa-delete" href="#<?php echo $id; ?>">Delete</a>
              <a class="blfa-default" href="#<?php echo $id; ?>">Set Default</a>
            </td>
          </tr>
          <?php
          }
        }
        ?>
        </table>
      <?php
      } else {
        ?>
          <h2>You haven't added any retailers yet.</h2>
        <?php
      }
    ?>
  </div>

  <div class="retailers-input-form">
    <form id="blfa-retailers-admin-form" method="post" action="options.php">
      <?php
        settings_fields('blfa_plugin_retailers');
        do_settings_sections('blfa_plugin_retailers');
        submit_button();
      ?>
      <input id="blfa-clear-button" type="button" class="button button-secondary" value="Clear"/>
    </form>
  </div>
</div>
