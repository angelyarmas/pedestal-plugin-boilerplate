<?php

/**
 * Plugin Name:         Pedestal
 * Plugin URI:          https://www.pedestalagency/plugins/
 * Description:         Pedestal boilerplate plugin.
 * Requires at least:   6.1
 * Requires PHP:        7.0
 * Version:             0.1.0
 * Author:              Pedestal
 * License:             GPL-2.0-or-later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:         pedestal-before-after-gallery
 * Domain Path:         /languages
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Add composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// Initialize the plugin.
Pedestal\PedestalNamespace\Internals\Bootstrap::start();
