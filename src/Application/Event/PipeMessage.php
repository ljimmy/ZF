<?php

namespace SF\Application\Event;

use Swoole\Server;

class PipeMessage extends AbstractServerEvent
{
    public function getName(): string
    {
        return 'PipeMessage';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server, int $src_worker_id, $message) {

        };

    }

}
