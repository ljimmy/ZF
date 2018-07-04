<?php

namespace SF\Database\Pooling;

use SF\Contracts\Pool\Connector as ConnectorInterface;
use SF\Contracts\Database\Driver;

class Connector implements ConnectorInterface
{

    protected $driver;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    public function connect()
    {
        return $this->driver->connect();
    }

}
