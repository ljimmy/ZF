<?php

namespace SF\Context;

use SF\Coroutine\Coroutine;

class CoroutineContext implements InterfaceContext
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
        $this->id = Coroutine::getuid();

        self::$list[$this->id] = $top;
    }

    public function enter()
    {
    }

    public function getId()
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

    public function exitContext()
    {
        unset(self::$list[$this->id]);
        $this->id = null;
    }

}
