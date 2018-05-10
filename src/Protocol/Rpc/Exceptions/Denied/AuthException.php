<?php

namespace SF\Protocol\Rpc\Exceptions\Denied;


use SF\Protocol\Rpc\Exceptions\DeniedException;
use Throwable;

class AuthException extends DeniedException
{
    const AUTH_OK = 0;  /* success                                 */

    /*
     * failed at remote end
     */
    const AUTH_BADCRED = 1;  /* 坏的凭证（坏的签名   */

    const AUTH_REJECTEDCRED = 2;  /* 客户端必须开始新的会话 */

    const AUTH_BADVERF = 3;  /* 错误校验（签名破坏）  */

    const AUTH_REJECTEDVERF = 4;  /* 验证过期或失效  */

    const AUTH_TOOWEAK = 5;  /* 安全原因拒绝  */
    /*
     * failed locally
     */
    const AUTH_INVALIDRESP = 6;  /* bogus response verifier        */

    const AUTH_FAILED = 7;  /* reason unknown                 */


    public $status;


    public function __construct(int $status, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->status = $status;
        parent::__construct($message, $code, $previous);
    }

    public function toString()
    {
        return 'Denied: Authenticator fail.[status:' . $this->status . ']';
    }
}