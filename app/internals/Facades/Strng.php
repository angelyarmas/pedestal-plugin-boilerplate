<?php

namespace PedestalNamespace\Internals\Facades;

use ICanBoogie\Inflector;
use PedestalNamespace\Internals\Config;

class Strng
{
    public static function inflector(): Inflector
    {
        return Inflector::get(Config::get('LANGUAGE'));
    }
}
