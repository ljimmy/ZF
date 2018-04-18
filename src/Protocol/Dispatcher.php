<?php

namespace SF\Protocol;

use SF\Contracts\Protocol\Dispatcher as DispatcherInterface;
use SF\Contracts\Protocol\Message;
use SF\Contracts\Protocol\Router;

class Dispatcher implements DispatcherInterface
{
    /**
     * @var Middleware
     */
    public $middleware;

    public function __construct(Middleware $middleware)
    {
        $this->middleware = $middleware;
    }

    public function dispatch(Message $message, Router $router)
    {
        return $this->middleware->process($message, $router->handle($message));
    }


}