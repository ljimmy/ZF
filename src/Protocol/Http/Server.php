<?php

namespace SF\Protocol\Http;

use SF\Http\Router;
use SF\Event\EventTypes;
use SF\Coroutine\Coroutine;
use SF\Context\RequestContext;
use SF\Protocol\AbstractServer;
use SF\Contracts\Protocol\Replier;
use SF\Contracts\Protocol\Receiver;
use SF\Exceptions\Http\HttpException;

class Server extends AbstractServer
{

    public $router = Router::class;

    public function handle(Receiver $receiver, Replier $replier): string
    {
        $requestContent = new RequestContext($receiver->unpack(), new Response(), /* 开启协程 */ Coroutine::getuid());

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


}