<?php

namespace SF\Database\Drivers;

use SF\Contracts\Database\Connection as ConnectionInterface;
use SF\Contracts\Database\Driver;
use SF\Database\DriverPropertyInfo;
use SF\Database\Pooling\Connection;
use SF\Database\Pooling\Connector;
use SF\Pool\ConnectionPool;

abstract class AbstractDriver implements Driver
{
    /**
     * @var DriverPropertyInfo
     */
    protected $info;

    /**
     * @var ConnectionPool
     */
    protected $pool;

    public function __construct(DriverPropertyInfo $propertyInfo)
    {
        $this->info = $propertyInfo;

        null === $this->info->maxConnections ||
        ($this->pool = new ConnectionPool(new Connector($this), $this->info->maxConnections));

    }

    final public function connect(): ConnectionInterface
    {
        if ($this->pool === null) {
            return $this->createConnection();
        } else {
            return new Connection($this->pool->getConnection());
        }
    }

    abstract public function createConnection(): ConnectionInterface;


}