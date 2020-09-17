<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Api\Callbacks;

use Inc\Util\BaseController;

class AdminCallbacks extends BaseController {
  public function bookListSettings() {
    return require_once("$this->plugin_path/assets/templates/admin.php");
  }

  public function bookListBooks() {
    return require_once("$this->plugin_path/assets/templates/books-admin.php");
  }

  public function bookListAddEditBook() {
     return require_once("$this->plugin_path/assets/parts/add-edit-book.php");
  }

  public function bookListSeries() {
    return require_once("$this->plugin_path/assets/templates/series-admin.php");
  }

  public function bookListRetailers() {
    return require_once("$this->plugin_path/assets/templates/retailers-admin.php");
  }

  public function allBooksOptionsSection() {
    return require_once("$this->plugin_path/assets/parts/all-books-section.php");
  }

  public function seriesPageOptionsSection() {
      return require_once("$this->plugin_path/assets/parts/series-page-section.php");
  }

  public function bookPageOptionsSection() {
     return require_once("$this->plugin_path/assets/parts/book-page-section.php");
  }
}
