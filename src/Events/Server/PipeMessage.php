<?php

namespace SF\Events\Server;

class PipeMessage extends AbstractServerEvent
{

    const EVENT_NAME = 'PipeMessage';

    public function callback($server = null, int $src_worker_id = 0, $message = null)
    {

    }

    public function on($server)
    {
        $server->on('PipeMessage', [$this, 'callback']);
    }

}
