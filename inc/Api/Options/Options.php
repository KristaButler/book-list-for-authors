<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Api\Options;

use \Inc\Util\BaseController;
use \Inc\Api\Callbacks\AdminPrinter;
use \Inc\Api\Callbacks\AdminSanitizer;
use \Inc\Api\Callbacks\AdminCallbacks;

/**
 *
 */
class Options extends BaseController {
  protected $printer;
  protected $sanitizer;
  protected $callbacks;

  public function __construct() {
    parent::__construct();
    $this->printer = new AdminPrinter();
    $this->sanitizer = new AdminSanitizer();
    $this->callbacks = new AdminCallbacks();
  }

  public function prepare($settings) {
    if (! is_null($settings)) {
      $settings->addSettings($this->getSettings());
      $settings->addSections($this->getSections());
      $settings->addFields($this->getFields());
    }

    return $settings;
  }

  protected function getSettings() {
    //Must be extended
    return array();
  }

  protected function getSections() {
    //Must be extended
    return array();
  }

  protected function getFields() {
    //Must be extended
    return array();
  }
}
