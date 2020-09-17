<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Util;

class BaseController {
	public $plugin_path;
	public $plugin_url;
	public $plugin_name;

  public $plugin_options;

	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin_name = plugin_basename( dirname( __FILE__, 3 ) ) . '/book-list-for-authors.php';

    $this->plugin_options = array (
      'other' => array (
        'blfa_settings_author' => "",
				'blfa_settings_website' => ""
      ),
       'checkboxes' => array (
         'blfa_allbooks_include_page' => 1,
         'blfa_allbooks_include_number' => 0,
         'blfa_allbooks_number_top' => 0,
         'blfa_allbooks_include_title' => 0,
         'blfa_allbooks_include_author' => 0,
         'blfa_allbooks_include_desc' => 0,
         'blfa_allbooks_include_buy_button' => 0,
         'blfa_seriespage_include_page' => 1,
         'blfa_series_include_number' => 0,
         'blfa_series_number_top' => 0,
         'blfa_series_include_title' => 0,
         'blfa_series_include_author' => 0,
         'blfa_series_include_desc' => 0,
         'blfa_series_include_buy_button' => 0,
         'blfa_series_featured_by_me' => 0,
         'blfa_bookpage_include_page' => 1,
         'blfa_bookpage_link_cover' => 1,
         'blfa_bookpage_include_number' => 0,
         'blfa_bookpage_number_top' => 0,
         'blfa_bookpage_include_author' => 0,
         'blfa_bookpage_include_series' => 0,
      ),
      'chooseones' => array (
        'blfa_allbooks_page_layout' => array (
          'choices' => array(
            'grid',
            'list'
          ),
          'default' => 'grid'
        ),
        'blfa_allbooks_list_layout' => array (
          'choices' => array(
            'centered',
            'left',
            'right',
            'alternate'
          ),
          'default' => 'alternate'
        ),
        'blfa_allbooks_cover_size' => array (
          'choices' => array(
            'small',
            'medium',
            'large'
          ),
          'default' => 'medium'
        ),
        'blfa_series_page_layout' => array (
          'choices' => array(
            'grid',
            'list',
            'featured'
          ),
          'default' => 'grid'
        ),
        'blfa_series_list_layout' => array (
          'choices' => array(
            'centered',
            'left',
            'right',
            'alternate'
          ),
          'default' => 'alternate'
        ),
        'blfa_series_cover_size' => array (
          'choices' => array(
            'small',
            'medium',
            'large'
          ),
          'default' => 'medium'
        ),
        'blfa_series_featured_cover_size' => array (
          'choices' => array (
            'medium',
            'large',
            'exlarge'
          ),
          'default' => 'large'
        ),
        'blfa_series_featured_book' => array (
          'choices' => array(
            'first',
            'recent'
          ),
          'default' => 'first'
        ),
        'blfa_bookpage_page_layout' => array (
          'choices' => array(
            'center',
            'left',
            'right',
            'left-nowrap'
          ),
          'default' => 'left'
        ),
        'blfa_bookpage_cover_size' => array (
          'choices' => array(
            'small',
            'medium',
            'large',
            'exlarge'
          ),
          'default' => 'medium'
        ),
        'blfa_bookpage_buy_button_location' => array (
          'choices' => array(
            'below-cover',
            'below-desc'
          ),
          'default' => 'below-cover'
        ),
        'blfa_bookpage_link_author' => array (
          'choices' => array(
            'always',
            'never',
            'not-me'
          ),
          'default' => 'not-me'
        )
      )
    );
	}

  public function getDefaults() {
    $defaults = array();

    foreach ($this->plugin_options['other'] as $key => $values) {
      $defaults[$key] = $values;
    }

    foreach ($this->plugin_options['checkboxes'] as $key => $value) {
      $defaults[$key] = $value;
    }

    foreach ($this->plugin_options['chooseones'] as $key => $options) {
      $defaults[$key] = $options['default'];
    }

    return $defaults;
  }


  public function getSlug($string) {
    $slug = preg_replace("/[^a-zA-Z0-9 \-]/", "", $string);
    $slug = preg_replace("/ /", "-", $slug);
    $slug = strtolower($slug);

    return $slug;
  }

  public static function getPluginPath() {
    return plugin_dir_path( dirname( __FILE__, 2 ) );
  }
}
