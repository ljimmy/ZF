<?php

namespace SF\Http\Routing;

use SF\Di\Container;
use SF\Http\Action;
use SF\Http\Request;
use SF\Http\RouterInterface;
use SF\Http\Exceptions\NotFoundHttpException;
use SF\Http\Exceptions\MethodNotAllowedHttpException;

class Router implements RouterInterface
{

    /**
     *
     * @var RouteTable
     */
    private $routeTable;

    /**
     *
     * ```php
     * $rules = [
     *     [
     *         'pattern' => '/a/b',
     *         'handler' => function(){}
     *     ],
     *     [
     *         'pattern' => '/a/b',
     *         'methods' => ['GET'],
     *         'handler' => function(){}
     *     ],
     *     [
     *         'pattern' => '/\/a\/b\/(\d+)\/c\/(\w+)',
     *         'methods' => ['GET'],
     *         'regex' => true,
     *         'middlewares' => [],
     *         'handler' => function($param_1, $param_2){}
     *     ],
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
     *     ]
     * ]
     * ```
     *
     * @var array
     */
    public $rules;

    public function __construct()
    {
        $this->routeTable = new RouteTable();
    }

    public function init()
    {
        foreach ((array) $this->rules as $rule) {
            $this->routeTable->add((array) $rule);
        }
    }

    public function handleHttpRequest(Request $request): Action
    {
        $path = $request->getServer('path_info');
        if ($path[-1] !== '/') {
            $path .= '/';
        }
        $action = $this->routeTable->find(rawurldecode($path));

        if ($action->getHandler() === null) {
            throw new NotFoundHttpException();
        }

        if ($action->getMethods() !== null && !in_array($request->getMethod(), $action->getMethods())) {
            throw new MethodNotAllowedHttpException();
        }

        return $action;
    }

}
