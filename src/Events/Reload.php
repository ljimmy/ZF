<?php

namespace SF\Events;


use SF\Application\Application;
use SF\Contracts\Event\Event;
use SF\IoC\Container;

class Reload implements Event
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