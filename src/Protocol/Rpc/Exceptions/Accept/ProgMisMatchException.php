<?php

namespace SF\Protocol\Rpc\Exceptions\Accept;

use SF\Protocol\Rpc\Exceptions\AcceptException;
use Throwable;

class ProgMisMatchException extends AcceptException
{
    /**
     * @var int
     */
    public $low;

    /**
     * @var int
     */
    public $high;

    public function __construct(int $low, int $high, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->low = $low;
        $this->high = $high;
        parent::__construct(self::PROG_MISMATCH, $message, $code, $previous);
    }

}