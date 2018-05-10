<?php

namespace SF\Coroutine;

use SF\Support\PHP;
use SF\Context\CoroutineContext;

class CoroutineFactory
{

    public static function run(callable $callback)
    {
        $coroutineContext = new CoroutineContext(Coroutine::getuid());

        $closure = function () use ($coroutineContext, $callback) {
            $coroutineContext->enter();
            PHP::call($callback);
            $coroutineContext->exitContext();
        };
        Coroutine::create($closure);
    }

}
