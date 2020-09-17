<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Api;

class SettingsApi {
  public $admin_pages = array();
  public $admin_subpages = array();
	public $settings = array();
	public $sections = array();
	public $fields = array();

  public function register() {
    if (! empty($this->admin_pages)) {
      add_action('admin_menu', array($this, 'addAdminMenu'));
    }

    if (! empty($this->settings)) {
      add_action('admin_init', array($this, 'registerCustomFields'));
    }
  }

  public function addAdminMenu() {
    foreach ($this->admin_pages as $page) {
      $hook = add_menu_page($page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position']);

      if ($page['menu_slug'] == 'blfa_plugin_books') {
        add_action('load-'.$hook,array($this, 'redirectBookAdminPage'));
      }
    }

     foreach ( $this->admin_subpages as $subpage ) {
      add_submenu_page( $subpage['parent_slug'], $subpage['page_title'], $subpage['menu_title'], $subpage['capability'], $subpage['menu_slug'], $subpage['callback'] );
     }
  }

  public function withSubPage(string $title = null) {
		if (! empty($this->admin_pages)) {
      $admin_page = $this->admin_pages[0];

  		$subpage = array(
  			array(
  				'parent_slug' => $admin_page['menu_slug'],
  				'page_title' => ($title) ? $title : $admin_page['page_title'],
  				'menu_title' => ($title) ? $title : $admin_page['menu_title'],
  				'capability' => $admin_page['capability'],
  				'menu_slug' => $admin_page['menu_slug'],
  				'callback' => $admin_page['callback']
  			)
  		);

  		$this->admin_subpages = $subpage;
    }

		return $this;
	}

  public function addPages(array $pages) {
      $this->admin_pages = $pages;

      return $this;
  }

  public function addSubPages(array $pages) {
    $this->admin_subpages = array_merge($this->admin_subpages, $pages);

    return $this;
  }

  public function registerCustomFields() {
		// register setting
		foreach ( $this->settings as $setting ) {
			register_setting( $setting["option_group"], $setting["option_name"], ( isset( $setting["callback"] ) ? $setting["callback"] : '' ) );
		}

		// add settings section
		foreach ( $this->sections as $section ) {
			add_settings_section( $section["id"], $section["title"], ( isset( $section["callback"] ) ? $section["callback"] : '' ), $section["page"] );
		}

		// add settings field
		foreach ( $this->fields as $field ) {
			add_settings_field( $field["id"], $field["title"], ( isset( $field["callback"] ) ? $field["callback"] : '' ), $field["page"], $field["section"], ( isset( $field["args"] ) ? $field["args"] : '' ));
		}
	}

  public function addSettings( array $settings )	{
  		$this->settings = array_merge($this->settings, $settings);
  		return $this;
  }

  public function addSections( array $sections ) {
  		$this->sections = array_merge($this->sections, $sections);
  		return $this;
  }

  public function addFields( array $fields ) {
		$this->fields = array_merge($this->fields, $fields);
		return $this;
	}

  public function redirectBookAdminPage() {
    if(isset($_GET['settings-updated']) && $_GET['settings-updated'])
     {
       wp_safe_redirect( get_admin_url() . '?page=blfa_plugin_books' );
       exit;
     }
  }
}
