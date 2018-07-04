<?php

namespace SF\Event\Server;

use Swoole\Server;

class Task extends AbstractServerEvent
{

    public function getName(): string
    {
        return 'Task';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server, int $task_id, int $src_worker_id, $data) {

        };
    }

}
