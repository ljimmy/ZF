<?php

namespace SF\Protocol;

use SF\Contracts\Protocol\Action as ActionInterface;
use SF\Contracts\Protocol\Middleware as MiddlewareInterface;
use SF\Support\PHP;

class Action implements ActionInterface
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
     * @var MiddlewareInterface[]
     */
    private $middleware = [];

    public function getMethods()
    {
        return $this->methods;
    }

    public function setMethods($methods)
    {
        $this->methods = $methods;
    }

    public function setHandler(\Closure $handler = null)
    {
        $this->handler = $handler;
    }

    public function isSetHandler(): bool
    {
        return null !== $this->handler;
    }

    public function addParams(array $params = [])
    {
        $this->params = array_merge($this->params, $params);
    }

    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middleware[] = $middleware;
    }


    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    public function run()
    {
        if ($this->handler === null) {
            return null;
        }

        return PHP::call($this->handler, $this->params);
    }


}