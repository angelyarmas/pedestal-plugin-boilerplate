<?php

namespace PedestalNamespace\Internals;

use Noodlehaus\Config as NoodlehausConfig;

class Config
{
    private static $instance;

    private function __construct()
    {
        // Private constructor to prevent instantiation from outside the class
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            $config = new NoodlehausConfig([]);
            // $config->load(Locator::get_path('app/config/'));
            // $config->load(get_plugin_data(Locator::get_path('my-plugin-boilerplate.php')));

            self::$instance = $config;
        }

        return self::$instance;
    }

    public static function get($key)
    {
        return self::getInstance()->get($key);
    }

    public static function set($key, $value)
    {
        return self::getInstance()->set($key, $value);
    }

    public static function getAll()
    {
        return self::getInstance()->all();
    }
}
