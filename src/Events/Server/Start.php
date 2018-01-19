<?php

namespace SF\Events\Server;

use SF\Events\EventInterface;

class Start implements EventInterface
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
        $this->saveMasterPid($server->master_pid);
        $this->saveMasterPid($server->manager_pid);
        setProcessTitle('SF Master Process');
    }

    private function saveMasterPid($pid)
    {

    }

    private function saveManagerPid($pid)
    {

    }

}
