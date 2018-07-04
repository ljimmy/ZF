<?php

namespace SF\Event\Server;

use Swoole\Server;

class Finish extends AbstractServerEvent
{

    public function getName(): string
    {
        return 'Finish';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server, int $task_id, $data) {

        };
    }

}
