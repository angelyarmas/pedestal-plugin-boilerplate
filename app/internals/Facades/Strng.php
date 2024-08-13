<?php

namespace Pedestal\PedestalBeforeAfterGallery\Internals\Facades;

use ICanBoogie\Inflector;
use Pedestal\PedestalBeforeAfterGallery\Internals\Config;

class Strng
{
    public static function inflector(): Inflector
    {
        return Inflector::get(Config::get('LANGUAGE'));
    }
}
