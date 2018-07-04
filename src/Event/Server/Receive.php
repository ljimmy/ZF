<?php

namespace SF\Event\Server;

use Swoole\Server;

class Receive extends AbstractServerEvent
{

    public function getName(): string
    {
        return 'Receive';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server, $fd, $reactor_id, $data) {
            $server->send($fd, 'not implemented');
            $server->close($fd);
        };
    }

}
