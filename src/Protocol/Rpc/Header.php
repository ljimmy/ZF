<?php

namespace SF\Protocol\Rpc;


use SF\Support\Collection;

/**
 * Class Header
 *
 * structure:
 *
 * 0    1    2    3    4    5    6    7    8   byte
 *
 * 0    8   16   24   32   40   48   56   64   bit
 * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 * |                  id                   |
 * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 * |   length          | version | flavor  |
 * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 * |       Authentication credential       |      //Authentication flavor Number see SF\Protocol\Rpc\Authenticator
 * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 * |module
 * +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
 *
 *
 * @property int id 消息id
 * @property int length 长度
 * @property int version 版本号
 * @property int flavor Authentication
 * @property int credentials 校验凭证
 * @package SF\Protocol\Rpc
 */
class Header extends Collection
{
    const HEADER_LENGTH = 24;//bytes

    /**
     * @param string $data
     *

     * @return $this
     */
    public static function load(string $data)
    {
        return new self(unpack('Jid/Nlength/nversion/nflavor/Jcredential',substr($data, 0, self::HEADER_LENGTH)));
    }

}