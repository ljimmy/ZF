<?php

namespace SF\Events\Server\Http;

use SF\Events\EventTypes;
use SF\Events\Server\AbstractServerEvent;
use SF\Context\RequestContext;
use SF\Context\CoroutineContext;
use SF\Http\Request as HttpRequest;
use SF\Http\Response as HttpResponse;
use SF\Http\Exceptions\HttpException;
use SF\Server\AbstractServer;

class Request extends AbstractServerEvent
{

    /**
     *
     * @var \SF\Http\HttpServer
     */
    private $application;

    public function __construct(AbstractServer $application)
    {
        $this->application = $application;
    }

    public function on($server)
    {
        $server->on('Request', [$this, 'callback']);
    }

    public function callback($request = null, $response = null)
    {
        //初始化请求上下文
        $requestContext = new RequestContext(new HttpRequest($request), new HttpResponse($response), /* 启用协程 */ new CoroutineContext());
        try {
            $requestContext->enter();
            $this->application->triggerEvent(EventTypes::BEFORE_REQUEST);
            $this->run($requestContext->getRequest(), $requestContext->getResponse());
            $this->application->triggerEvent(EventTypes::AFTER_REQUEST);
        } catch (\Exception $e) {
            throw $e;
        } finally {
            $requestContext->exitContext();
            unset($requestContext);
        }
    }

    public function run(HttpRequest $request, HttpResponse $response)
    {
        $result = null;
        try {
            $result = $this->application->getDispatcher()->dispatch($request, $this->application->getRoute());
        } catch (HttpException $http) {
            $response->withStatus($http->statusCode, $http->getMessage());
        }

        if ($result && $result instanceof HttpResponse) {
            $result->send();
        } else {
            $response->auto($result, $request->getHeader('Accept'))->send();
        }
    }

}
