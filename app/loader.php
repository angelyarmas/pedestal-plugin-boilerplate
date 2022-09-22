<?php
namespace Pedestal\App;

/**
 * Loader Class
 *
 * Contains all the Actions, filters, REST endpoints,
 * widgets, shortcodes, blocks from the plugin.
 */
final class Loader
{
  public function __construct()
  {
    $this->register_admin_hooks();
    $this->register_public_hooks();
    $this->register_rest_routes();
  }

  private function register_front_hooks()
  {
    # code...
  }

  private function register_admin_hooks()
  {
    # code...
  }

  private function register_rest_routes()
  {
    # code...
  }
}
