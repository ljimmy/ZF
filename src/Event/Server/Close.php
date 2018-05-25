<?php

namespace SF\Event\Server;

use Swoole\Server;

class Close extends AbstractServerEvent
{
    public function getName(): string
    {
        return 'Close';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server, $fd, $reactorId) {

        };
    }

}
