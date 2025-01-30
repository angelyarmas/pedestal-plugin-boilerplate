<?php

/**
 * Plugin Name:         Pedestal Plugin Name
 * Plugin URI:          https://www.pedestalagency/plugins/
 * Description:         Pedestal Plugin description
 * Requires at least:   6.1
 * Requires PHP:        7.0
 * Version:             0.1.0
 * Author:              Author Name
 * License:             GPL-2.0-or-later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:         my-plugin-boilerplate
 * Domain Path:         /languages.
 */

use PedestalNamespace\Internals\Bootstrap;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Add composer autoload
require_once __DIR__.'/vendor/autoload.php';

// Setup activation hooks.
register_activation_hook(__FILE__, [Bootstrap::class, 'activate']);

// Setup deactivation hooks.
register_deactivation_hook(__FILE__, [Bootstrap::class, 'deactivate']);

// Initialize the plugin.
Bootstrap::start();
