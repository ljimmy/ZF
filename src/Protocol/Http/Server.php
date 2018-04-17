<?php

namespace SF\Protocol\Http;


use SF\Context\RequestContext;
use SF\Contracts\Protocol\Dispatcher;
use SF\Contracts\Protocol\Protocol;
use SF\Contracts\Protocol\Receiver;
use SF\Contracts\Protocol\Replier;
use SF\Contracts\Protocol\Router;
use SF\Di\Container;
use SF\Events\EventManager;
use SF\Events\EventTypes;
use SF\Http\Exceptions\HttpException;
use SF\Protocol\Middleware;

class Server implements Protocol
{
    /**
     * @var Router
     */
    public $router;

    /**
     * @var Dispatcher
     */
    public $dispatcher;

    /**
     * @var Middleware
     */
    public $middleware;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var EventManager;
     */
    protected $eventManager;

    public function __construct(Container $container)
    {
        $this->container    = $container;
        $this->eventManager = $container->get(EventManager::class);
    }

    public function init()
    {
        $this->router     = $this->container->create($this->router);
        $this->dispatcher = $this->container->create($this->dispatcher);

        $this->middleware = new Middleware((array)$this->middleware);
    }

    public function handle(Receiver $receiver, Replier $replier): string
    {
        $requestContent = new RequestContext($receiver->unpack(), new Response());

        try {
            $requestContent->enter();
            $this->eventManager->trigger(EventTypes::BEFORE_REQUEST);

            /** {{{
             * request start
             */
            $result = $this->getDispatcher()->dispatch($requestContent->getRequest(), $this->getRouter());

            if ($result && $result instanceof \SF\Contracts\Protocol\Http\Response) {
                $replier->pack($result);
            } else {
                $requestContent->getResponse()->auto($result, $requestContent->getRequest()->getHeader('Accept'));
                $replier->pack($requestContent->getResponse());
            }
            /* }}} */

            $this->eventManager->trigger(EventTypes::AFTER_REQUEST);
        } catch (HttpException $httpException) {
            $requestContent->getResponse()->withStatus($httpException->statusCode, $httpException->getMessage());
            $replier->pack($requestContent->getResponse());
        } catch (\Exception $e) {
            throw $e;
        } finally {
            $requestContent->exitContext();
        }
        unset($requestContent);

        return '';
    }

    public function getDispatcher(): Dispatcher
    {
        return $this->dispatcher;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function getMiddleware(): Middleware
    {
        return $this->middleware;
    }


}