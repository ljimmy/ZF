<?php
/**
 * Created by PhpStorm.
 * User: xfb_user
 * Date: 2018/4/13
 * Time: 下午4:51
 */

namespace SF\Contracts\Support;


interface Jsonable
{
    public function toJson($options = 0);

}