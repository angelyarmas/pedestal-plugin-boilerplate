<?php

namespace Pedestal\PedestalNamespace\Internals\Facades;

use Pedestal\PedestalNamespace\Internals\Hooks as HooksClass;

/**
 * Facade for the Hooks class.
 */
final class Hooks
{
    public static function add_action($hook, $callback, $priority = 10, $args = 1)
    {
        HooksClass::instance()->add_action($hook, $callback, $priority, $args);
    }

    public static function add_filter($hook, $callback, $priority = 10, $args = 1)
    {
        HooksClass::instance()->add_filter($hook, $callback, $priority, $args);
    }

    public static function run()
    {
        HooksClass::instance()->run();
    }
}
