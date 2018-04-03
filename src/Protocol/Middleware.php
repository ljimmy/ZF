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

    public function process(Message $message, Action $action): ReplierInterface
    {
        $result = array_reduce(array_merge($this->middlewares, array_values($action->getMiddlewares())), function($stack, MiddlewareInterface $middleware) {
            return function($message) use ($middleware, $stack) {
                return $middleware->handle($message, $stack);
            };
        }, function() use ($action) {
            return $action->run();
        });
        return $result($message);
    }

}
