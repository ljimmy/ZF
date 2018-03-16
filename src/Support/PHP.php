<?php

namespace SF\Support;

use SF\Coroutine\Coroutine;

class PHP
{

    public static function call($callback, array $params = [])
    {
        return Coroutine::call_user_func_array($callback, $params);
    }

    public static function isMacOS()
    {
        return stripos(PHP_OS, 'Darwin') !== false;
    }

    public static function isCli()
    {
        return PHP_SAPI === 'cli';;
    }

    public static function getBasePath()
    {
        if (defined('ROOT_DIR')) {
            $dir =  ROOT_DIR;
        } else {
            $dir = realpath(__DIR__ . '/../..');
        }

        return rtrim($dir, DIRECTORY_SEPARATOR);
    }

}
