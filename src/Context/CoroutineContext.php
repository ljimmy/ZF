<?php

namespace SF\Context;

use SF\Contracts\Context\Context;
use SF\Coroutine\Coroutine;

class CoroutineContext implements Context
{

    protected $id;

    /**
     *
     * @var array
     */
    protected static $stack = [];

    public function __construct(int $previous = Coroutine::ID)
    {
        $this->id = $previous;
    }

    public static function getStackTopId(): int
    {
        $id = Coroutine::getuid();
        return self::$stack[$id] ?? $id;
    }

    public function enter()
    {
        if ($this->id === Coroutine::ID) {
            $this->id = Coroutine::getuid();
        }

        self::$stack[Coroutine::getuid()] = $this->id;
    }

    public function exitContext()
    {
        unset(self::$stack[Coroutine::getuid()]);
    }

}
