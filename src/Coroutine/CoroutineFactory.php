<?php

namespace SF\Coroutine;

use SF\Support\PHP;
use SF\Context\CoroutineContext;

class CoroutineFactory
{
    public static function create(callable $callback)
    {
        $std              = new \stdClass();
        $coroutineContext = new CoroutineContext(CoroutineContext::getTop());

        $closure = \Closure::bind(function () use ($callback, $coroutineContext) {
                    $this->result = PHP::call($callback, [$coroutineContext]);
                }, $std);

        Coroutine::create($closure);

        $coroutineContext->destroy();
        unset($coroutineContext);
        return $std->result;
    }

}
