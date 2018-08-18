<?php

namespace SF\Protocol;

use SF\Contracts\Protocol\Action;
use SF\Contracts\Protocol\Message;
use SF\Contracts\Protocol\Middleware as MiddlewareInterface;

class Middleware
{

    private $list = [];

    public function __construct(array $middlewares = [])
    {
        $this->init();
    }

    public function init(array $list = [])
    {
        $this->list = [];

        foreach ($list as $class) {
            $middleware = new $class();

            if ($middleware instanceof MiddlewareInterface) {
                $this->list[] = $middleware;
            }
        }
    }

    public function process(Message $message, Action $action)
    {
        $stack = array_reduce(array_reverse(array_merge($this->list, array_values($action->getMiddleware()))),
            function ($stack, MiddlewareInterface $middleware) {
                return function ($message) use ($middleware, $stack) {
                    return $middleware->handle($message, $stack);
                };
            }, function ($message) use ($action) {
                return $action->run($message);
            });
        return $stack($message);
    }

}
