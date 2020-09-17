<?php

/**
 * @package BookListForAuthors
 */
 namespace Inc\Util;

use \Inc\Util\BaseController;

class SettingsLink extends BaseController {

  public function register() {
    add_filter("plugin_action_links_$this->plugin_name", array($this, 'add_settings_link'));
  }

  public function add_settings_link($links) {
    $settings_link = '<a href="admin.php?page=blfa_plugin_settings">Settings</a>';

    array_push($links, $settings_link);

    return $links;
  }
}
