<?php

namespace SF\Contracts\Protocol;

interface Action
{

    public function setHandler(\Closure $handler = null);

    public function isSetHandler(): bool;

    public function addParams(array $params = []);

    /**
     * @return Middleware[]
     */
    public function getMiddleware(): array;

    public function addMiddleware(Middleware $middleware);

    public function run();
}