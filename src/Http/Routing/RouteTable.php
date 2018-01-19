<?php

namespace SF\Http\Routing;

use SF\Http\Action;

class RouteTable
{

    /**
     *
     * @var Route[]
     */
    private $map = [];

    /**
     *
     * @param array $rule
     * ```php
     * $rule =
     *     [
     *         'pattern' => '/a/b',
     *         'handler' => function(){}
     *     ];
     * $rule =
     *     [
     *         'pattern' => '/a/b',
     *         'methods' => ['GET'],
     *         'handler' => function(){}
     *     ];
     * $rule =
     *     [
     *         'pattern' => '/\/a\/b\/(\d+)\/c\/(\w+)',
     *         'methods' => ['GET'],
     *         'regex' => true,
     *         'middlewares' => [],
     *         'handler' => function($param_1, $param_2){}
     *     ];
     * $rule =
     *     [
     *         'pattern' => '/\/a/b\/(\d+)',
     *         'methods' => [],//禁止访问
     *         'regex' => true,
     *         'middlewares' => [],
     *         'handler' => function($param_1){},
     *         'group' =>
     *         [
     *             [
     *                 'pattern' => '/c/d',
     *                 'methods' => ['GET'],
     *                 'middlewares' => [],
     *                 'handler' => function($param_1){}
     *             ],
     *             [
     *                 'pattern' => '/\/c\/(\d)\/d',
     *                 'methods' => ['GET'],
     *                 'handler' => function($param_1, $param_2){}
     *             ]
     *         ],
     *     ];
     * ```
     * @return $this
     */
    public function add(array $rule)
    {
        $route = $this->createRoute($rule);
        if (isset($rule['group'])) {
            $route->setGroup($this->creteaRouteGroup((array) $rule['group']));
        }

        $this->map[] = $route;

        return $this;
    }

    /**
     *
     * @param array $rule
     * @return \SF\Http\Routing\Route
     */
    private function createRoute(array $rule): Route
    {
        return (new Route($rule['pattern'] ?? ''))
                        ->setIsRegex(boolval($rule['regex'] ?? false))
                        ->setMethods($rule['methods'] ?? null)
                        ->setHandler($rule['handler'] ?? null)
                        ->setMiddlewares($rule['middlewares'] ?? []);
    }

    private function creteaRouteGroup(array $group): RouteGroup
    {
        $routeGroup = new RouteGroup;
        foreach ($group as $rule) {
            $routeGroup->addRoute($this->createRoute($rule));
        }
        return $routeGroup;
    }

    /**
     *
     * @param string $path
     * @return Action
     */
    public function find(string $path): Action
    {
        $action = new Action();

        foreach ($this->map as $route) {
            if ($route->match($path, $action)) {
                break;
            }
        }
        return $action;
    }

}
