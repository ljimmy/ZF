<?php

namespace SF\Contracts\Protocol;

interface Action
{

    public function setMethods($methods);

    public function getMethods();

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