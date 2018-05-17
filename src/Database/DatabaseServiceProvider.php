<?php

namespace SF\Database;

use SF\Contracts\IoC\Object;
use SF\IoC\Container;
use SF\Contracts\Database\Connection as ConnectionInterface;
use SF\Exceptions\UserException;

class DatabaseServiceProvider implements Object
{

    /**
     *
     * @var string
     */
    public $drivers = [];

    /**
     *
     * @var array
     */
    public $config;

    /**
     * @var array
     */
    public $tables;

    /**
     *
     * @var bool
     */
    public $enableConnectionPooling = true;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function init()
    {
        if ($this->tables) {
            foreach ((array)$this->tables as $table => $config) {
                Table::add($table, $config['columns'] ?? [], $config['sql'] ?? []);
            }
        }

        if ($this->drivers) {
            $this->registerDriver((array)$this->drivers);
        }

        $this->registerConnectionServices($this->enableConnectionPooling);


    }


    protected function registerConnectionServices(array $drivers)
    {
        foreach ($drivers as $name => $driver) {
            DriverManager::registerDriver(DriverFactory::getDriver(new DriverPropertyInfo(
                $driver['dsn'] ?? '',
                $driver['username'] ?? null,
                $driver['password'] ?? null,
                $driver['max_connections'] ?? null,
                $driver['options'] ?? []
            )));
        }
    }

    public function getDatabaseManager(): DatabaseManager
    {
        return $this->databaseManager;
    }


    public function __destruct()
    {
        Table::destroy();
    }

}
