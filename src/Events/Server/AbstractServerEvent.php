<?php

namespace SF\Events\Server;

use SF\Contracts\Event\Event;
use SF\Events\EventTypes;

abstract class AbstractServerEvent implements Event
{
    public function getType()
    {
        return EventTypes::SERVER_INIT;
    }

    public function handle($server = null)
    {
        $this->on($server);
    }


    abstract public function on($target);

    abstract public function callback();


}