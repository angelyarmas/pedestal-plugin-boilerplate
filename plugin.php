<?php
/**
 * Plugin Name:     Pedestal
 * Plugin URI:      https://www.pedestalagency/plugins/
 * Description:     Pedestal boilerplate plugin.
 * Author:          Pedestal Agency
 * Author URI:      https://www.pedestalagency/
 * Text Domain:     pedestal
 * Domain Path:     /languages
 * Version:         0.1.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Bootstrap plugin.
 */
require_once plugin_dir_path( __FILE__ ) . 'internals/bootstrap.php';