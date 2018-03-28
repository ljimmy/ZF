<?php

namespace SF\Protocol;

interface MiddlewareInterface
{
    public function handle(ReceiveInterface $receive, \Closure $next): ReplyInterface;
}