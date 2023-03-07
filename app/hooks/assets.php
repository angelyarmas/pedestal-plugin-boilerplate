<?php
namespace Pedestal\App\Hooks;

use Pedestal\App\Utilities\Config;
use Pedestal\App\Utilities\Locator;

final class Assets
{
  public function register_admin_assets()
  {
    wp_enqueue_style('pedestal-admin', Locator::get_url('assets/internal/admin.css'), [], Config::get('version'), 'all');
  }
}
