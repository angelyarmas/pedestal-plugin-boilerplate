<?php

namespace PedestalNamespace\Internals;

use HaydenPierce\ClassFinder\ClassFinder;
use PedestalNamespace\Internals\Facades\Hooks;

/**
 * Initialize all the plugins' hooks and filters.
 */
class Bootstrap
{
    public static function start()
    {
        // Initialize the plugin hooks and filters.
        require_once Locator::get_path('app/Loader.php');

        // Register Models for post types and taxonomies.
        $models = ClassFinder::getClassesInNamespace('PedestalNamespace\Models');
        foreach ($models as $model) {
            if (method_exists($model, 'register')) {
                Hooks::add_action('init', [new $model(), 'register'], 10, 1);
            }
        }

        // Register the plugin's routes.
        $routes = ClassFinder::getClassesInNamespace('PedestalNamespace\Routes');
        foreach ($routes as $route) {
            if (method_exists($route, 'register')) {
                Hooks::add_action('rest_api_init', [new $route(), 'register'], 10, 1);
            }
        }

        // Register the plugin's gutenberg blocks.
        Hooks::add_action('init', [self::class, 'register_plugin_gutenberg_blocks'], 10, 1);

        // Run the plugin.
        Hooks::run();
    }

    /**
     * Callback function to register the plugin's gutenberg blocks.
     *
     * @return void
     */
    public static function register_plugin_gutenberg_blocks()
    {
        // Register the plugin's gutenberg blocks.
        $block_folders = Locator::get_dir_list('assets/build');

        foreach ($block_folders as $block_folder) {
            $block_path = Locator::get_path('assets/build/'.$block_folder);

            if (file_exists($block_path.'/index.js')) {
                register_block_type($block_path);
            }
        }
    }

    /**
     * Callback function to run on plugin activation.
     *
     * @return void
     */
    public static function activate()
    {
        // Code to run on plugin activation.
    }

    /**
     * Callback function to run on plugin deactivation.
     *
     * @return void
     */
    public static function deactivate()
    {
        // Code to run on plugin deactivation.
    }
}
