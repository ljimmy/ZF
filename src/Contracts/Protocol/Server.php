<?php

namespace SF\Contracts\Protocol;

interface Server
{

    public function handle(Receiver $receiver, Replier $replier): string;

    public function getDispatcher(): Dispatcher;

    public function getRouter(): Router;
}