<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Util;

class DatabaseUtil extends BaseController {
  private $books_table;

  public function __construct() {
    global $wpdb;

    $this->books_table = $wpdb->prefix . "blfa_books";
  }

  public function addTables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    if ($wpdb->get_var('SHOW TABLES LIKE "' . $this->books_table . '"') != $this->books_table) {

      $sql = "CREATE TABLE $this->books_table (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          title tinytext NOT NULL,
          subtitle tinytext,
          description text,
          book_order mediumint(9) DEFAULT -1 NOT NULL,
          publication_date DATE,
          author tinytext,
          author_url longtext DEFAULT '' NOT NULL,
          series tinytext,
          cover varchar(55) DEFAULT '' NOT NULL,
          hide TINYINT(1) DEFAULT 0 NOT NULL,
          book_links TEXT,
          slug tinytext NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";

      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
     	dbDelta( $sql );
    }
  }

  public function addBook($record) {
    global $wpdb;

    //do just a little check for security purposes
    wp_verify_nonce( 'blfa_cu_book_nonce', 'blfa_cu_book' );

    //Add generated slug to the record
    $record = array_merge(['slug' => $this->getSlug($record['title'])], $record);

    $success = $wpdb->insert($this->books_table, $record);

    return $success;
  }

  public function updateBook($id, $record) {
    global $wpdb;

    //do just a little check for security purposes
    wp_verify_nonce( 'blfa_cu_book_nonce', 'blfa_cu_book' );

    $title = $record['title'];
    $subtitle = $record['subtitle'];
    $description = $record['description'];
    $book_order = $record['book_order'];
    $publication_date = $record['publication_date'];
    $author = $record['author'];
    $author_url = $record['author_url'];
    $series = $record['series'];
    $cover = $record['cover'];
    $hide = $record['hide'];
    $book_links = $record['book_links'];

    //Generate the slug again incase the title has changed
    $slug = $this->getSlug($title);

    $query = $wpdb->prepare("UPDATE $this->books_table
                SET title = %s,
                subtitle = %s,
                description = %s,
                book_order = %d,
                publication_date = %s,
                author = %s,
                author_url = %s,
                series = %s,
                cover = %s,
                hide = %s,
                book_links = %s,
                slug = %s
             WHERE id = %s", $title, $subtitle, $description, (int) $book_order, $publication_date, $author, $author_url, $series, $cover, $hide, maybe_serialize($book_links), $slug, $id);

    $success = $wpdb->query($query);

    return $success;
  }

  public function deleteBook($id) {
    global $wpdb;

    //do just a little check for security purposes
    wp_verify_nonce( 'blfa_cu_book_nonce', 'blfa_cu_book' );
    $success = $wpdb->delete( $this->books_table, array( 'id' => $id ) );

    return $success;
  }

  public function getBook($id) {
    $book = array();

    global $wpdb;

    //do just a little check for security purposes
    wp_verify_nonce( 'blfa_cu_book_nonce', 'blfa_cu_book' );
    $book = $wpdb->get_results( "SELECT *  FROM $this->books_table WHERE id = $id");

    return $book;
  }

  public function getBookBySlug($slug) {
    $book = array();

    global $wpdb;

    //do just a little check for security purposes
    wp_verify_nonce( 'blfa_cu_book_nonce', 'blfa_cu_book' );
    $book = $wpdb->get_results( "SELECT * FROM $this->books_table WHERE slug = '$slug'" );

    return $book;
  }

  public function getSeriesBooks($series) {
    global $wpdb;

    return $wpdb->get_results( "SELECT id, title, subtitle, description, book_order, DATE_FORMAT(publication_date, '%m/%d/%y') as publication_date, author, author_url, series, cover, hide, book_links, slug FROM $this->books_table WHERE series = '$series' AND NOT hide" );
  }

  public function getStandAloneBooks() {
    global $wpdb;

    return $wpdb->get_results( "SELECT id, title, subtitle, description, book_order, DATE_FORMAT(publication_date, '%m/%d/%y') as publication_date, author, author_url, cover, hide, book_links, slug FROM $this->books_table WHERE (series IS NULL OR series = '') AND NOT hide" );
  }

  public function getAllBooks() {
    global $wpdb;

    return $wpdb->get_results( "SELECT id, title, subtitle, description, book_order, DATE_FORMAT(publication_date, '%m/%d/%y') as publication_date, author, author_url, series, cover, hide, book_links, slug FROM $this->books_table ORDER BY id DESC" );
  }

  public function getFeaturedBook($series, $select_by, $filter_on_author, $author_name) {
    global $wpdb;
    $sql = "SELECT id, title, subtitle, description, book_order, DATE_FORMAT(publication_date, '%m/%d/%y') as publication_date, author, author_url, series, cover, hide, book_links, slug FROM $this->books_table WHERE series = '$series' AND NOT hide";

    if ($filter_on_author) {
      $sql = $sql . " AND author = '$author_name'";
    }

    if ($select_by == 'first') {
      $sql = $sql . " ORDER BY book_order ASC";
    } else if ($select_by == 'recent') {
      $sql = $sql . " ORDER BY publication_date DESC";
    }

    return $wpdb->get_results($sql);
  }
}
