<?php

namespace SF\Routing;

class RouteGroup
{

    /**
     *
     * @var Route[]
     */
    private $routes = [];

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;

        return $this;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function match(string $path, Action $action)
    {
        foreach ($this->routes as $route) {
            if ($route->match($path, $action)) {
                return true;
            }
        }
        return false;
    }
}