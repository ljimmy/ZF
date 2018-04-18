<?php

namespace SF\Routing;

use SF\Contracts\Protocol\Action;


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
     *         'middleware' => [],
     *         'handler' => function($param_1, $param_2){}
     *     ];
     * $rule =
     *     [
     *         'pattern' => '/\/a/b\/(\d+)',
     *         'methods' => [],//禁止访问
     *         'regex' => true,
     *         'middleware' => [],
     *         'handler' => function($param_1){},
     *         'group' =>
     *         [
     *             [
     *                 'pattern' => '/c/d',
     *                 'methods' => ['GET'],
     *                 'middleware' => [],
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
            $route->setGroup($this->createRouteGroup((array)$rule['group']));
        }

        $this->map[] = $route;

        return $this;
    }

    /**
     * @param array $rule
     * @return Route
     */
    private function createRoute(array $rule): Route
    {
        return (new Route($rule['pattern'] ?? ''))
            ->setIsRegex(isset($rule['regex']) && $rule['regex'] ? true : false)
            ->setMethods($rule['methods'] ?? null)
            ->setHandler($rule['handler'] ?? null)
            ->setMiddleware($rule['middleware'] ?? []);
    }

    private function createRouteGroup(array $group): RouteGroup
    {
        $routeGroup = new RouteGroup;
        foreach ($group as $rule) {
            $routeGroup->addRoute($this->createRoute($rule));
        }
        return $routeGroup;
    }

    /**
     * @param string $path
     * @param Action $action
     * @return Action
     */
    public function find(string $path, Action $action): Action
    {
        foreach ($this->map as $route) {
            if ($route->match($path, $action)) {
                break;
            }
        }
        return $action;
    }

}