<?php

namespace SF\Context;

use SF\Contracts\Context\Context;
use SF\Server\Connection;

class ConnectContext implements Context
{

    /**
     *
     * @var int
     */
    protected $id;
    /**
     *
     * @var Connection
     */
    protected $connection;

    /**
     *
     * @var array
     */
    protected static $connections = [];

    public function __construct(Connection $connection, int $id)
    {
        $this->connection = $connection;
        $this->id         = $id;
    }

    public static function get(int $id)
    {
        return self::$connections[$id] ?? null;
    }

    public function getServerFd()
    {
        return $this->connection->get('server_fd');
    }

    public function getServerPort()
    {
        return $this->connection->get('server_port');
    }

    public function getRemotePort()
    {
        return $this->connection->get('remote_port');
    }

    public function getRemoteIp()
    {
        return $this->connection->get('remote_ip');
    }

    public function setKeepalive(bool $keepalive = false)
    {
        $this->connection->keepalive = $keepalive;
    }

    public function enter()
    {
        self::$connections[$this->id] = $this;
    }

    public function exitContext()
    {
        unset(self::$connections[$this->connection->fd]);

        if (!$this->connection->keepalive) {
            $this->connection->close();
        }
        $this->connection = null;
    }

}
