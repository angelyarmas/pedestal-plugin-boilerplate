<?php
use Pedestal\App\Kernel;

/**
 * Initialize Composer dependencies
 */

if ( file_exists( $composer = plugin_dir_path( __DIR__ ) . '/vendor/autoload.php' ) ) {
  require_once $composer;
}

/**
 * Bootstrap plugin's elements and hooks.
 */
$kernel = new Kernel;
$kernel->run();

