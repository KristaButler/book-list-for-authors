<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Util;

/**
 *
 */
class ImageSizes extends BaseController {
  public function register() {
    add_action('after_setup_theme', array($this, 'addImageSizes'));
  }

  public function addImageSizes() {
    add_image_size('blfa-retailer-icon', 150, 150, false);
    add_image_size('blfa-cover-exlarge', 333, 500, false);
    add_image_size('blfa-cover-large', 266, 400, false);
    add_image_size('blfa-cover-medium', 200, 300, false);
    add_image_size('blfa-cover-small', 134, 200, false);
    add_image_size('blfa-cover-thumbnail', 33, 50, false);
  }
}
