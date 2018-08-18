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
    private static $map = [];

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

    protected $property = [];

    public function __construct(Request $request, Response $response, int $id)
    {
        $this->id       = $id;
        $this->request  = $request;
        $this->response = $response;
    }

    public static function get(int $id)
    {
        return self::$map[$id] ?? null;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function setProperty(string $name, $value)
    {
        $this->property[$name] = $value;
    }

    public function getProperty(string $name)
    {
        return $this->property[$name] ?? null;
    }


    public function enter()
    {
        self::$map[$this->id] = $this;
    }

    public function exitContext()
    {
        unset(self::$map[$this->id]);

        $this->id       = null;
        $this->request  = null;
        $this->response = null;
        $this->property = [];
    }

}
