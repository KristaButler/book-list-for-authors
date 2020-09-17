<?php
/**
 * @package BookListForAuthors
 */
namespace Inc\Util;

use Inc\Util\DatabaseUtil;

class Deactivate {
   public static function deactivate() {
     flush_rewrite_rules();
   }
}
