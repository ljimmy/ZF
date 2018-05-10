<?php

namespace SF\Protocol;

use SF\Contracts\IoC\Object;
use SF\Contracts\Protocol\Dispatcher as DispatcherInterface;
use SF\Contracts\Protocol\Router;
use SF\Contracts\Protocol\Server;
use SF\Event\EventManager;
use SF\IoC\Container;

abstract class AbstractServer implements Server, Object
{

    /**
     * @var Router
     */
    public $router;

    /**
     * @var DispatcherInterface
     */
    public $dispatcher = Dispatcher::class;

    /**
     * @var Middleware
     */
    public $middleware = [];

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var EventManager;
     */
    protected $eventManager;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function init()
    {
        $this->eventManager = $this->container->get(EventManager::class);
        $this->router       = $this->container->get($this->router);

        $this->dispatcher = $this->container->make($this->dispatcher);

        $this->middleware = new Middleware((array) $this->middleware);
    }

    public function getDispatcher(): DispatcherInterface
    {
        return $this->dispatcher;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function getMiddleware(): Middleware
    {
        return $this->middleware;
    }

}
