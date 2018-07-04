<?php

namespace SF\Protocol\Rpc;

use SF\Contracts\Protocol\Authenticator as AuthenticatorInterface;
use SF\Contracts\Protocol\Message;
use SF\Exceptions\Rpc\Denied\AuthException;

class Authenticator implements AuthenticatorInterface
{

    /**
     * authentication flavor numbers
     */

    const AUTH_NONE = 0;/* no authentication, see RFC 1831 */

    const AUTH_UNIX = 1;/* unix style (uid+gids), RFC 1831 */

    const AUTH_SHORT = 2;/* short hand unix style, RFC 1831 */

    const AUTH_DES = 3;/* des style (encrypted timestamp) */

    const AUTH_KERB = 4; /* kerberos auth, see RFC 2695 */

    const AUTH_RSA = 5;/* RSA authentication */

    const RPCSEC_GSS = 6;/* GSS-based RPC security for auth,integrity and privacy, RPC 5403 */


    public $allow = [
        self::AUTH_NONE
    ];


    public function validate(Message $message)
    {
        $flavor = $message->getPackageHeader('flavor');

        if (!in_array($flavor, $this->allow)) {
            throw new AuthException(AuthException::AUTH_BADVERF);
        }

        switch ($flavor) {
            case self::AUTH_NONE:
                break;
            default:
                throw new AuthException(AuthException::AUTH_BADVERF);
        }

        return true;
    }

    public function generate(Message $message): string
    {
        $credentials = '';

        $flavor = $message->getPackageHeader('flavor');
        switch ($flavor) {
            case self::AUTH_NONE:
                break;
            default:
                break;
        }

        return $credentials;
    }


}