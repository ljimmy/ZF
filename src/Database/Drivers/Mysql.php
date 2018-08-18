<?php

namespace SF\Database\Drivers;

use SF\Database\Connection\Swoole\MysqlConnection;
use SF\Contracts\Database\Connection as ConnectionInterface;

class Mysql extends  AbstractDriver
{

    const NAME = 'mysql';

    public function createConnection(): ConnectionInterface
    {
        return new MysqlConnection($this->info);
    }


}
