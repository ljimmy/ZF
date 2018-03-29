<?php

namespace SF\Events\Server;

class PipeMessage extends AbstractServerEvent
{
    public function callback($server = null, int $src_worker_id = 0, $message = null)
    {

    }

    public function on($server)
    {
        $server->on('PipeMessage', [$this, 'callback']);
    }

}
