<?php

namespace SF\Events\Server;

use SF\Context\ApplicationContext;
use SF\Server\Application;

class WorkerStart extends AbstractServerEvent
{
    private $application;


    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     *
     * @param \Swoole\Server $server
     * @param int $workerId
     */
    public function callback($server = null, int $workerId = 0)
    {
        (new ApplicationContext($this->application))->enter();
    }

    public function on($server)
    {
        $server->on('WorkerStart', [$this, 'callback']);
    }

}
