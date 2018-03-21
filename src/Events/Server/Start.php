<?php

namespace SF\Events\Server;

use SF\Process\Process;
use SF\Server\AbstractServer;

class Start extends AbstractServerEvent
{
    private $server;

    public function __construct(AbstractServer $server)
    {
        $this->server = $server;
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
        save_pid($server->master_pid, $server->manager_pid);
        setProcessTitle('SF Master Process');
        $this->registerReload();
    }

    public function registerReload()
    {
        Process::signal(SIGUSR1, function() {
            $this->server->reload();
        });
    }

}
