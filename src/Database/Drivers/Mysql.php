<?php

namespace SF\Database\Drivers;

use SF\Contracts\Database\Connection as ConnectionInterface;
use SF\Database\Connection\MysqlConnection;

class Mysql extends  AbstractDriver
{

    const NAME = 'mysql';

    public function createConnection(): ConnectionInterface
    {
        return new MysqlConnection($this->info);
    }


}
