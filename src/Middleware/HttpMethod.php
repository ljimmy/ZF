<?php

namespace SF\Middleware;

use SF\Contracts\Protocol\Message;
use SF\Contracts\Protocol\Middleware;
use SF\Exceptions\Http\MethodNotAllowedHttpException;

class HttpMethod implements Middleware
{
    protected $allows = [];

    public function __construct(array $allows = [])
    {
        $this->allows = $allows;
    }

    public function handle(Message $message, \Closure $next)
    {
        if (!in_array($message->getMethod(), $this->allows)) {
            throw new MethodNotAllowedHttpException();
        }
        return $next($message);
    }

}