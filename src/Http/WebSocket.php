<?php

namespace SF\Http;

use Swoole\WebSocket\Server;

class WebSocket extends HttpServer
{
    public function start()
    {
        $server = new Server($this->host, $this->port, $this->mode, $this->ssl ? $this->sockType | SWOOLE_SSL : $this->sockType);
        $server->set($this->config->getServer());
        $this->bootstrap($server);
        $server->start();
    }
}