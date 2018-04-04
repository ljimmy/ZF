<?php

namespace SF\Protocol\Rpc;

use SF\Protocol\ProtocolServiceProvider;
use SF\Protocol\ReceiverInterface;
use SF\Protocol\Rpc\Exceptions\Denied\RpcMisMatchException;

class Receiver implements ReceiverInterface
{
    /**
     * @var int
     */
    public $xid;
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
    public $prog = 100017;/* remote execution */

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
     * 认证信息 credential
     * @var int
     */
    public $cred;


    /**
     * 凭证 verifier
     * @var int
     */
    public $verf;

    /**
     * @var Protocol
     */
    public $protocol;

    public function __construct(ProtocolServiceProvider $provider)
    {
        $this->protocol = $provider->getProtocol();
    }


    /**
     * @param string $data
     *
     * 0         10            11         17         21         23         25          89
     * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     * xid = <10>|rpcvers = <1>|prog = <6>|vers = <4>|proc = <2>|verf = <2>|cred = <64>|
     * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     *
     * @return \SF\Protocol\Message
     */
    public function receive(string $data): \SF\Protocol\Message
    {
        try {
            $this->getId($data);
            $this->getRpcvers($data);
            $this->getProg($data);
            $this->getVers($data);
            $this->getProc($data);
            $this->getVerf($data);

        } catch (AuthException $authException) {

            return;
        }

        return $this;
    }

    private function getId(string $data)
    {
        return substr($data, 0, 10);
    }


    private function getRpcvers(string $data)
    {
        $this->rpcvers = (int) substr($data, 10, 1);

        if ($this->rpcvers != 2) {
            throw new RpcMisMatchException(2, 2);
        }
    }

    private function getProg(string $data)
    {
        $this->prog = substr($data, 11, 6);
    }

    private function getVers(string $data)
    {
        $this->vers = substr($data, 17, 4);
    }

    private function getProc(string $data)
    {
        $this->proc = substr($data, 21, 2);
    }

    private function getVerf(string $data)
    {
        $this->verf = substr($data, 23, 2);
        
        $this->protocol->getVerifier()->validate($this->verf);
    }


}