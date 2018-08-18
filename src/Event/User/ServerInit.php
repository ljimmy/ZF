<?php

namespace SF\Event\User;

use SF\Process\Process;
use SF\Contracts\Event\User;
use SF\Event\EventTypes;
use SF\Event\EventManager;

class ServerInit implements User
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getType()
    {
        return EventTypes::SERVER_INIT;
    }

    public function handle()
    {
        $container    = $this->container;
        Process::signal(SIGUSR1, function () use ($container) {
            $container->get(EventManager::class)->trigger(EventTypes::SERVER_RELOAD);
        });
    }


}