<?php
/**
 * Created by PhpStorm.
 * User: xfb_user
 * Date: 2018/4/17
 * Time: 下午3:42
 */

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