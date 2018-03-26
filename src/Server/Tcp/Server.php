<?php

namespace SF\Server\Tcp;

use Swoole\Server as SwooleServer;

use SF\Server\AbstractServer;

class Server extends  AbstractServer
{
    public function start()
    {
        $server = new SwooleServer($this->host, $this->port, $this->mode, $this->ssl ? $this->sockType | SWOOLE_SSL : $this->sockType);
        $server->set($this->config->getServer());
        $this->server = $server;
        $this->triggerEvent();
        $server->start();
    }

    public function stop()
    {
    }

    public function reload()
    {
        $this->init();
    }


}