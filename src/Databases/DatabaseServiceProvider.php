<?php

namespace SF\Databases;

use SF\Contracts\IoC\Object;
use SF\IoC\Container;
use SF\Pool\PoolInterface;
use SF\Exceptions\UserException;

class DatabaseServiceProvider implements Object
{

    const DATABASE_CONNECTOR = 'database_connector';
    
    const DATABASE_CONNECTOR_POOL = 'database_connector_pool';

    /**
     * @var array
     */
    public $connector;

    /**
     * @var array
     */
    public $pool;

    /**
     * @var array
     */
    public $tables;

    /**
     * @var array
     */
    public $sqlMap;

    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function init()
    {
        if ($this->connector) {
            $this->container->setDefinition((array) $this->connector, self::DATABASE_CONNECTOR);
        }
        if ($this->pool) {
            $this->container->setDefinition((array) $this->pool, self::DATABASE_CONNECTOR_POOL);
        }

        if ($this->tables) {
            foreach ((array) $this->tables as $table => $config) {
                Table::add($table, $config['columns'] ?? [], $config['sql'] ?? []);
            }
        }

        if ($this->sqlMap) {
            SqlMap::$map  = $this->sqlMap;
            $this->sqlMap = null;
        }
    }

    /**
     * @return ConnectorInterface
     * @throws UserException
     */
    public function getConnector(): ConnectorInterface
    {
        if ($this->connector === null) {
            throw new UserException('database connector is not set.');
        }
        return $this->container->get(self::DATABASE_CONNECTOR);
    }

    /**
     * @return PoolInterface
     * @throws UserException
     */
    public function getPool(): PoolInterface
    {
        if ($this->pool === null) {
            throw new UserException('database connect pool is not set.');
        } else {
            return $this->container->get(self::DATABASE_CONNECTOR_POOL);
        }
    }

    public function __destruct()
    {
        Table::destroy();
    }

}
