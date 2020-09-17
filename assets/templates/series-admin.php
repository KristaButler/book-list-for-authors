<?php $img_path = plugin_dir_url( dirname( __FILE__, 1) ); ?>
<div class="wrap">
  <h1>Book List - Series and Groups</h1>
  <?php settings_errors(); ?>

  <div class="blfa-spinner" style="display: none;"><img src="<?php echo $img_path; ?>img/blfa-spinner.gif" alt="loading"/></div>

  <div id="blfa-admin-content">
    <div class="blfa-series-list">
      <?php
        $series_list = get_option('blfa_plugin_series');

        if ($series_list) { ?>
          <table id="series-list-table" class="wp-list-table widefat fixed striped series-list-table">
            <thead>
              <tr>
                <th class="manage-column column-primary">Title</th>
                <th class="manage-column">Shared?</th>
                <th class="manage-column">URL Slug</th>
                <th class="manage-column sorter-false">Actions</th>
              </tr>
            </thead>

          <?php
            foreach ($series_list as $id => $series) {
              ?>
              <tr id="<?php echo $id; ?>">
                <td class="blfa-series-title"><?php echo $series['blfa_series_title']; ?></td>
                <td class="blfa-series-shared">
                  <?php if ($series['blfa_shared_series']) {?>
                    <span class="blfa-check-mark">&check;</span>
                  <?php } ?>
                </td>
                <td class="blfa-series-slug">
                  <?php echo $series['blfa_series_slug']; ?>
                </td>
                <td class="blfa-actions">
                  <a class="blfa-edit" href="#<?php echo $id; ?>">Edit</a>
                  <a class="blfa-view" href="<?php echo get_site_url() . '/books/' . $series['blfa_series_slug'] ?>">View Page</a>
                  <a class="blfa-delete" href="#<?php echo $id; ?>">Delete</a>
                </td>
              </tr>
              <?php
            }
            ?>
            </table>
          <?php
          } else {
            ?>
              <h2>You haven't added a series yet.</h2>
            <?php
          }
        ?>
    </div>

    <div class="series-input-form">
      <form id="blfa-series-admin-form" method="post" action="options.php">
        <?php
          settings_fields('blfa_plugin_series');
          do_settings_sections('blfa_plugin_series');
          submit_button();
        ?>
        <input id="blfa-clear-button" type="button" class="button button-secondary" value="Clear"/>
      </form>
    </div>
  </div>
</div>
