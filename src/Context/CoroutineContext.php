<?php

namespace SF\Context;

use SF\Coroutine\Coroutine;

class CoroutineContext
{

    /**
     * 顶层协程ID
     * @var CoroutineContext[]
     */
    private static $list = [];

    /**
     *
     * @var int
     */
    private $id;

    public function __construct(int $top = Coroutine::ID)
    {
        $this->id     = Coroutine::getuid();

        self::$list[$this->id] = $top;
    }

    public function getid()
    {
        return $this->id;
    }

    public static function getTop(int $id = null)
    {
        if ($id === null) {
            $id = Coroutine::getuid();
        }

        return self::$list[$id] ?? $id;

    }

    public function destroy()
    {
        unset(self::$stack[$this->id]);
        $this->id = null;
        $this->top = null;
    }

}
