<?php

namespace SF\Events\Server;

use SF\Server\AbstractServer;
use SF\Support\PHP;

class Start extends AbstractServerEvent
{
    private $pid;

    public function __construct(AbstractServer $application)
    {
        $this->pid = $application->getConfig()->get('pid');
    }

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
        if (is_callable($this->pid)) {
            PHP::call($this->pid, [$server->master_pid, $server->manager_pid]);
        } else if (is_string($this->pid)) {
            swoole_async_writefile($this->pid, $server->master_pid.','.$server->manager_pid);
        }
        setProcessTitle('SF Master Process');
    }

    private function saveMasterPid($pid)
    {

    }

    private function saveManagerPid($pid)
    {

    }

}
