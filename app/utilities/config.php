<?php
namespace Pedestal\App\Utilities;

use Noodlehaus\Config as NoodlehausConfig;
use Symfony\Component\Config\FileLocator;

class Config
{
  /**
   * Retrieves the value stored for a config in the config file.
   *
   * @param string $config_path
   * @param mixed $default
   * @return mixed
   */
  public static function get(string $config_path, mixed $default = null): mixed
  {
    $config_directory = Locator::get_path('app/config');
    $config = new NoodlehausConfig($config_directory);

    return $config->get($config_path, $default);
  }
}
?>
