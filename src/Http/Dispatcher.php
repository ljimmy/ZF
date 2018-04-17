<?php

namespace SF\Http;

use SF\Contracts\Http\Router;

class Dispatcher
{


    /**
     *
     * @var Middleware;
     */
    private $middleware;

    public function __construct(Middleware $middleware)
    {
        $this->middleware = $middleware;
    }

    public function dispatch(Request $request, Router $route)
    {
        return $this->middleware->process($request, $route->handleHttpRequest($request));
    }

}
