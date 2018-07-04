<?php

namespace SF\Contracts\Protocol;

interface Middleware
{

    public function handle(Message $message, \Closure $next);
}