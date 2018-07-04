<?php

namespace SF\Event\User;

use SF\IoC\Container;
use SF\Event\EventTypes;
use SF\Server\Application;
use SF\Contracts\Event\User as UserEvent;

class ServerReload implements UserEvent
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getType()
    {
        return EventTypes::SERVER_RELOAD;
    }

    public function handle()
    {
        $this->container->get(Application::class)->reload();
    }


}