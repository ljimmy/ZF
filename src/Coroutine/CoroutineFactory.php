<?php

namespace SF\Coroutine;

use SF\Support\PHP;
use SF\Context\CoroutineContext;

class CoroutineFactory
{
    public static function create(callable $callback)
    {
        $std = new \stdClass();
        $coroutineContext = new CoroutineContext(CoroutineContext::getTop());

        $closure = function () use ($callback, $coroutineContext, $std) {
            $std->result = PHP::call($callback, [$coroutineContext]);
        };
        Coroutine::create($closure);

        $coroutineContext->destroy();
        unset($coroutineContext);
        return $std->result;
    }

}
