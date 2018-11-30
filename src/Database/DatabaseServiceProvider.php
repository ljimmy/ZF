<?php

namespace SF\Database;

use SF\Contracts\IoC\Instance;

class DatabaseServiceProvider implements Instance
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
                $driver['min_connections'] ?? 0,
                $driver['max_connections'] ?? 0,
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
