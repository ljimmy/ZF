<?php

namespace SF\Middleware;


use SF\Context\ContextTrait;
use SF\Contracts\Protocol\Message;
use SF\Contracts\Protocol\Middleware;

class Cors implements Middleware
{
    use ContextTrait;

    public $accessControlAllowOrigin;
    public $accessControlAllowMethods;
    public $accessControlAllowHeaders;
    public $accessControlMaxAge;
    public $accessControlAllowCredentials;

    public function __construct(
        $accessControlAllowOrigin = '*',
        $accessControlAllowMethods = 'POST, GET, OPTIONS, PUT, DELETE',
        $accessControlAllowHeaders = '*',
        $accessControlMaxAge = '86400',
        $accessControlAllowCredentials = true
    )
    {
        $this->accessControlAllowOrigin = $accessControlAllowOrigin;
        $this->accessControlAllowMethods = $accessControlAllowMethods;
        $this->accessControlAllowHeaders = $accessControlAllowHeaders;
        $this->accessControlMaxAge = $accessControlMaxAge;
        $this->accessControlAllowCredentials = $accessControlAllowCredentials;
    }

    public function handle(Message $message, \Closure $next)
    {

        $response = $this->getRequestContext()->getResponse();

        $response->withHeader('Access-Control-Allow-Origin', $this->accessControlAllowOrigin)
                ->withHeader('Access-Control-Allow-Methods', $this->accessControlAllowMethods)
                ->withHeader('Access-Control-Allow-Headers', $this->accessControlAllowHeaders)
                ->withHeader('Access-Control-Max-Age', $this->accessControlMaxAge)
                ->withHeader('Access-Control-Allow-Credentials', $this->accessControlAllowCredentials ? 'true' : 'false');

        if ($message->getMethod() == 'OPTIONS') {
            return '';
        }
        return $next($message);
    }

}