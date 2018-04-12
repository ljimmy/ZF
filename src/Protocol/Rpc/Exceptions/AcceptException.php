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
     * RPC 成功执行
     */
    const SUCCESS = 0;

    /**
     * 远程没有导出程序
     */
    const PROG_UNAVAIL = 1;

    /**
     * 不支持的版本
     */
    const PROG_MISMATCH = 2;

    /**
     * 不支持的远程过程
     */
    const PROC_UNAVAIL = 3;

    /**
     * 过程不能解析参数
     */
    const GARBAGE_ARGS = 4;

    /**
     * 系统错误
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