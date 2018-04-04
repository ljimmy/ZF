<?php
/**
 * Created by PhpStorm.
 * User: xfb_user
 * Date: 2018/4/4
 * Time: 下午5:41
 */

namespace SF\Protocol\Rpc\Exceptions;


use Throwable;

class AcceptException extends RpcException
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
     * @var int
     */
    public $status;

    public function __construct(int $status, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->status = $status;
        parent::__construct($message, $code, $previous);
    }

}