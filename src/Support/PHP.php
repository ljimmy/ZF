<?php

namespace SF\Support;

use SF\Coroutine\Coroutine;

class PHP
{

    public static function call($callback, array $params = [])
    {
        return Coroutine::call_user_func_array($callback, $params);
    }

}
