<?php

namespace SF\Http;

use SF\Protocol\Http\Protocol;
use SF\Protocol\ProtocolServiceProvider;
use SF\Server\Application as BaseServer;
use Swoole\Http\Server;

class Application extends BaseServer
{

    protected function createServer()
    {
        if (!$this->container->has(ProtocolServiceProvider::class)) {
            $this->container->setDefinition(
                [
                    'class'    => ProtocolServiceProvider::class,
                    'protocol' => Protocol::class
                ]
            );
        }

        return new Server(
            $this->host,
            $this->port,
            $this->mode,
            $this->ssl ? SWOOLE_SOCK_TCP | SWOOLE_SSL : SWOOLE_SOCK_TCP
        );
    }
}