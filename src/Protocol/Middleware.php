<?php

namespace SF\Protocol;

class Middleware
{

    private $middlewares = [];

    public function __construct(array $middlewares = [])
    {
        $this->init();
    }

    public function init(array $middlewares = [])
    {
        foreach ($this->middlewares as $middlewareClass) {
            $middleware = new $middlewareClass();

            if ($middleware instanceof MiddlewareInterface) {
                $middlewares[] = $middleware;
            }
        }
        $this->middlewares = $middlewares;
    }

    public function process(ReceiveInterface $receive, Action $action): ReplyInterface
    {
        $result = array_reduce(array_merge($this->middlewares, array_values($action->getMiddlewares())), function($stack, MiddlewareInterface $middleware) {
            return function($receive) use ($middleware, $stack) {
                return $middleware->handle($receive, $stack);
            };
        }, function() use ($action) {
            return $action->run();
        });
        return $result($receive);
    }

}
