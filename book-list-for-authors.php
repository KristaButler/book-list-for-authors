<?php
/**
 * @package BookListForAuthors
 * Plugin Name:  Book List for Authors
 * Plugin URI:   http://www.pluviotech.com/plugins/book-list-wp.php
 * Description:  WordPress plug in for adding and managing book lists, and book pages
 *               on author websites powered by WordPress.
 * Version:      1.2
 * Author:       Krista @ Pluvio Tech, LLC
 * Author URI:   http://www.pluviotech.com
 * License:      GPL3
 * License URI:  https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:  blfa
 */
defined( 'ABSPATH' ) or die( 'This is not the script you are looking for.' );

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

function activate_blfa_plugin() {
  Inc\Util\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_blfa_plugin');

function deactivate_blfa_plugin() {
  Inc\Util\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_blfa_plugin');

if (class_exists('Inc\\Init')) {
  Inc\Init::register_services();
}
