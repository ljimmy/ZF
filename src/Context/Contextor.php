<?php

namespace SF\Context;

use SF\Contracts\Context\Context;

class Contextor
{

    /**
     *
     * @var Contextor
     */
    private static $context;

    public static function getContext()
    {
        return self::$context;
    }

    public static function with(Context $context, \Closure $closure = null)
    {
        $previous      = self::$context;
        self::$context = $context;

        try {
            $context->enter();
            if ($closure === null) {
                return null;
            } else {
                return $closure($context);
            }
        } catch (\Exception $e) {
            throw $e;
        } finally {
            $context->exitContext();
            self::$context = $previous;
        }
    }

}
