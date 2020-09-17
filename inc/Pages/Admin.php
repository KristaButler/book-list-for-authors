<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Pages;

use \Inc\Util\BaseController;
use \Inc\Api\SettingsApi;
use \Inc\Api\Callbacks\AdminCallbacks;
use \Inc\Api\Callbacks\AdminSanitizer;
use \Inc\Api\Options\GeneralOptions;
use \Inc\Api\Options\SeriesOptions;
use \Inc\Api\Options\RetailerOptions;
use \Inc\Api\Options\BookOptions;

/**
 *
 */
class Admin extends BaseController {
  public $settings;
  public $callbacks;
  public $pages = array();
  public $subpages = array();

  public function __construct() {
    parent::__construct();
    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();
    $this->sanitizer = new AdminSanitizer();
    $general_options = new GeneralOptions();
    $series_options = new SeriesOptions();
    $retailer_options = new RetailerOptions();
    $book_options = new BookOptions();

    $this->setPages();
    $this->setSubpages();
    $this->settings = $general_options->prepare($this->settings);
    $this->settings = $series_options->prepare($this->settings);
    $this->settings = $retailer_options->prepare($this->settings);
    $this->settings = $book_options->prepare($this->settings);
  }

  public function setPages() {
    $this->pages = array(
      array (
        'page_title' => 'Book List for Authors',
        'menu_title' => 'Book List',
        'capability' => 'manage_options',
        'menu_slug' => 'blfa_plugin_books',
        'callback' => array($this->callbacks, 'bookListBooks'),
        'icon_url' => 'dashicons-book',
        'position' => 110
      )
    );
  }

  public function setSubPages() {
    $this->subpages = array(
      array (
        'parent_slug' => 'blfa_plugin_books',
        'page_title' => 'Book List - Series',
        'menu_title' => 'Series',
        'capability' => 'manage_options',
        'menu_slug' => 'blfa_plugin_series',
        'callback' => array($this->callbacks, 'bookListSeries')
      ),
      array (
        'parent_slug' => 'blfa_plugin_books',
        'page_title' => 'Book List - Retailers',
        'menu_title' => 'Retailers',
        'capability' => 'manage_options',
        'menu_slug' => 'blfa_plugin_retailers',
        'callback' => array($this->callbacks, 'bookListRetailers')
      ),
      array (
        'parent_slug' => 'blfa_plugin_books',
        'page_title' => 'Book List - Settings',
        'menu_title' => 'Settings',
        'capability' => 'manage_options',
        'menu_slug' => 'blfa_plugin_settings',
        'callback' => array($this->callbacks, 'bookListSettings')
      )
    );
  }

  public function register() {
    $this->settings->addPages($this->pages)->withSubpage('Books')->addSubPages($this->subpages)->register();
	}
}
