<?php

namespace SF\Event\Server;

use Swoole\Server;
use SF\IoC\Container;
use SF\Event\EventTypes;
use SF\Event\EventManager;
use SF\Event\User\ServerReload;

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
        $container    = $this->container;
        $eventManager = $container->get(EventManager::class);

        if (!$eventManager->has(EventTypes::SERVER_RELOAD)) {
            $eventManager->on($container->get(ServerReload::class));
        }

        return function (Server $server) use ($container) {
            save_pid($server->master_pid, $server->manager_pid);
            setProcessTitle('SF Master Process');

            $container->get(EventManager::class)->trigger(EventTypes::SERVER_START);
        };
    }

}
