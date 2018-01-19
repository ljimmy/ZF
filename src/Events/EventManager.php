<?php

namespace SF\Events;


class EventManager
{

    public function attach(EventInterface $event, $target)
    {
        $event->on($target);
    }

}
