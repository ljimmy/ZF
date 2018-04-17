<?php

namespace SF\Http;

use SF\Contracts\Http\Middleware as MiddlewareInterface;

class Middleware
{

    public $middlewares = [];

    public function init()
    {
        $middlewares = [];
        foreach ($this->middlewares as $middlewareClass) {
            $middleware = new $middlewareClass();

            if ($middleware instanceof MiddlewareInterface) {
                $middlewares[] = $middleware;
            }
        }
        $this->middlewares = $middlewares;
    }

    public function process(Request $request, Action $action)
    {
        $result = array_reduce(array_merge($this->middlewares, array_values($action->getMiddlewares())), function($stack, MiddlewareInterface $middleware) {
            return function($request) use ($middleware, $stack) {
                return $middleware->handle($request, $stack);
            };
        }, function() use ($action) {
            return $action->run();
        });
        return $result($request);
    }

}
