<?php

namespace SF\Http;

use SF\Server\Application as BaseServer;
use Swoole\Http\Server;

class Application extends BaseServer
{
    protected function createServer()
    {
        return new Server(
            $this->host,
            $this->port,
            $this->mode,
            $this->ssl ? SWOOLE_SOCK_TCP | SWOOLE_SSL : SWOOLE_SOCK_TCP
        );
    }
}