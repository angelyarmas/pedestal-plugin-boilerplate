<?php
namespace Pedestal\App;

use Pedestal\App\Hooks\Assets;
use Pedestal\Internals\Loader;

/**
 * Kernel Class
 *
 * Contains all the Actions, filters, REST endpoints,
 * widgets, shortcodes, blocks from the plugin.
 */
final class Kernel
{
	protected $loader;

  public function __construct()
  {
		$this->loader = new Loader;

    $this->register_admin_hooks();
    $this->register_front_hooks();
    $this->register_rest_routes();
  }

  private function register_front_hooks()
  {
    # code...
  }

  private function register_admin_hooks()
  {
    $assets = new Assets;
    $this->loader->add_action('wp_enqueue_scripts', $assets, 'register_admin_assets');
  }

  private function register_rest_routes()
  {
    # code...
  }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}
}
