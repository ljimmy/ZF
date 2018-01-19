<?php

namespace SF\Events\Server;


use SF\Events\EventInterface;
use SF\Context\ApplicationContext;
use SF\Server\AbstractServer;

class WorkerStart implements EventInterface
{
    private $application;


    public function __construct(AbstractServer $application)
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
        new ApplicationContext($this->application);
    }

    public function on($server)
    {
        $server->on('WorkerStart', [$this, 'callback']);
    }

}
