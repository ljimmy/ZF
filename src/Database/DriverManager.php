<?php

namespace SF\Database;

use SF\Contracts\Database\Driver;
use SF\Exceptions\NullPointerException;

class DriverManager
{
    private static $drivers = [];

    public static function getDrivers()
    {
        return self::$drivers;
    }

    public static function getDriver(string $name): Driver
    {
        if (!isset(self::$drivers[$name])) {
            throw new NullPointerException();
        }
        return self::$drivers[$name];
    }

    public static function getDefaultDriverName()
    {
        if (isset(self::$drivers['default'])) {
            return 'default';
        } else {
            return key(self::$drivers);
        }
    }


    public static function registerDriver(string $name, Driver $driver)
    {
        self::$drivers[$name] = $driver;
    }

    public static function deregisterDriver(string $name): void
    {
        unset(self::$drivers[$name]);
    }
}
