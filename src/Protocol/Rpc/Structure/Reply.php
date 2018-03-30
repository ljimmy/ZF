<?php
/**
 * Created by PhpStorm.
 * User: xfb_user
 * Date: 2018/3/30
 * Time: 下午7:01
 */

namespace SF\Protocol\Rpc\Structure;


class Reply
{
    const ACCEPTED = 0;

    const DENIED = 1;

    /**
     * RPC executed successfully
     */
    const ACCEPT_SUCCESS = 0;

    /**
     * remote hasn't exported program
     */
    const ACCEPT_PROG_UNAVAIL = 1;

    /**
     * remote can't support version
     */
    const ACCEPT_PROG_MISMATCH = 2;

    /**
     * program can't support procedure
     */
    const ACCEPT_PROC_UNAVAIL = 3;

    /**
     * procedure can't decode params
     */
    const ACCEPT_GARBAGE_ARGS = 4;

    /**
     * e.g. memory allocation failure
     */
    const ACCEPT_SYSTEM_ERR = 5;

    /**
     * RPC version number != 2
     */
    const REJECT_RPC_MISMATCH = 0;

    /**
     * remote can't authenticate caller
     */
    const REJECT_AUTH_ERROR = 1;

    /**
     * @var int
     */
    public $status;

    /**
     * @var int
     */
    public $errno;


}