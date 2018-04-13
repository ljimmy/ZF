<?php

namespace SF\Protocol\Rpc;


use SF\Support\Collection;

/**
 * Class Header
 * @property int id 消息id
 * @property int length 长度
 * @property int version 版本号
 * @property int flavor Authentication
 * @property int credentials 校验凭证
 * @package SF\Protocol\Rpc
 */
class Header extends Collection
{
    const HEADER_LENGTH = 192;

    /**
     * @param string $data
     *
     * header structure:
     *
     * 0    1    2    3    4    5    6    7    8   byte
     *
     * 0    8   16   24   32   40   48   56   64   bit
     * -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     * |                  id                  |
     * -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     * |   length                   | version |
     * -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     * |flavor|   Authentication credential   |       //Authentication flavor Number see SF\Protocol\Rpc\Authenticator
     * -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     * 
     * -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
     *
     * @return $this
     */
    public function load(string $data)
    {

        $this->id = substr($data, 0, 64);
        $this->length = substr($data, 64, 48);
        $this->version = substr($data, 112, 16);
        $this->flavor = substr($data, 128, 8);
        $this->credentials = substr($data, 136, 56);

        return $this;
    }

}