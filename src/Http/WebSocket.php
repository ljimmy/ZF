<?php

namespace SF\Http;

use Swoole\WebSocket\Server;

class WebSocket extends HttpServer
{
    protected function createServer()
    {
        return new Server($this->host, $this->port, $this->mode, $this->ssl ? $this->sockType | SWOOLE_SSL : $this->sockType);
    }
}