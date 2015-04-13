<?php

namespace Helpers;

class Registry
{
    /**
     * @var Filesystem
     */
    private static $registry = [];

    /**
     * @param string $key
     * @param mixed  $value
     */
    public static function set($key, $value)
    {
        self::$registry[$key] = $value;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public static function get($key)
    {
        if (isset(self::$registry[$key])) {
            return self::$registry[$key];
        }
    }
}
