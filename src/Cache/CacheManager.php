<?php

namespace SF\Cache;

use SF\Contracts\Cache\Repository as RepositoryInterface;

class CacheManager
{
    const DEFAULT_NAME = 'default';

    private static $drivers = [];

    public static function getDrivers()
    {
        return self::$drivers;
    }

    public static function getDriver(string $name): RepositoryInterface
    {
        if (!isset(self::$drivers[$name])) {
            throw new NullPointerException();
        }
        return self::$drivers[$name];
    }

    public static function getDefaultDriverName()
    {
        if (isset(self::$drivers[self::DEFAULT_NAME])) {
            return self::DEFAULT_NAME;
        } else {
            return key(self::$drivers);
        }
    }


    public static function registerDriver(string $name, RepositoryInterface $driver)
    {
        self::$drivers[$name] = $driver;
    }

    public static function deregisterDriver(string $name): void
    {
        unset(self::$drivers[$name]);
    }

    public static function clearDriver()
    {
        self::$drivers = [];
    }

}