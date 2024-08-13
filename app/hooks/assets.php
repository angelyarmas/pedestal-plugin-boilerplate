<?php

namespace Pedestal\PedestalBeforeAfterGallery\Hooks;

use Pedestal\PedestalBeforeAfterGallery\Internals\Config;
use Pedestal\PedestalBeforeAfterGallery\Internals\Locator;

class Assets
{
    /**
     * Register all the assets for the plugin.
     *
     * @return  void
     */
    public static function register_plugin_assets(): void
    {
        // Register the plugin's scripts and styles.
        wp_register_script('pedestal-before-after-gallery-admin', Locator::get_url('assets/internal/admin.js'), array('jquery'), Config::get('PLUGIN_VERSION'), true);
        wp_register_style('pedestal-before-after-gallery-admin', Locator::get_url('assets/internal/admin.css'), array(), Config::get('PLUGIN_VERSION'));

        // Register the plugin's scripts and styles.
        wp_register_script('pedestal-before-after-gallery-front', Locator::get_url('assets/internal/front.js'), array('jquery'), Config::get('PLUGIN_VERSION'), true);
        wp_register_style('pedestal-before-after-gallery-front', Locator::get_url('assets/internal/front.css'), array(), Config::get('PLUGIN_VERSION'));
    }

    /**
     * Load the plugin's front-end assets.
     *
     * @return  void
     */
    public static function load_plugin_front_assets(): void 
    {
        // Load the plugin's front-end assets.
        wp_enqueue_script('pedestal-before-after-gallery-front');
        wp_enqueue_style('pedestal-before-after-gallery-front');
    }
    
    /**
     * Load the plugin's admin assets.
     *
     * @return  void
     */
    public static function load_plugin_admin_assets(): void
    {
        // Load the plugin's admin assets.
        wp_enqueue_script('pedestal-before-after-gallery-admin');
        wp_enqueue_style('pedestal-before-after-gallery-admin');
    }
}
