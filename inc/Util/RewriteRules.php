<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Util;

use Inc\Util\BaseController;
use Inc\Util\DatabaseUtil;

/**
 *
 */
class RewriteRules extends BaseController {

  public function register() {
    add_action('init', array($this, 'addRewriteRules'));
    add_filter('query_vars', array($this, 'addQueryVars'));
    add_filter('template_include', array($this, 'includeTemplate'));
    add_filter('wp_title', array($this, 'customPageTitle'));
  }

  public function addRewriteRules() {
    add_rewrite_rule(
        '^books/([a-zA-Z\d\-]+)/([a-zA-Z\d\-]+)/?$',
        'index.php?blfa_series=$matches[1]&blfa_book=$matches[2]',
        'top'
    );

    add_rewrite_rule(
        '^books/([a-zA-Z\d\-]+)/?$',
        'index.php?blfa_series=$matches[1]',
        'top'
    );

    add_rewrite_rule(
        '^books/?$',
        'index.php?blfa_books=all',
        'top'
    );

    flush_rewrite_rules();
  }

  public function addQueryVars($query_vars) {
    $query_vars[] = 'blfa_book';
    $query_vars[] = 'blfa_series';
    $query_vars[] = 'blfa_books';

    return $query_vars;
  }

  public function customPageTitle($title) {
    $new_title = $title;
    $book = get_query_var( 'blfa_book' );
    $series = get_query_var ('blfa_series');

    if (is_page_template('blfa_book_page.php')) {
      $new_title = "Book";

      if($book) {
        $book_info = findBook($book);

        if ($book_info) {
          $new_title = $book_info->title;
        }
      }
    } else if (is_page_template('blfa_series_page.php')) {
      $new_title = "Series";

      if($series) {
        $series_info = findSeries($series, get_option('blfa_plugin_series'));

        if($series_info) {
          $new_title = $series_info['blfa_series_title'];
        }
      }
    } else if (is_page_template('blfa_all_books.php') || is_page_template('blfa_book_links.php')) {
      $new_title = "Books";
    }

    return $new_title;
  }

  function findSeries($slug, $list) {
    $series = null;
    foreach ($list as $id => $value) {
      if ($value['blfa_series_slug'] == $slug) {
        $series = $value;
      }
    }

   return $series;
  }

  function findBook($slug) {
    $dbUtil = new DatabaseUtil();

    return $dbUtil->getBookBySlug($slug);
  }

  public function isBook($slug) {
    $is_book = true;
    $dbUtil = new DatabaseUtil();

    if ($dbUtil->getBookBySlug($slug) == null) {
      $is_book = false;
    }

    return $is_book;
  }

  public function getSeries($slug) {
    $book = $dbUtil->getBookBySlug($slug);
    $series_list = get_option('blfa_plugin_series');

    $series = $series_list[$book->series];

    return $series['blfa_series_slug'];
  }

  public function includeTemplate($original_template) {
    $books = get_query_var( 'blfa_books' );
    $book = get_query_var( 'blfa_book' );
    $series = get_query_var ('blfa_series');
    $options = get_option('blfa_plugin_settings');
    $template = $original_template;
    $redirect_book = plugin_dir_path( dirname( __FILE__, 2 ) ) . 'assets/templates/pages/blfa_book_page.php';
    $redirect_series = plugin_dir_path( dirname( __FILE__, 2 ) ) . 'assets/templates/pages/blfa_series_page.php';
    $redirect_all = plugin_dir_path( dirname( __FILE__, 2 ) ) . 'assets/templates/pages/blfa_all_books.php';
    $redirect_links = plugin_dir_path( dirname( __FILE__, 2 ) ) . 'assets/templates/pages/blfa_book_links.php';

    if ($book) {
      if($options['blfa_bookpage_include_page']) {
        $template = $redirect_book;
      } else if ($options['blfa_seriespage_include_page'] && $series) {
        $template = $redirect_series;
      } else if ($options['blfa_allbooks_include_page']) {
        $template = $redirect_all;
      } else {
        $template = $redirect_links;
      }
    } else if ($this->isBook($series)) {
      if($options['blfa_bookpage_include_page']) {
        set_query_var('blfa_book', $series);
        $template = $redirect_book;
      } else if ($options['blfa_seriespage_include_page']) {
        $series = $this->getSeries($slug);
        if ($series) {
          set_query_var('blfa_series', $series);
          $template = $redirect_series;
        }
      } else if ($options['blfa_allbooks_include_page']) {
        $template = $redirect_all;
      } else {
        $template = $redirect_links;
      }
    } else if ($series) {
      if ($options['blfa_seriespage_include_page']) {
        $template = $redirect_series;
      } else if ($options['blfa_allbooks_include_page']) {
        $template = $redirect_all;
      } else {
        $template = $redirect_links;
      }
    } else if ($books === 'all') {
      if ($options['blfa_allbooks_include_page']) {
        $template = $redirect_all;
      } else {
        $template = $redirect_links;
      }
    }

    return $template;
  }
}
