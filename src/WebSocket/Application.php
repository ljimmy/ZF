<?php

namespace SF\WebSocket;

use SF\Http\Application as Http;
use Swoole\WebSocket\Server;

class Application extends Http
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