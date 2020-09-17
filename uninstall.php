<?php
/* Book List for Authors WordPress Plugin by Pluvio Tech, LLC Uninstall File */

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}blfa_books");

//Delete Options
delete_option('blfa_db_version');
delete_option('blfa_plugin_settings');
delete_option('blfa_plugin_series');
delete_option('blfa_plugin_retailers');
