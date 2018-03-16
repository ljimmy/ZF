<?php

namespace SF\Events\Server;

use SF\Server\AbstractServer;
use SF\Support\PHP;

class Start extends AbstractServerEvent
{

    public function on($server)
    {
        $server->on('Start', [$this, 'callback']);
    }

    /**
     *
     * @param \Swoole\Server $server
     */
    public function callback($server = null)
    {
        save_pid($server->master_pid, $server->manager_pid);
        setProcessTitle('SF Master Process');
    }
}
