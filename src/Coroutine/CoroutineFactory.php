<?php

namespace SF\Coroutine;

use SF\Support\PHP;
use SF\Context\CoroutineContext;

class CoroutineFactory
{
    public static function create(callable $callback)
    {
        $std = new \stdClass();
        $coroutineId = CoroutineContext::getTop();

        $closure = function () use ($callback, $coroutineId, $std) {
            $coroutineContext = new CoroutineContext($coroutineId);
            $std->result = PHP::call($callback, [$coroutineContext]);
            $coroutineContext->exitContext();
        };
        Coroutine::create($closure);
        return $std->result;
    }

}
