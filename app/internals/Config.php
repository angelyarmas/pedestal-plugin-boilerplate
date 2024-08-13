<?php

namespace Pedestal\PedestalNamespace\Internals;

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
        if (self::$instance === null) {
            self::$instance = new NoodlehausConfig(Locator::get_path('app/config/'));
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
