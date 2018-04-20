<?php

namespace SF\Application\Event;

use Swoole\Server;

class Connect extends AbstractServerEvent
{
    public function getName(): string
    {
        return 'Connect';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server, $fd, $reactorId) {

        };
    }

}
