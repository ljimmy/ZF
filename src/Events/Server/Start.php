<?php

namespace SF\Events\Server;

use SF\Process\Process;
use SF\Server\Application;

class Start extends AbstractServerEvent
{
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
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
            $this->application->reload();
        });
    }

}
