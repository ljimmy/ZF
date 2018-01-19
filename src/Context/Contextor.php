<?php

namespace SF\Context;

class Contextor
{

    public $requestContextMap;
    public $coroutineContextMap;

    public function createRequestContext()
    {
        $id                           = '';
        return $this->requestContextMap[$id] = new RequestContext($id, $request, $response);
    }

    public function getRequestContext()
    {

    }

    public function destoryRequestContext()
    {

    }

}
