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
    const AUTH_BADCRED = 1;  /* bad credential (seal broken)   */

    const AUTH_REJECTEDCRED = 2;  /* client must begin new session  */

    const AUTH_BADVERF = 3;  /* bad verifier (seal broken)     */

    const AUTH_REJECTEDVERF = 4;  /* verifier expired or replayed   */

    const AUTH_TOOWEAK = 5;  /* rejected for security reasons  */
    /*
     * failed locally
     */
    const AUTH_INVALIDRESP = 6;  /* bogus response verifier        */

    const AUTH_FAILED = 7;  /* reason unknown                 */
    /*
     * AUTH_KERB errors; deprecated.  See [RFC2695]
     */
    const AUTH_KERB_GENERIC = 8;  /* kerberos generic error */

    const AUTH_TIMEEXPIRE = 9;    /* time of credential expired */

    const AUTH_TKT_FILE = 10;     /* problem with ticket file */

    const AUTH_DECODE = 11;       /* can't decode authenticator */

    const AUTH_NET_ADDR = 12;     /* wrong net address in ticket */
    /*
     * RPCSEC_GSS GSS related errors
     */
    const RPCSEC_GSS_CREDPROBLEM = 13; /* no credentials for user */

    const RPCSEC_GSS_CTXPROBLEM = 14;   /* problem with context */


    public $status;


    public function __construct(int $status, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->status = $status;
        parent::__construct($message, $code, $previous);
    }

}