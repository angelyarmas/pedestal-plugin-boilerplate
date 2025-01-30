<?php

namespace PedestalNamespace\Internals;

class Locator
{
    /**
     * helper of the plugins_url() WordPress method.
     * Pointing to URLs within your plugin folder.
     *
     * @return string
     */
    public static function get_url(?string $file_location = null)
    {
        return plugins_url($file_location, dirname(__DIR__));
    }

    /**
     * Helper of the plugins_dir_path() WordPress method.
     * Pointing to files within your plugin folder.
     *
     * @return string
     */
    public static function get_path(?string $file_location = null)
    {
        return trailingslashit(plugin_dir_path(dirname(__DIR__))).$file_location;
    }

    public static function get_dir_list(?string $parent_dir = null)
    {
        $full_parent_path = self::get_path($parent_dir);

        $dir_list = scandir($full_parent_path);

        return array_diff($dir_list, ['.', '..']);
    }
}
