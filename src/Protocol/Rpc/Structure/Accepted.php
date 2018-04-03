<?php

namespace SF\Protocol\Rpc\Structure;


class Accepted
{
    /**
     * RPC executed successfully
     */
    const SUCCESS = 0;

    /**
     * remote hasn't exported program
     */
    const PROG_UNAVAIL = 1;

    /**
     * remote can't support version
     */
    const PROG_MISMATCH = 2;

    /**
     * program can't support procedure
     */
    const PROC_UNAVAIL = 3;

    /**
     * procedure can't decode params
     */
    const GARBAGE_ARGS = 4;

    /**
     * e.g. memory allocation failure
     */
    const SYSTEM_ERR = 5;

    /**
     * AuthenticationFlavor Number
     * @var int
     */
    public $verf;

    public $status;

    public $data;

    public function success(string $data)
    {
        $this->data = $data;
    }

}