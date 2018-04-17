<?php

namespace SF\Http\Routing;

use SF\Contracts\Http\Router as RouterInterface;
use SF\Http\Action;
use SF\Http\Exceptions\MethodNotAllowedHttpException;
use SF\Http\Exceptions\NotFoundHttpException;
use SF\Http\Request;

class Router implements RouterInterface
{

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
    /**
     *
     * @var RouteTable
     */
    private $routeTable;

    public function __construct()
    {
        $this->routeTable = new RouteTable();
    }

    public function init()
    {
        foreach ((array)$this->rules as $rule) {
            $this->routeTable->add((array)$rule);
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
