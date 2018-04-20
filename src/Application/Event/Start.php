<?php

namespace SF\Application\Event;

use SF\Events\EventManager;
use SF\Events\EventTypes;
use SF\IoC\Container;
use SF\Process\Process;
use Swoole\Server;

class Start extends AbstractServerEvent
{


    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getName(): string
    {
        return 'Start';
    }

    public function getCallback(): \Closure
    {
        $container = $this->container;
        return function (Server $server) use ($container){
            save_pid($server->master_pid, $server->manager_pid);
            setProcessTitle('SF Master Process');

            $container->get(EventManager::class)->trigger(EventTypes::SERVER_START);

            Process::signal(SIGUSR1, function () use ($container){
                $container->get(EventManager::class)->trigger(EventTypes::SERVER_RELOAD);
            });
        };
    }
}
