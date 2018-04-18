<?php

namespace SF\Context;

use SF\Contracts\Context\Context;
use SF\Contracts\Protocol\Http\Request;
use SF\Contracts\Protocol\Http\Response;

class RequestContext implements Context
{

    /**
     *
     * @var array
     */
    private static $map;
    /**
     *
     * @var int
     */
    public $id;
    /**
     *
     * @var Request
     */
    private $request;

    /**
     *
     * @var Response
     */
    private $response;

    /**
     * @var CoroutineContext
     */
    private $coroutineContext;

    public function __construct(Request $request, Response $response, CoroutineContext $coroutineContext)
    {
        $this->id               = $coroutineContext->getId();
        $this->request          = $request;
        $this->response         = $response;
        $this->coroutineContext = $coroutineContext;
    }

    public static function get(int $id)
    {
        return self::$map[$id] ?? null;
    }

    public function enter()
    {
        self::$map[$this->id] = $this;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function exitContext()
    {
        $this->coroutineContext->exitContext();

        $this->request          = null;
        $this->response         = null;
        $this->id               = null;
        $this->coroutineContext = null;

        unset(self::$map[$this->id]);
    }

}
