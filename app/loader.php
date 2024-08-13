<?php

use Pedestal\PedestalBeforeAfterGallery\Hooks\Assets;
use Pedestal\PedestalBeforeAfterGallery\Internals\Facades\Hooks;

/**
 * Register all basic actions and filters for the plugin.
 */
Hooks::add_action('init', [Assets::class, 'register_plugin_assets'], 10, 2);
Hooks::add_action('wp_enqueue_scripts', [Assets::class, 'load_plugin_front_assets'], 10, 2);
Hooks::add_action('admin_enqueue_scripts', [Assets::class, 'load_plugin_admin_assets'], 10, 2);
