<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Util;

use \Inc\Util\BaseController;

class Enqueue extends BaseController {
   public function register() {
     add_action('admin_enqueue_scripts', array($this, 'enqueue'));
   }

   public function enqueue($hook) {
     wp_enqueue_media();
     wp_enqueue_script('jquery');
     wp_enqueue_script('jquery-ui-core', array('jquery'));
     wp_enqueue_script('jquery-ui-datepicker', array('jquery-ui-core'));

    if (strpos($hook, 'blfa_') > -1) {
       //enqueue all scripts
      wp_register_style('blfa-settings-css', $this->plugin_url . 'assets/css/admin-settings.css');
      wp_enqueue_style('blfa-settings-css');
    }

    if (strpos($hook, 'blfa_plugin_settings') > -1) {
      wp_register_script('blfa-settings-js', $this->plugin_url . 'assets/js/admin-settings.js', array('jquery'));
      wp_enqueue_script('blfa-settings-js');
    }

    if (strpos($hook, 'blfa_plugin_series') > -1) {
      wp_register_script('blfa-series-settings-js', $this->plugin_url . 'assets/js/series-settings.js', array('jquery'));
      wp_enqueue_script('blfa-series-settings-js');

      wp_register_script('tablesorter-2-js', $this->plugin_url . 'assets/js/ext/jquery.tablesorter.combined.min.js', array('jquery'));
      wp_enqueue_script('tablesorter-2-js');
    }

    if (strpos($hook, 'blfa_plugin_retailers') > -1) {
      wp_register_script('blfa-retailers-settings-js', $this->plugin_url . 'assets/js/retailers-settings.js', array('jquery'));
      wp_enqueue_script('blfa-retailers-settings-js');

      wp_register_script('tablesorter-2-js', $this->plugin_url . 'assets/js/ext/jquery.tablesorter.combined.min.js', array('jquery'));
      wp_enqueue_script('tablesorter-2-js');
    }

    if (strpos($hook, 'blfa_plugin_books') > -1) {
      $blfa_options = get_option('blfa_plugin_settings');
      $js_params = array('author' => $blfa_options['blfa_settings_author'],
                    'website' => $blfa_options['blfa_settings_website']);

      wp_register_script('tablesorter-2-js', $this->plugin_url . 'assets/js/ext/jquery.tablesorter.combined.min.js', array('jquery'));
      wp_enqueue_script('tablesorter-2-js');

      wp_register_script('tablesorter-pager-js', $this->plugin_url . 'assets/js/ext/jquery.tablesorter.pager.min.js', array('jquery'));
      wp_enqueue_script('tablesorter-pager-js');

      wp_register_script('blfa-booklist-admin-js', $this->plugin_url . 'assets/js/booklist-admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'));
      wp_enqueue_script('blfa-booklist-admin-js');
      wp_localize_script('blfa-booklist-admin-js', 'me', $js_params);
    }
  }
}
