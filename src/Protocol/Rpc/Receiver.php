<?php

namespace SF\Protocol\Rpc;

use SF\Protocol\ProtocolServiceProvider;
use SF\Protocol\ReceiverInterface;
use SF\Protocol\Rpc\Exceptions\Accept\ProgMisMatchException;
use SF\Protocol\Rpc\Exceptions\AcceptException;
use SF\Protocol\Rpc\Exceptions\Denied\RpcMisMatchException;

class Receiver extends Message implements ReceiverInterface
{
    /**
     * RPC 协议号
     * must be equal to two (2)
     *
     * @var int
     */
    public $rpcvers;

    /**
     * 远程程序号
     * @var int
     */
    public $prog = 100017; /* remote execution */

    /**
     * 程序版本号
     * @var int
     */
    public $vers = 1;

    /**
     * 远程过程号
     * @var int
     */
    public $proc;

    /**
     * @var \SF\Protocol\AuthenticatorInterface
     */
    public $authenticator;

    public function __construct(ProtocolServiceProvider $provider)
    {
        $this->authenticator = $provider->getProtocol()->getAuthenticator();
    }


    /**
     * @param string $data
     *
     * 0         64            65         71         75         77         79          479
     * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     * xid = <64>|rpcvers = <1>|prog = <6>|vers = <4>|proc = <2>|flavor = <2>|cred = <400>
     * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     *
     * @throws
     * @return \SF\Protocol\Message
     */
    public function receive(string $data): \SF\Protocol\Message
    {
        $this->header = substr($data, 0, 479);
        $this->body   = substr($data, 479);

        $this->xid     = substr($data, 0, 64);

        $this->rpcvers = (int)substr($data, 64, 1);
        if ($this->rpcvers != 2) {
            throw new RpcMisMatchException(2, 2);
        }

        $prog    = (int) substr($data, 65, 6);

        if ($prog != $this->prog) {
            throw new AcceptException(AcceptException::PROG_UNAVAIL);
        }

        $this->vers    = substr($data, 71, 4);

        $this->proc    = substr($data, 75, 2);

        $this->authenticator->validate(substr($data, 77, 2), (string)substr($data, 79, 400));

        return $this;
    }
}