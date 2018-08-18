<?php

namespace SF\Protocol\Http;

use SF\Exceptions\UserException;
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

    public $gzip = true;

    public function handle(Receiver $receiver, Replier $replier): string
    {
        $requestContent = new RequestContext($receiver->unpack(), new Response($this->gzip), /* 开启协程 */ Coroutine::getuid());

        $requestContent->enter();
        try {
            $this->eventManager->trigger(EventTypes::BEFORE_REQUEST);

            /** {{{
             *
             * request start
             *
             */
            try {

                $result = $this->getDispatcher()->dispatch($requestContent->getRequest(), $this->getRouter());
                if ($result && $result instanceof \SF\Contracts\Protocol\Http\Response) {
                    $replier->pack($result);
                } else {
                    $requestContent->getResponse()->auto($result, $requestContent->getRequest()->getHeader('Accept'));
                }
                /* }}} */
            } catch (\Exception $e) {
                throw $e;
            } finally {
                $this->eventManager->trigger(EventTypes::AFTER_REQUEST);
            }
            $replier->pack($requestContent->getResponse());

        } catch (HttpException $httpException) {
            $requestContent->getResponse()->withStatus($httpException->statusCode, $httpException->getMessage());
            $replier->pack($requestContent->getResponse());
        } catch (UserException $userException) {
            $requestContent->getResponse()->withStatus(500, $userException->getMessage());
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