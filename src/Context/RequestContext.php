<?php

namespace SF\Context;

use SF\Http\Request;
use SF\Http\Response;
use SF\Context\CoroutineContext;

class RequestContext
{

    /**
     *
     * @var int
     */
    public $id;

    /**
     *
     * @var array
     */
    private static $map;

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
     *
     * @var CoroutineContext
     */
    private $coroutineContext;

    public function __construct(Request $request, Response $response, CoroutineContext $coroutineContext)
    {
        $id               = $coroutineContext->getid();
        $this->id         = $id;
        $this->request    = $request;
        $this->response   = $response;
        self::$map[$id] = $this;
    }

    /**
     *
     * @return \SF\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     *
     * @return \SF\Http\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    public static function get(int $id)
    {
        return self::$map[$id] ?? null;
    }

    public function getCoroutineContext()
    {
        return $this->coroutineContext;
    }

    public function destroy()
    {
        $this->request          = null;
        $this->response         = null;
        $this->id               = null;
        $this->coroutineContext = null;

        unset(self::$map[$this->id]);
    }

}
