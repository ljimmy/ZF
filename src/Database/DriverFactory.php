<?php

namespace SF\Database;


use SF\Contracts\Database\Driver;
use SF\Database\Drivers\Mysql;
use SF\Exceptions\NotSupportedException;

class DriverFactory
{
    public static function getDriver(DriverPropertyInfo $info): Driver
    {
        switch ($info->driver) {
            case Mysql::NAME:
                return new Mysql($info);
            default:
                throw new NotSupportedException('invalid data source name');
        }
    }

}
