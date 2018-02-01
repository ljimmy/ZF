<?php

namespace SF\Events\Server\Http;

use SF\Events\Server\AbstractServerEvent;
use SF\Server\AbstractServer;
use SF\Context\RequestContext;
use SF\Context\CoroutineContext;
use SF\Http\Request as HttpRequest;
use SF\Http\Response as HttpResponse;
use SF\Http\Exceptions\HttpException;

class Request extends AbstractServerEvent
{

    /**
     *
     * @var \SF\Http\HttpServer
     */
    private $application;

    /**
     *
     * @var \SF\Http\Dispatcher
     */
    private $dispatcher;

    /**
     *
     * @var \SF\Http\RouteInterface
     */
    private $route;

    public function __construct(AbstractServer $application)
    {
        $this->application = $application;
        $this->route       = $application->getRoute();
        $this->dispatcher  = $application->getDispatcher();
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
            $this->run($requestContext->getRequest(), $requestContext->getResponse());
        } catch (\Exception $e) {
            throw $e;
        } finally {
            $requestContext->destroy();
            unset($requestContext);
        }
    }

    public function run(HttpRequest $request, HttpResponse $response)
    {
        $result = null;
        try {
            $result = $this->dispatcher->dispatch($request, $this->route);
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
