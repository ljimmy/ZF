<?php

namespace SF\Protocol;

use SF\Contracts\Protocol\Middleware as MiddlewareInterface;
use SF\Contracts\Protocol\Replier;

/**
 * Class Middleware
 * @package SF\Protocol
 * @deprecated
 */
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

    public function process(Message $message, Action $action): Replier
    {
        $result = array_reduce(array_merge($this->list, array_values($action->getMiddlewares())), function($stack, MiddlewareInterface $middleware) {
            return function($message) use ($middleware, $stack) {
                return $middleware->handle($message, $stack);
            };
        }, function() use ($action) {
            return $action->run();
        });
        return $result($message);
    }

}
