<?php

namespace SF\Pool;

use SF\Support\PHP;

class PooledConnection
{

    private $connection;

    private $pool;

    public function __construct($connection, ConnectionPool $pool)
    {
        $this->connection = $connection;
        $this->pool = $pool;
    }


    public function close()
    {
        $this->pool->addConnection($this->connection);
        $this->connection = null;
        $this->pool = null;
    }

    public function __call($name, $arguments)
    {
        return PHP::call([$this->connection, $name], $arguments);
    }

    public function __destruct()
    {
        if ($this->connection !== null) {
            $this->close();
        }
    }

}