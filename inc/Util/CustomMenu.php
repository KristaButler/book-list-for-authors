<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Util;

use \Inc\Util\BaseController;
use \Inc\Util\DatabaseUtil;

require_once( ABSPATH . '/wp-admin/includes/class-walker-nav-menu-checklist.php' );

class CustomMenu extends BaseController {
    public function register() {
      add_filter( 'nav_menu_meta_box_object', array($this, 'booksMenuMetaBox'), 99, 1);
    }

    function booksMenuMetaBox( $object ) {
    	add_meta_box( 'blfa-menu-metabox', 'Books', array($this, 'menuMetaBox'), 'nav-menus', 'side', 'default' );
    	return $object;
    }

    function menuMetaBox() {
      global $nav_menu_selected_id;
      $dbUtil = new DatabaseUtil();
      $removed_args = array( 'action', 'customlink-tab', 'edit-menu-item', 'menu-item', 'page-tab', '_wpnonce' );

      $current_tab = 'all';

      $series_options = get_option('blfa_plugin_series');
      $books = $dbUtil->getAllBooks();
      $walker = new \Walker_Nav_Menu_Checklist();

      $series_list = array();
      foreach ($series_options as $series_id => $series_option) {
        $series_option['classes'] = array();
        $series_option['type'] = 'custom';
        $series_option['object_id'] = $series_option['blfa_series_id'];
        $series_option['title'] = $series_option['blfa_series_title'];
        $series_option['object'] = 'custom';
        $series_option['url'] = get_site_url() . '/books/' . $series_option['blfa_series_slug'];
        $series_option['attr_title'] = $series_option['blfa_series_title'];

        array_push($series_list, (object) $series_option);
      }

      foreach ($books as &$book) {
        $book->classes = array();
        $book->type = 'custom';
        $book->object_id = $book->id;
        $book->title = $book->title;
        $book->object = 'custom';
        $book->url = get_site_url() . '/books/' . $book->slug;
        $book->attr_title = $book->title;
      }

      $allbooks = (object) array(
        'classes' => array(),
        'type' => 'custom',
        'object_id' => 'blfa-all-books-menu-item',
        'title' => 'Books',
        'object' => 'custom',
        'url' => get_site_url() . '/books',
        'attr_title' => 'Books'
      );
      ?>
        <div id="blfa-nav-menu" class="categorydiv">
          <ul id="blfa-menu-tabs" class="blfa-menu-tabs add-menu-item-tabs">
            <li <?php echo ( 'all' == $current_tab ? ' class="tabs"' : '' ); ?>>
              <a class="nav-tab-link" data-type="tabs-panel-blfa-all" href="<?php if ( $nav_menu_selected_id ) echo esc_url( add_query_arg( 'blfa-menu-tab', 'all', remove_query_arg( $removed_args ) ) ); ?>#tabs-panel-blfa-all">
              	All Books
              </a>
            </li><!-- /.tabs -->

            <li <?php echo ( 'series' == $current_tab ? ' class="tabs"' : '' ); ?>>
              <a class="nav-tab-link" data-type="tabs-panel-blfa-series" href="<?php if ( $nav_menu_selected_id ) echo esc_url( add_query_arg( 'blfa-menu-tab', 'series', remove_query_arg( $removed_args ) ) ); ?>#tabs-panel-blfa-series">
              	Series
              </a>
            </li><!-- /.tabs -->

            <li <?php echo ( 'books' == $current_tab ? ' class="tabs"' : '' ); ?>>
              <a class="nav-tab-link" data-type="tabs-panel-blfa-books" href="<?php if ( $nav_menu_selected_id ) echo esc_url( add_query_arg( 'blfa-menu-tab', 'books', remove_query_arg( $removed_args ) ) ); ?>#tabs-panel-blfa-books">
              	Books
              </a>
            </li><!-- /.tabs -->
          </ul>

          <div id="tabs-panel-blfa-all" class="tabs-panel tabs-panel-view-all <?php echo ( 'all' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' ); ?>">
            <ul id="blfa-menu-checklist-all" class="categorychecklist form-no-clear">
              <?php
        				echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', array($allbooks)), 0, (object) array( 'walker' => $walker) );
        			?>
            </ul>
          </div><!-- /.tabs-panel -->

          <div id="tabs-panel-blfa-series" class="tabs-panel tabs-panel-view-all <?php echo ( 'series' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' ); ?>">
            <ul id="blfa-menu-checklist-series" class="categorychecklist form-no-clear">
              <?php
                echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $series_list), 0, (object) array( 'walker' => $walker) );
              ?>
            </ul>
          </div><!-- /.tabs-panel -->

          <div id="tabs-panel-blfa-books" class="tabs-panel tabs-panel-view-all <?php echo ( 'books' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' ); ?>">
      			<ul id="blfa-menu-checklist-books" class="categorychecklist form-no-clear">
              <?php
                echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $books), 0, (object) array( 'walker' => $walker) );
              ?>
      			</ul>
      		</div><!-- /.tabs-panel -->

          <p class="button-controls wp-clearfix">
            <span class="list-controls">
              <a href="<?php echo esc_url( add_query_arg( array( 'blfa-menu-tab' => 'all', 'selectall' => 1, ), remove_query_arg( $removed_args ) )); ?>#blfa-nav-menu" class="select-all"><?php _e('Select All'); ?></a>
            </span>
            <span class="add-to-menu">
              <input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-blfa-menu-item" id="submit-blfa-nav-menu" />
              <span class="spinner"></span>
            </span>
          </p>
        </div><!-- /.categorydiv -->
      <?php
    }
}
