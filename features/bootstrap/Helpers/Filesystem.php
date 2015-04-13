<?php

namespace Helpers;

use Symfony\Component\Filesystem\Filesystem as sfFilesystem;

class Filesystem
{
    /**
     * @var sfFilesystem
     */
    private static $filesystem;

    /**
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public static function __callStatic($method, $args = [])
    {
        if (!self::$filesystem instanceof Filesystem) {
            self::$filesystem = new sfFilesystem();
        }

        return call_user_func_array(array(self::$filesystem, $method), $args);
    }
}
