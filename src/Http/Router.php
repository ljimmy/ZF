<?php

namespace SF\Http;

use SF\Contracts\IoC\Object;
use SF\Contracts\Protocol\Action;
use SF\Contracts\Protocol\Message;
use SF\Contracts\Protocol\Router as RouterInterface;
use SF\Exceptions\UserException;
use SF\Exceptions\Http\NotFoundHttpException;
use SF\Exceptions\Http\MethodNotAllowedHttpException;
use SF\Protocol\Http\Request;
use SF\Routing\RouteTable;

class Router implements RouterInterface, Object
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
     *         'middleware' => [],
     *         'handler' => function($param_1, $param_2){}
     *     ],
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
     *     ]
     * ]
     * ```
     *
     * @var array
     */
    public $rules = [];
    /**
     *
     * @var RouteTable
     */
    private $routeTable;

    public function init()
    {
        $this->routeTable = new RouteTable();

        foreach ($this->rules as $rule) {
            $this->routeTable->add( (array) $rule);
        }

    }

    public function handle(Message $message): Action
    {
        if (!$message instanceof Request) {
            throw new UserException('Message must instanceof Request');
        }

        $path = rtrim($message->getServer('path_info'), '/');
//        if ($path[-1] !== '/') {
//            $path .= '/';
//        }
        if ($path == '') {
            $path = '/';
        }
        $action = $this->routeTable->find(rawurldecode($path), new \SF\Protocol\Action($message->getMethod()));

        if (!$action->isSetHandler()) {
            throw new NotFoundHttpException();
        }

        return $action;
    }


}