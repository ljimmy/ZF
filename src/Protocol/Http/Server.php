<?php

namespace SF\Protocol\Http;


use SF\Context\CoroutineContext;
use SF\Context\RequestContext;
use SF\Contracts\IoC\Object;
use SF\Contracts\Protocol\Dispatcher;
use SF\Contracts\Protocol\Receiver;
use SF\Contracts\Protocol\Replier;
use SF\Contracts\Protocol\Router as RouterInterface;
use SF\Contracts\Protocol\Server as ServerInterface;
use SF\Events\EventManager;
use SF\Events\EventTypes;
use SF\Http\Exceptions\HttpException;
use SF\Http\Router;
use SF\IoC\Container;
use SF\Protocol\Middleware;

class Server implements ServerInterface, Object
{
    /**
     * @var RouterInterface
     */
    public $router = Router::class;

    /**
     * @var Dispatcher
     */
    public $dispatcher = \SF\Protocol\Dispatcher::class;

    /**
     * @var Middleware
     */
    public $middleware = Middleware::class;

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
        $this->container = $container;
    }

    public function init()
    {
        $this->eventManager = $this->container->get(EventManager::class);
        $this->router       = $this->container->get(Router::class);
        $this->dispatcher   = $this->container->make($this->dispatcher);

        $this->middleware = new Middleware((array)$this->middleware);
    }

    public function getName()
    {
        return self::NAME;
    }


    public function handle(Receiver $receiver, Replier $replier): string
    {
        $requestContent = new RequestContext($receiver->unpack(), new Response(), /* 开启协程 */ new CoroutineContext());

        try {
            $requestContent->enter();
            $this->eventManager->trigger(EventTypes::BEFORE_REQUEST);

            /** {{{
             *
             * request start
             *
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

    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    public function getMiddleware(): Middleware
    {
        return $this->middleware;
    }


}