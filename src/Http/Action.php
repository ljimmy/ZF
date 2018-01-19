<?php

namespace SF\Http;

use SF\Support\PHP;
use SF\Http\Middlewares\MiddlewareInterface;

class Action
{

    /**
     *
     * @var array
     */
    private $methods;

    /**
     *
     * @var \Closure
     */
    private $handler;

    /**
     *
     * @var array
     */
    private $params = [];

    /**
     *
     * @var Middlewares\MiddlewareInterface[]
     */
    private $middlewares = [];

    public function setMethods(array $methods = null)
    {
        $this->methods = $methods;

        return $this;
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function setHandler(\Closure $handler = null)
    {
        $this->handler = $handler;

        return $this;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function addParams(array $params = [])
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    public function addMiddlewares(array $middlewares)
    {
        $this->middlewares = array_merge($this->middlewares, $middlewares);

        return $this;
    }

    public function run()
    {
        if ($this->handler === null) {
            return null;
        }
        return PHP::call($this->handler, $this->params);
    }

}
