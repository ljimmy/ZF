<?php

namespace SF\Routing;

use SF\Contracts\Protocol\Action;
use SF\Contracts\Protocol\Middleware;

class Route
{

    /**
     * 样式
     * @var string
     */
    public $pattern;

    /**
     *
     * @var bool
     */
    public $regex;

    /**
     *
     * @var \Closure
     */
    public $handler;

    /**
     *
     * @var RouteGroup
     */
    private $group;

    /**
     *
     * @var Middleware[]
     */
    private $middleware = [];

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function setIsRegex(bool $regex = false)
    {
        $this->regex = $regex;

        return $this;
    }

    public function setHandler(\Closure $handler = null)
    {
        $this->handler = $handler;

        return $this;
    }

    public function setMiddleware(array $middleware = [])
    {
        $this->middleware = $middleware;

        return $this;
    }

    public function setGroup(RouteGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    public function match(string $path, Action $action)
    {
        $matches = [];
        if ($this->regex) {
            if (preg_match($this->pattern, $path, $matches) == 0) {
                return false;
            }
            $path = substr($path, strlen($matches[0]));
            unset($matches[0]);
        } else {
            if (strpos($path, $this->pattern) !== 0) {
                return false;
            }
            $path = substr($path, strlen($this->pattern));
            if ($path && $path[0] !== '/') {
                return false;
            }

        }

        $action->setHandler($this->handler);
        $action->addParams($matches);
        
        foreach ($this->middleware as $middleware) {
            $action->addMiddleware($middleware);
        }

        if ($this->group === null || $path === '') {
            return true;
        } else {
            return $this->group->match($path, $action);
        }
    }
}