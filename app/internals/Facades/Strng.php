<?php

namespace Pedestal\PedestalNamespace\Internals\Facades;

use ICanBoogie\Inflector;
use Pedestal\PedestalNamespace\Internals\Config;

class Strng
{
    public static function inflector(): Inflector
    {
        return Inflector::get(Config::get('LANGUAGE'));
    }
}
