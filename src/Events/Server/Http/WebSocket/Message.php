<?php

namespace SF\Events\Server\Http\WebSocket;

use SF\Events\Server\AbstractServerEvent;

class Message extends AbstractServerEvent
{
    public function on($server)
    {
        $server->on('message', [$this, 'callback']);
    }

    /**
     * @param \Swoole\WebSocket\Server $server
     * @param \Swoole\Http\Request $request
     */
    public function callback($server = null, $request = null)
    {

    }


}