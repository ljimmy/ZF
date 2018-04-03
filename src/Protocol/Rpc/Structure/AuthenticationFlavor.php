<?php

namespace SF\Protocol\Rpc\Structure;


class AuthenticationFlavor
{


    /**
     * authentication flavor numbers
     */

    const AUTH_NONE  = 0;/* no authentication, see RFC 1831 */

    const AUTH_SYS   = 1;/* unix style (uid+gids), RFC 1831 */

    const AUTH_SHORT = 2;/* short hand unix style, RFC 1831 */

    const AUTH_DH    = 3;/* des style (encrypted timestamp) */

    const AUTH_KERB  = 4; /* kerberos auth, see RFC 2695 */

    const AUTH_RSA   = 5;/* RSA authentication */

    const RPCSEC_GSS = 6;/* GSS-based RPC security for auth,integrity and privacy, RPC 5403 */
}