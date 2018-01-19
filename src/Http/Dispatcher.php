<?php

namespace SF\Http;

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

    public function dispatch(Request $request, RouterInterface $route)
    {
        return $this->middleware->process($request, $route->handleHttpRequest($request));
    }

}
