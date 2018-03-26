<?php

namespace SF\Protocol\Middlewares;

use SF\Protocol\Message\ReceiveInterface;
use SF\Protocol\Message\ReplyInterface;

interface MiddlewareInterface
{
    public function handle(ReceiveInterface $receive, \Closure $next): ReplyInterface;
}