<?php

namespace SF\Application\Event;

use SF\Context\ApplicationContext;
use SF\IoC\Container;
use Swoole\Server;

class WorkerStart extends AbstractServerEvent
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getName(): string
    {
        return 'WorkerStart';
    }

    public function getCallback(): \Closure
    {
        $container = $this->container;
        return function (Server $server, int $worker_id) use ($container) {
            if ($server->taskworker) {
                $title = 'SF Task Process';
            } else {
                $title = 'SF Worker Process';
            }
            setProcessTitle($title);
            (new ApplicationContext($container, $server))->enter();
        };
    }
}
