<?php

namespace PedestalNamespace\Internals;

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @author     Ángel Yarmas <ayarmas@surgeonsadvisor.com>
 */
class Hooks
{
    private static $instances = [];
    private $actions = [];
    private $filters = [];
    private $shortcodes = [];

    /**
     * Main Hooks Instance.
     *
     * Ensures only one instance of Hooks is loaded or can be loaded.
     *
     * @return hooks - Main instance
     */
    public static function instance()
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @since    1.0.0
     *
     * @param string $hook          the name of the WordPress action that is being registered
     * @param string $callback      the name of the function definition on the $component
     * @param int    $priority      Optional. he priority at which the function should be fired. Default is 10.
     * @param int    $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    public function add_action($hook, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actions = $this->add($this->actions, $hook, $callback, $priority, $accepted_args);
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @since    1.0.0
     *
     * @param string $hook          the name of the WordPress filter that is being registered
     * @param string $callback      the name of the function definition on the $component
     * @param int    $priority      Optional. he priority at which the function should be fired. Default is 10.
     * @param int    $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1
     */
    public function add_filter($hook, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->filters = $this->add($this->filters, $hook, $callback, $priority, $accepted_args);
    }

    /**
     * Add a new shortcode to the collection to be registered with WordPress.
     *
     * @since    1.0.0
     *
     * @param string $hook          the name of the WordPress shortcode that is being registered
     * @param string $callback      the name of the function definition on the $component
     * @param int    $priority      Optional. he priority at which the function should be fired. Default is 10.
     * @param int    $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1
     */
    public function add_shortcode($hook, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->shortcodes = $this->add($this->shortcodes, $hook, $callback, $priority, $accepted_args);
    }

    /**
     * A utility function that is used to register the actions and hooks into a single
     * collection.
     *
     * @since    1.0.0
     *
     * @param array  $hooks         the collection of hooks that is being registered (that is, actions or filters)
     * @param string $hook          the name of the WordPress filter that is being registered
     * @param string $callback      the name of the function definition on the $component
     * @param int    $priority      the priority at which the function should be fired
     * @param int    $accepted_args the number of arguments that should be passed to the $callback
     *
     * @return array the collection of actions and filters registered with WordPress
     */
    private function add($hooks, $hook, $callback, $priority, $accepted_args)
    {
        $hooks[] = [
            'hook' => $hook,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $accepted_args,
        ];

        return $hooks;
    }

    /**
     * Register the filters and actions with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        foreach ($this->filters as $hook) {
            add_filter($hook['hook'], $hook['callback'], $hook['priority'], $hook['accepted_args']);
        }

        foreach ($this->actions as $hook) {
            add_action($hook['hook'], $hook['callback'], $hook['priority'], $hook['accepted_args']);
        }

        foreach ($this->shortcodes as $hook) {
            add_shortcode($hook['hook'], $hook['callback']);
        }
    }
}
