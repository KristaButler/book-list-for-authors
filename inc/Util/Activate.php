<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Util;

use \Inc\Util\BaseController;
use \Inc\Util\DatabaseUtil;

class Activate {
  public static function activate() {
    flush_rewrite_rules();

    $controller = new BaseController();
    $databaseUtil = new DatabaseUtil();
    $databaseUtil->addTables();

    if (get_option('blfa_plugin_settings')) {
       return;
    }

    add_option('blfa_db_version', '1.1');
    update_option('blfa_plugin_settings', $controller->getDefaults());
    update_option('blfa_plugin_series', array());
    update_option('blfa_plugin_retailers', array());
  }
}
