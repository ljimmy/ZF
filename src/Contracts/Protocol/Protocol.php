<?php

namespace SF\Contracts\Protocol;


interface Protocol
{
    public function handle(Receiver $receiver, Replier $replier): string;

    public function getDispatcher(): Dispatcher;

    public function getRouter(): Router;

    public function getMiddleware(): \SF\Protocol\Middleware;
}