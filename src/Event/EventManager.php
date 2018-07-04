<?php

namespace SF\Event;

use SF\Contracts\Event\User as UserEvent;
use SF\Contracts\IoC\Object;
use SF\IoC\Container;

class EventManager implements Object
{

    public $events = [];

    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $eventsList = [];

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function init()
    {
        foreach ($this->events as $event) {
            $this->on($this->container->get($event));
        }
    }

    public function on(UserEvent $event)
    {
        if (isset($this->eventsList[$event->getType()])) {
            $this->eventsList[$event->getType()][] = $event;
        } else {
            $this->eventsList[$event->getType()] = [$event];
        }

        return $this;
    }

    public function off($type, UserEvent $event = null)
    {
        if (!isset($this->eventsList[$type])) {
            return $this;
        }

        if ($event == null) {
            unset($this->eventsList[$type]);
        } else {
            $events = $this->eventsList[$type];
            foreach ($events as $i => $e) {
                if ($e === $events) {
                    unset($this->eventsList[$type][$i]);
                    break;
                }
            }
        }

        return $this;
    }

    public function has($type)
    {
        return isset($this->eventsList[$type]);
    }

    public function triggerEvent(UserEvent $event, ...$args)
    {
        $event->handle(...$args);
    }

    public function trigger($type, ...$args)
    {
        if (!isset($this->eventsList[$type])) {
            return true;
        }

        foreach ($this->eventsList[$type] as $event) {
            $event->handle(...$args);
        }

    }

}
