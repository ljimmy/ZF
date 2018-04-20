<?php

namespace SF\Http;

use SF\Application\Application as BaseServer;
use Swoole\Http\Server;

class Application extends BaseServer
{
    protected function createServer()
    {
        return new Server(
            $this->host,
            $this->port,
            SWOOLE_PROCESS,
            $this->type
        );
    }
}