<?php
/**
 * @package BookListForAuthors
 */
namespace Inc;

final class Init {
  public static function get_services() {
    return [
      Pages\Admin::class,
      Util\SettingsLink::class,
      Util\Enqueue::class,
      Util\ImageSizes::class,
      Util\RewriteRules::class,
      Util\CustomMenu::class
    ];
  }

  public static function register_services() {
    foreach ( self::get_services() as $class) {
      $service = self::instantiate($class);
      if( method_exists( $service, 'register')) {
        $service->register();
      }
    }
  }

  private static function instantiate($class) {
    return new $class();
  }
}
