<?php

namespace SF\Event\Server;

use Swoole\Server;

class WorkerError extends AbstractServerEvent
{
    public function getName(): string
    {
        return 'WorkerError';
    }

    public function getCallback(): \Closure
    {
        return function (Server $server,int $worker_id = 0, int $worker_pid = 0, int $exit_code = 0, int $signal = 0) {

        };
    }

}
