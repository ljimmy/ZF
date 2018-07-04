<?php

namespace SF\Database;

use SF\Contracts\Database\Connection;
use SF\Contracts\Database\Driver;

trait ConnectionTrait
{

    public static function getConnection(string $name = null): Connection
    {
        return self::getDriver($name)->connect();
    }

    public static function getDriver(string $name = null): Driver
    {
        if ($name === null) {
            $name = DriverManager::getDefaultDriverName();
        }
        return DriverManager::getDriver($name);
    }
}