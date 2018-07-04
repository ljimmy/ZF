<?php

namespace SF\Server;

class Connection
{

    /**
     *
     * @var \Swoole\Server
     */
    public $server;

    public $data;

    public $fd;

    public $reactor_id;

    public $keepalive = false;

    private $info = [];

    public function __construct($server, $fd, $reactor_id)
    {
        $this->server = $server;
        $this->fd = $fd;
        $this->reactor_id = $reactor_id;

        $this->info = $server->getClientInfo($fd, $reactor_id);
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function get(string $name)
    {
        return $this->info[$name] ?? null;
    }

    public function close($reset = false)
    {
        $this->server->close($this->fd, $reset);
    }
}
