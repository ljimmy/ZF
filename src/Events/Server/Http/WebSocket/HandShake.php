<?php

namespace SF\Events\Server\Http\WebSocket;

use SF\Events\Server\AbstractServerEvent;

class HandShake extends AbstractServerEvent
{
    public function on($server)
    {
        $server->on('handshake', [$this, 'callback']);
    }

    /**
     * @param \Swoole\Http\Request $request
     * @param \Swoole\Http\Response $response
     */
    public function callback($request = null, $response = null)
    {
    }


}