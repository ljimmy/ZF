<?php

namespace SF\Events\Server;

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
