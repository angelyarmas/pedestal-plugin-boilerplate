<?php
namespace Pedestal\App\Utilities;

/**
 * Class to obtain the correct paths and URLs to
 * files in your plugin folder.
 */
class Locator
{
  /**
   * helper of the plugins_url() WordPress method.
   * Pointing to URLs within your plugin folder.
   *
   * @param string $file_location
   * @return string
   */
  public static function get_url(string $file_location = null)
  {
    return plugins_url($file_location, dirname(__DIR__));
  }

  /**
   * Helper of the plugins_dir_path() WordPress method.
   * Pointing to files within your plugin folder.
   *
   * @param string $file_location
   * @return string
   */
  public static function get_path(string $file_location = null)
  {
    return trailingslashit(plugin_dir_path( DIRNAME(__DIR__) )) . $file_location;
  }
}
