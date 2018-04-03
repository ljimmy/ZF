<?php

namespace SF\Protocol\Rpc\Structure;


use SF\Protocol\Rpc\RpcException;

class Rejected extends Replier
{
    /**
     * RPC version number != 2
     */
    const RPC_MISMATCH = 0;

    /**
     * remote can't authenticate caller
     */
    const AUTH_ERROR = 1;

    /**
     * @var reject stat
     */
    public $status;

    /**
     * @var int
     */
    public $low;

    /**
     * @var int
     */
    public $high;

    public $authStat;

    /**
     *
     * RPC_MISMATCH
     * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     * xid = <10>|reply_stat = <1>|reject_stat = <1>|low = <2>|high = <2>
     * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     *
     * AUTH_ERROR
     * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
     * xid = <10>|reply_stat = <1>|reject_stat = <1>|auth_stat = <2>|
     * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
     *
     * @return string
     */

    public function reply(): string
    {
        $data = $this->fill($this->xid, 10) . self::DENIED;

        switch ($this->status) {
            case self::RPC_MISMATCH:
                $data .= self::RPC_MISMATCH . $this->fill($this->low, 2) . $this->fill($this->high, 2);
                break;
            case self::AUTH_ERROR:
                $data .= self::AUTH_ERROR . $this->fill($this->authStat, 2);
                break;
            default:
                throw new RpcException('invalid reject status.');
        }

        return $data;
    }


    /**
     * @param int $error Authentication error
     */
    public function authError(int $error)
    {
        $this->status = self::AUTH_ERROR;
        $this->authStat = $error;
    }

    public function mismatch(int $low, int $high)
    {
        $this->status = self::RPC_MISMATCH;
        $this->low = $low;
        $this->high = $high;
    }


}