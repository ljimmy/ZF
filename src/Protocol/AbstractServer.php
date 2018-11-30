<?php

namespace SF\Protocol;

use SF\Contracts\IoC\Instance;
use SF\Contracts\Protocol\Dispatcher as DispatcherInterface;
use SF\Contracts\Protocol\Router;
use SF\Contracts\Protocol\Server;
use SF\Event\EventManager;
use SF\IoC\Container;

abstract class AbstractServer implements Server, Instance
{

    /**
     * @var Router
     */
    public $router;

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

    /**
     * @var DispatcherInterface
     */
    protected $dispatcher = Dispatcher::class;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function init()
    {
        $this->eventManager = $this->container->get(EventManager::class);
        $this->router = $this->container->make($this->router);

        $this->dispatcher = new Dispatcher(new Middleware((array)$this->middleware));
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
