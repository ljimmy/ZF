<?php

namespace SF\Database;

use SF\Contracts\IoC\Object;

class DatabaseServiceProvider implements Object
{

    /**
     *
     * @var string
     */
    public $drivers = [];

    /**
     * @var array
     */
    public $tables = [];


    public function init()
    {
        $this->registerTable($this->tables);
        $this->registerDriver($this->drivers);
    }

    protected function registerTable(array $tables)
    {
        foreach ($tables as $name => $table) {
            Table::add(
                $name,
                $table['columns'] ?? [],
                $table['sql'] ?? []
            );
        }

    }


    protected function registerDriver(array $drivers)
    {
        foreach ($drivers as $name => $driver) {
            DriverManager::registerDriver($name, DriverFactory::getDriver(new DriverPropertyInfo(
                $driver['dsn'] ?? '',
                $driver['username'] ?? null,
                $driver['password'] ?? null,
                $driver['max_connections'] ?? null,
                $driver['options'] ?? []
            )));
        }
    }


    public function __destruct()
    {
        Table::destroy();
        DriverManager::clearDriver();
    }

}
