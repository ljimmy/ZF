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
    /**
     * @return Middleware[]
     */
    public function getMiddleware(): array ;

    public function run();
}