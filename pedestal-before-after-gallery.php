<?php

/**
 * Plugin Name:       Before and After Gallery by Pedestal
 * Description:       Advanced before and after gallery by Pedestal.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Pedestal
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pedestal-before-after-gallery
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Add composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// Initialize the plugin.
Pedestal\PedestalBeforeAfterGallery\Internals\Bootstrap::start();
