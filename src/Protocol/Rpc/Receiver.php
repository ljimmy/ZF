<?php

namespace SF\Protocol\Rpc;

use SF\Protocol\ReceiverInterface;

class Receiver implements ReceiverInterface
{
    public $type = self::CALL;

    /**
     * RPC 协议号
     * must be equal to two (2)
     *
     * @var int
     */
    public $rpcvers = 2;

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
     * 认证信息
     * @var Authentication
     */
    public $cred;


    //public $verf;


    public function __construct()
    {
    }


    /**
     * @param string $data
     *
     * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     * xid = <10>|rpcvers = <1>|prog = <6>|low = <2>|high = <2>
     * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     *
     * @return \SF\Protocol\Message
     */
    public function receive(string $data): \SF\Protocol\Message
    {
        $id = substr($data, 0, 10);



        return $this;
    }


}