<?php

namespace SF\Protocol;

interface MiddlewareInterface
{
    public function handle(Message $message, \Closure $next): ReplierInterface;
}